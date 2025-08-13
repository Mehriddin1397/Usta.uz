<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Show form for creating a new order.
     */
    public function create(Master $master)
    {
        if (!$master->is_approved) {
            return redirect()->back()->with('error', 'Bu usta hali tasdiqlanmagan.');
        }

        return view('orders.create', compact('master'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request, Master $master)
    {
        if (!$master->is_approved) {
            return redirect()->back()->with('error', 'Bu usta hali tasdiqlanmagan.');
        }

        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'master_id' => $master->id,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Buyurtma yuborildi.');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if user can view this order
        if (Auth::id() !== $order->user_id && Auth::user()->master?->id !== $order->master_id) {
            abort(403);
        }

        $order->load(['user', 'master.user', 'master.category', 'review']);

        return view('orders.show', compact('order'));
    }

    /**
     * Show user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->with(['master.user', 'master.category'])->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show form for creating a review.
     */
    public function createReview(Order $order)
    {
        // Check if user can review this order
        if (Auth::id() !== $order->user_id || $order->status !== 'completed' || $order->review) {
            abort(403);
        }

        return view('orders.review', compact('order'));
    }

    /**
     * Store a newly created review.
     */
    public function storeReview(Request $request, Order $order)
    {
        // Check if user can review this order
        if (Auth::id() !== $order->user_id || $order->status !== 'completed' || $order->review) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240',
        ]);

        // Handle media uploads
        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $mediaPaths[] = $path;
            }
        }

        Review::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'master_id' => $order->master_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'media_paths' => $mediaPaths,
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Sharh qo\'shildi.');
    }
}
