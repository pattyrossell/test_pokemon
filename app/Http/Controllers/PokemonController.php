<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $partialName = $request->input('search');
        $perPage = 12;

        if ($partialName) {
            $pokemonsData = $this->searchPokemons($partialName, $page, $perPage);
        } else {
            $pokemonsData = $this->getPokemons($perPage, $page);
        }

        $totalElements = $pokemonsData['count'];
        $pokemons = $this->listPokemons($pokemonsData['results'], $page);

        $paginator = new LengthAwarePaginator(
            $pokemons,
            $totalElements,
            $perPage,
            $page
        );

        if ($partialName) {
            $paginator->appends(['search' => $partialName]);
        }

        return view('index', compact('pokemons', 'paginator'));
    }

    protected function searchPokemons($partialName, $page, $perPage)
    {
        $response = Http::get("https://pokeapi.co/api/v2/pokemon?limit=1500");
        $json = $response->json();
        $pokemonsData = $json ?  collect($json['results'])->filter(function ($item) use ($partialName) {
            return str_contains($item['name'], $partialName);
        })->values() : collect();

        $init = ($page - 1) * $perPage;
        $pokemons = $pokemonsData->slice($init, $perPage)->values();
        $totalElements = $pokemonsData->count();

        return [
            'results' => $pokemons,
            'count' => $totalElements,
        ];
    }

    protected function getPokemons($perPage, $page)
    {
        $offset = ($page - 1) * $perPage;
        $response = Http::get("https://pokeapi.co/api/v2/pokemon?limit=$perPage&offset=$offset");
        $json = $response->json();
        $pokemonsData = $json ? collect($json['results']) : collect();
        $totalElements = $json ? $json['count'] : 0;

        return [
            'results' => $pokemonsData,
            'count' => $totalElements,
        ];
    }

    public function listPokemons($data, $page)
    {
        try {
            $pokemons = $data->map(function ($pokemon) {
                try {
                    $response = Http::get($pokemon['url']);
                    $dataPokemon = $response->json();
                    return $dataPokemon;
                } catch (\Exception $e) {
                    return null;
                }
            });

            return $pokemons;
        } catch (\Exception $e) {
            return collect();
        }
    }
}
