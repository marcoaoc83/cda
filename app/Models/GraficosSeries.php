<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraficosSeries extends Model
{
    protected $fillable = [
        'grse_grafico_id', 'grse_titulo', 'grse_grafico_ref','grse_sql_campo','grse_sql_condicao', 'grse_valor'
    ];
    protected $table = 'cda_graficos_series';
    protected $primaryKey = 'grse_id';
    public $timestamps = false;
}
