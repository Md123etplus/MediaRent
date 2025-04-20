<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Category;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::query()->with(['partner', 'category', 'images'])
            ->where('status', 'active');

        // Filtres de recherche
        if ($request->has('city')) {
            $query->where('city', 'like', '%'.$request->city.'%');
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        // Tri des résultats
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_day');
                break;
            case 'price_desc':
                $query->orderByDesc('price_per_day');
                break;
            case 'rating':
                $query->withAvg('partner', 'rating')
                    ->orderByDesc('partner_avg_rating');
                break;
            default:
                $query->latest();
        }

        $ads = $query->paginate(10);
        $categories = Category::all();

        return view('search.index', compact('ads', 'categories'));
    }

    public function show(Ad $ad)
    {
        return view('search.show', compact('ad'));
    }
}