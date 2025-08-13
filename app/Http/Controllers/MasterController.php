<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Order;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MasterController extends Controller
{
    /**
     * Display the specified master profile.
     */
    public function show(Master $master)
    {
        $master->load(['user', 'category', 'works', 'reviews.user']);
        
        return view('masters.show', compact('master'));
    }

    /**
     * Show master dashboard.
     */
    public function dashboard()
    {
        $master = Auth::user()->master;
        
        if (!$master) {
            return redirect()->route('home')->with('error', 'Siz usta emassiz.');
        }

        $pendingOrders = $master->orders()->pending()->with('user')->get();
        $activeOrders = $master->orders()->whereIn('status', ['accepted', 'in_progress'])->with('user')->get();
        $completedOrders = $master->orders()->completed()->with('user')->latest()->limit(10)->get();

        return view('masters.dashboard', compact('master', 'pendingOrders', 'activeOrders', 'completedOrders'));
    }

    /**
     * Show form for creating a new work.
     */
    public function createWork()
    {
        $master = Auth::user()->master;
        
        if (!$master) {
            return redirect()->route('home')->with('error', 'Siz usta emassiz.');
        }

        return view('masters.works.create', compact('master'));
    }

    /**
     * Store a newly created work.
     */
    public function storeWork(Request $request)
    {
        $master = Auth::user()->master;
        
        if (!$master) {
            return redirect()->route('home')->with('error', 'Siz usta emassiz.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240',
        ]);

        $work = new Work([
            'master_id' => $master->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Handle media uploads
        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('works', 'public');
                $mediaPaths[] = $path;
            }
        }
        
        $work->media_paths = $mediaPaths;
        $work->save();

        return redirect()->route('master.dashboard')->with('success', 'Ish muvaffaqiyatli qo\'shildi.');
    }

    /**
     * Accept an order.
     */
    public function acceptOrder(Order $order)
    {
        $master = Auth::user()->master;
        
        if (!$master || $order->master_id !== $master->id) {
            return redirect()->back()->with('error', 'Ruxsat berilmagan.');
        }

        $order->accept();

        return redirect()->back()->with('success', 'Buyurtma qabul qilindi.');
    }

    /**
     * Complete an order.
     */
    public function completeOrder(Request $request, Order $order)
    {
        $master = Auth::user()->master;
        
        if (!$master || $order->master_id !== $master->id) {
            return redirect()->back()->with('error', 'Ruxsat berilmagan.');
        }

        $request->validate([
            'completion_notes' => 'nullable|string',
            'completion_media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240',
        ]);

        // Handle completion media uploads
        $mediaPaths = [];
        if ($request->hasFile('completion_media')) {
            foreach ($request->file('completion_media') as $file) {
                $path = $file->store('completions', 'public');
                $mediaPaths[] = $path;
            }
        }

        $order->complete($mediaPaths, $request->completion_notes);

        return redirect()->back()->with('success', 'Ish tugallandi.');
    }
}
