<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudio extends Model
{
    use HasFactory;

    protected $table = 'estudios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'email',
        'pass',
        'telefono'
    ];

}
