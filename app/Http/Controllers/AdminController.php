<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Master;
use App\Models\Category;
use App\Models\Region;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_masters' => Master::count(),
            'pending_masters' => Master::where('is_approved', false)->count(),
            'total_orders' => Order::count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
        ];

        $recentOrders = Order::with(['user', 'master.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * Show all users.
     */
    public function users()
    {
        $users = User::with('region')->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Show pending masters for approval.
     */
    public function pendingMasters()
    {
        $pendingMasters = Master::where('is_approved', false)
            ->with(['user', 'category'])
            ->paginate(20);

        return view('admin.masters.pending', compact('pendingMasters'));
    }

    /**
     * Approve a master.
     */
    public function approveMaster(Master $master)
    {
        $master->update(['is_approved' => true]);

        // Change user role to master
        $master->user->update(['role' => 'master']);

        return redirect()->back()->with('success', 'Usta tasdiqlandi.');
    }

    /**
     * Show categories management.
     */
    public function categories()
    {
        $categories = Category::withCount('masters')->paginate(20);

        return view('admin.categories', compact('categories'));
    }

    /**
     * Store a new category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        Category::create($request->only(['name', 'description']));

        return redirect()->back()->with('success', 'Kategoriya qo\'shildi.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        // Agar shu kategoriyaga bog‘langan masterlar bo‘lsa, o‘chirib bo‘lmaydi
        if ($category->masters()->count() > 0) {
            return redirect()->back()->with('error', 'Bu kategoriya o‘chirila olmaydi. Avval unga bog‘langan ustalarni o‘chiring.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategoriya muvaffaqiyatli o‘chirildi.');
    }


    /**
     * Show regions management.
     */
    public function regions()
    {
        $regions = Region::withCount('users')->paginate(20);

        return view('admin.regions', compact('regions'));
    }

    /**
     * Store a new region.
     */
    public function storeRegion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions',
        ]);

        Region::create($request->only(['name']));

        return redirect()->back()->with('success', 'Hudud qo\'shildi.');
    }
}
