<?php
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="relative h-64">
            <img src="{{ asset($photo) }}" 
                 alt="{{ $objet->nom }}" 
                 class="w-full h-full object-cover">
                 
            <div class="absolute top-4 right-4">
                <span class="px-4 py-2 rounded-full {{ $disponible ? 'bg-green-500' : 'bg-red-500' }} text-white">
                    {{ $disponible ? 'Disponible' : 'Indisponible' }}
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <h1 class="text-2xl font-bold">{{ $objet->nom }}</h1>
            
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-yellow-400">★</span>
                    <span class="ml-1">{{ $note }}/5</span>
                </div>
                
                <div class="text-2xl font-bold text-blue-600">
                    {{ number_format($objet->prix_journalier, 2) }}€ /jour
                </div>
            </div>
        </div>
    </div>
</div>
@endsection