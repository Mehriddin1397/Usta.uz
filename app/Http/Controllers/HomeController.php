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
        $regions = Region::with('districts')->get();
        $categories = Category::all();

        $featuredMasters = Master::approved()
            ->with(['user', 'category', 'works'])
            ->orderBy('rating', 'desc')
            ->limit(6)
            ->get();

        $masters = collect();

        if ($request->filled('search') || $request->filled('region_id') || $request->filled('district_id') || $request->filled('category_id')) {

            $query = Master::approved()->with(['user', 'category']);

            // Region bo‘yicha qidirish
            if ($request->filled('region_id')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('region_id', $request->region_id);
                });
            }

            // District bo‘yicha qidirish
            if ($request->filled('district_id')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('district_id', $request->district_id);
                });
            }

            // Category bo‘yicha qidirish
            if ($request->filled('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            // Search bo‘yicha qidirish
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$searchTerm}%"))
                        ->orWhereHas('category', fn($c) => $c->where('name', 'like', "%{$searchTerm}%"));
                });
            }

            $masters = $query->orderBy('rating', 'desc')->paginate(12);
        }

        return view('home', compact('regions', 'categories', 'featuredMasters', 'masters'));
    }

}
