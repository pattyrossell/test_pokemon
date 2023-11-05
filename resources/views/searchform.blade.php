<form action="{{ url('/') }}" method="get">
    <input type="text" name="search" value="{{ request('search') }}" id="search-name-input" autocomplete="off">
    <button type="submit">Buscar Pokémon</button>
</form>