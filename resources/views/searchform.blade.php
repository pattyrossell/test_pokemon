<div>
    <form action="{{ url('/') }}" method="get">
        <input type="text" name="search" value="{{ request('search') }}" id="search-name-input" autocomplete="off">
        <button type="submit">Buscar Pokémon</button>
    </form>

    <ul id="search-results"></ul>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
            var timeout;

            document.getElementById('search-name-input').addEventListener('input', function () {
                clearTimeout(timeout);

                var searchTerm = this.value;

                timeout = setTimeout(function () {
                    if (searchTerm.length >= 2) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', '/searchPokemons?search=' + searchTerm, true);
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                var data = JSON.parse(xhr.responseText);
                                displayResults(data);
                            }
                        };
                        xhr.send()
                    } else {
                        document.getElementById('search-results').innerHTML = '';
                    }
                }, 300);
            });

            function displayResults(results) {
                var resultsList = document.getElementById('search-results');
                resultsList.innerHTML = '';

                if (results.length > 0) {
                    results.forEach(function (result) {
                        var listItem = document.createElement('li');
                        var link = document.createElement('a');
                        link.textContent = result.name;
                        link.href = '/?search=' + encodeURIComponent(result.name);
                        listItem.appendChild(link);
                        resultsList.appendChild(listItem);
                    });
                } else {
                    var noResultsItem = document.createElement('li');
                    noResultsItem.textContent = 'No se encontraron Pokemones.';
                    resultsList.appendChild(noResultsItem);
                }
            }
        });
    </script>