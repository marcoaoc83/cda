<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraficosValores extends Model
{
    protected $fillable = [
        'grva_grafico_id', 'grva_name', 'grva_y','grva_filtro1','grva_filtro2','grva_filtro3','grva_filtro4','grva_filtro5'
    ];
    protected $table = 'cda_graficos_valores';
    protected $primaryKey = 'grva_id';
    public $timestamps = false;
}
