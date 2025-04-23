<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('categories.show', compact('categorie'));
    }
}
