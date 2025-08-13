<?php

namespace App\Http\Controllers;

use App\Models\Master;
use App\Models\Region;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index(Request $request)
    {
        $regions = Region::all();
        $categories = Category::all();
        
        // Get featured masters (top rated, approved)
        $featuredMasters = Master::approved()
            ->with(['user', 'category', 'works'])
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();

        // Search functionality
        $masters = collect();
        if ($request->has('search') || $request->has('region_id') || $request->has('category_id')) {
            $query = Master::approved()->with(['user', 'category']);
            
            if ($request->filled('region_id')) {
                $query->inRegion($request->region_id);
            }
            
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }
            
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->whereHas('user', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                })->orWhereHas('category', function ($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%");
                });
            }
            
            $masters = $query->orderBy('rating', 'desc')->paginate(12);
        }

        return view('home', compact('regions', 'categories', 'featuredMasters', 'masters'));
    }
}
