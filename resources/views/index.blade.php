@extends('layouts.app')
 
@section('title', 'Page Title')
 
@section('sidebar')
    <div class="sidebar">
        @parent
        <p class="elquequiera">El que quiera Pokemones, que los busque.</p>
    </div>
@endsection

@section('content')
    <div class="search-line">
        @include('searchform')
        @if(request('search'))
            <a href="/">Volver a todos los pokemones</a>
        @endif
    </div>
    <div class="list-container">
        <div class="list-total">
            <h2>Lista de Pokémon</h2>
            @if(isset($pagination['total']))
                <p>Totales búsqueda: <strong>{{$pagination['total']}}</strong></p>
            @endif
        </div>

        <ul class="list">
        @if(count($pokemons) > 0)
            @foreach($pokemons as $pokemon)
                <li class="pokemon-card">
                    <h3>{{ $pokemon['forms'][0]['name'] ?? 'Nombre no disponible' }}</h3>
                    <img class="{{ !$pokemon['sprites']['front_default'] ? 'default-img' : '' }}"  alt="{{ $pokemon['forms'][0]['name'] ?? 'Pokemon' }}" src="{{ $pokemon['sprites']['front_default'] ?? asset('images/pokemon_default.png') }}">
                    <div class="details">
                        <div class="types">
                            @if(isset($pokemon['types']))
                                <p> <strong>Tipos:</strong> {{ implode(', ', collect($pokemon['types'])->pluck('type.name')->toArray()) }}</p>
                            @else
                                <p> <strong>Tipos:</strong> No se encontraron tipos </p>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        @else
            <div>No se encontraron resultados.</div>
        @endif
        </ul>
    </div>
    <div class="pagination">
   
        <div>
        {{ $paginator->links('paginator') }}
        </div>
        
    </div>
@include('layouts.footer')
@endsection