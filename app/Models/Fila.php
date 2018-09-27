<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fila extends Model
{
    protected $fillable = [
        'FilaTrabSg', 'FilaTrabNm', 'TpModId','EventoId','PerfilId',
        'filtro_carteira',
        'filtro_roteiro',
        'filtro_contribuinte',
        'filtro_parcelas',
        'resultado_contribuinte',
        'resultado_im',
        'resultado_parcelas',
        'resultado_canais'
    ];
    protected $table = 'cda_filatrab';
    protected $primaryKey = 'FilaTrabId';
    public $timestamps = false;
}
