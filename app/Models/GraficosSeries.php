<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraficosSeries extends Model
{
    protected $fillable = [
        'grse_grafico_id', 'grse_tipo', 'grse_titulo','grse_subtitulo','grse_sql_valor', 'grse_sql_campo', 'grse_sql_condicao', 'grse_sql_agrupamento', 'grse_sql_ordenacao','grse_eixoy'
    ];
    protected $table = 'cda_graficos_series';
    protected $primaryKey = 'grse_id';
    public $timestamps = false;
}
