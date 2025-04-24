@extends('layouts.app')

@section('title', 'Devenir Partenaire Premium')
@section('content')
<div class="max-w-4xl mx-auto py-12">
    <h1 class="text-3xl font-bold mb-8">Passez en Premium</h1>
    
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Carte Premium -->
        @foreach($plans as $plan)
            <div class="border rounded-lg p-6 {{ $plan->featured ? 'border-indigo-500 ring-2 ring-indigo-200' : '' }}">
                <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                <p class="text-3xl my-4">{{ $plan->price }}€<span class="text-sm">/mois</span></p>
                <ul class="space-y-2 mb-6">
                    @foreach($plan->features as $feature)
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}?plan={{ $plan->id }}" 
                   class="block w-full bg-indigo-600 text-white text-center py-2 rounded hover:bg-indigo-700">
                    Choisir ce plan
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection