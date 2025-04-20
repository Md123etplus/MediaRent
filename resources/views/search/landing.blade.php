@extends('layouts.app')

@section('title', 'Bienvenue sur MediaRent')
@section('content')
<div class="text-center py-20">
    <h1 class="text-4xl font-bold mb-6">Trouvez ce dont vous avez besoin</h1>
    @include('components.search-bar')
</div>
@endsection