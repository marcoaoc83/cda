<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fila extends Model
{
    protected $fillable = [
        'FilaTrabSg', 'FilaTrabNm', 'TpModId','EventoId','PerfilId'
    ];
    protected $table = 'cda_filatrab';
    protected $primaryKey = 'FilaTrabId';
    public $timestamps = false;
}
