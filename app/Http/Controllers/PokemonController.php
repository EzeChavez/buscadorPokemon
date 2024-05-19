<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Historial_Busquedas;

class PokemonController extends Controller
{
    public function buscar(Request $request)
    {
        $terminoBusqueda = strtolower($request->input('termino'));
        $idSesion = $request->session()->getId();

        Log::info("Buscando Pokémon: {$terminoBusqueda}");

        // Llamar a la API de Pokémon a través del proxy
        $respuesta = Http::get("https://pokeapi.co/api/v2/pokemon/{$terminoBusqueda}");
        if ($respuesta->successful()) {
            $datos = $respuesta->json();
            $idPokemon = $datos['id'];
            $tipoPokemon = $datos['types'][0]['type']['name']; // Asumiendo que solo queremos el primer tipo
            $imagenPokemon = $datos['sprites']['other']['official-artwork']['front_default'];
     
            $urlsHabilidades = array_map(function($habilidad) {
                return $habilidad['ability']['url'];
            }, $datos['abilities']);

            $habilidades = [];
            foreach ($urlsHabilidades as $url) {
                $respuestaHabilidad = Http::get($url);
                if ($respuestaHabilidad->successful()) {
                    $datosHabilidad = $respuestaHabilidad->json();
                    $nombreHabilidad = $this->obtenerNombreHabilidadEnEspanol($datosHabilidad['names']);
                    if ($nombreHabilidad) {
                        $habilidades[] = $nombreHabilidad;
                    }
                }
            }

            // Guardar el historial en la base de datos
            Historial_Busquedas::create([
                'termino_busqueda' => $terminoBusqueda,
                'resultado' => json_encode($habilidades),
                'id_sesion' => $idSesion,
            ]);

            // Obtener las últimas 10 búsquedas exitosas
            $historial = Historial_Busquedas::where('id_sesion', $idSesion)
                                    ->orderBy('created_at', 'desc')
                                    ->take(10)
                                    ->get();

                                    return response()->json([
                                        'encontrado' => true,
                                        'habilidades' => $habilidades,
                                        'historial' => $historial,
                                        'id' => $idPokemon,
                                        'tipo' => $tipoPokemon,
                                        'imagen' => $imagenPokemon
                                    ]);
        }
        else

        //Log::warning("Pokémon no encontrado: {$terminoBusqueda}");
       // Obtener las últimas 10 búsquedas exitosas
       $historial = Historial_Busquedas::where('id_sesion', $idSesion)
       ->orderBy('created_at', 'desc')
       ->take(10)
       ->get();
            return response()->json([
                'encontrado' => false,
                'historial' => $historial,
            ]);
       
    }

    private function obtenerNombreHabilidadEnEspanol($nombres)
    {
        if ($nombres) {
            foreach ($nombres as $nombre) {
                if ($nombre['language']['name'] === 'es') {
                    return $nombre['name'];
                }
            }
        }
        return null;
    }
}
