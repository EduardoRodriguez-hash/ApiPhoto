<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaVenta extends Model
{
    use HasFactory;

    protected $table = 'nota_ventas';

    protected $fillable = [
        'fecha',
        'total',
        'id_foto',
        'id_usuario',
    ];

}
