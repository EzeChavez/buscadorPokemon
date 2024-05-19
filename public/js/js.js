function buscarPokemon() {
    const termino = $('#entrada-pokemon').val().trim().toLowerCase();
    if (!termino) {
        alert('Por favor, ingresa un nombre de Pokémon');
        return;
    }

    mostrarCartaCargando();

    axios.post('/buscar', { termino: termino })
        .then(response => {
            const resultado = document.getElementById('resultado');
            resultado.innerHTML = '';

           if (response.data.encontrado) {
                const card = crearCartaPokemon(
                    termino,
                    response.data.habilidades,
                    response.data.id,
                    response.data.tipo,
                    response.data.imagen
                );
                resultado.appendChild(card);
                actualizarHistorial(response.data.historial, termino);
           } else {
                const card = crearCartaPokemonNoEncontrado();
                resultado.appendChild(card);
                listarHistorial(response.data.historial);
            }

            ocultarCartaCargando();


        })
        .catch(error => {
            const resultado = document.getElementById('resultado');
            ocultarCartaCargando();

            if (error.response && error.response.data && error.response.data.error) {
                resultado.innerHTML = error.response.data.error;
            } 
        });
}

function buscarDeNuevo(termino) {
    $('#entrada-pokemon').val(termino);
    buscarPokemon();
}

function crearCartaPokemon(nombre, habilidades, id, tipo, imagen) {
    const card = document.createElement('div');
    card.className = 'pokemon-card';
    card.style.backgroundColor = setColorByType(tipo);

    const img = document.createElement('img');
    img.src = imagen;
    img.alt = nombre;

    const title = document.createElement('h3');
    title.textContent = nombre.charAt(0).toUpperCase() + nombre.slice(1);

    const abilities = document.createElement('p');
    abilities.textContent = `Habilidades: ${habilidades.join(', ')}`;

    card.appendChild(img);
    card.appendChild(title);
    card.appendChild(abilities);

    return card;
}

function setColorByType(type) {
    const typeColors = {
        fire: '#FDDFDF',
        grass: '#DEFDE0',
        water: '#DEF3FD',
        electric: '#FCF7DE',
        ground: '#f4e7da',
        rock: '#d5d5d4',
        fairy: '#fceaff',
        poison: '#98d7a5',
        bug: '#f8d5a3',
        dragon: '#97b3e6',
        psychic: '#eaeda1',
        flying: '#F5F5F5',
        fighting: '#E6E0D4',
        normal: '#F5F5F5'
    };
    return typeColors[type.toLowerCase()] || '#F5F5F5';
}

function mostrarCartaCargando() {
    const resultado = document.getElementById('resultado');
    resultado.innerHTML = '';
    const loadingCard = document.getElementById('loading-card');
    loadingCard.style.display = 'block';
}

function ocultarCartaCargando() {
    const loadingCard = document.getElementById('loading-card');
    loadingCard.style.display = 'none';
}
document.addEventListener('DOMContentLoaded', (event) => {
    const entradaPokemon = document.getElementById('entrada-pokemon');
    entradaPokemon.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            buscarPokemon();
        }
    });
});
function crearCartaPokemonNoEncontrado() {
    const card = document.createElement('div');
    card.className = 'pokemon-card';
    card.innerHTML = `
        <img src="https://via.placeholder.com/100?text=?" alt="No encontrado" />
        <h3>Pokémon no encontrado</h3>
        <p>Intenta con otro nombre.</p>
    `;
    console.log('se creo carta no encontrado')
    return card;
}
function listarHistorial(historial) {
    const listaHistorial = document.getElementById('historial');
    listaHistorial.innerHTML = ''; // Limpiar el historial actual

    historial.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `<a href="#" onclick="buscarDeNuevo('${item.termino_busqueda}')">${item.termino_busqueda}</a>`;
        listaHistorial.appendChild(li);
    });
}

function actualizarHistorial(historial, terminoBusqueda) {
    // Solo agregar al historial si la búsqueda fue exitosa
    if (historial.some(item => item.termino_busqueda === terminoBusqueda)) {
        listarHistorial(historial);
    }
}