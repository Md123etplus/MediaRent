<?php
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center space-x-4">
            <img src="{{ asset($partenaire->img_profil) }}" 
                 alt="Photo de profil" 
                 class="w-24 h-24 rounded-full object-cover">
            
            <div>
                <h1 class="text-2xl font-bold">{{ $surnom }}</h1>
                
                <div class="mt-2 flex items-center space-x-4">
                    <div class="flex items-center">
                        <span class="text-yellow-400">★</span>
                        <span class="ml-1">{{ $note }}/5</span>
                    </div>
                    
                    <div class="text-gray-600">
                        {{ $nbAnnonces }} annonce(s) active(s)
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection