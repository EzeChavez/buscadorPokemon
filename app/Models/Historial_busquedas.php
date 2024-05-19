<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Historial_busquedas extends Model{
    use HasFactory;
    protected $fillable = ['termino_busqueda','resultado','id_sesion'];
}
