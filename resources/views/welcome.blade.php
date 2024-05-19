<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda Pokémon</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script type="text/javascript" src="js/js.js"></script>

</head>
<body>
    <div id="app">
        <input type="text" id="entrada-pokemon" placeholder="Ingresa el nombre del Pokémon" />
        <button id="boton-buscar" onclick="buscarPokemon()">
            <i class="fas fa-search"></i>
        </button>
        <div id="resultado"></div>
        <div class="pokemon-card" id="loading-card">
            <img src="https://via.placeholder.com/100?text=?" alt="cargando" />
            <h3>Buscando...</h3>
        </div>
        <h3>Historial de Búsqueda</h3>
        <ul id="historial"></ul>
    </div>

</body>
</html>
