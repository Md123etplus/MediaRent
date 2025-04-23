<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObjetController extends Controller
{
    public function create()
    {
        return view('partenaire.objets.create'); 
    }

    public function index()
    {
        $objets = Objet::where('proprietaire_id', auth()->id())->get();
        return view('partenaire.objets.index', compact('objets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
