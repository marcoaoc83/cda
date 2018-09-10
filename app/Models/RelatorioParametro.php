<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelatorioParametro extends Model
{
    protected $fillable = [
        'rep_rel_id', 'rep_parametro', 'rep_descricao', 'rep_valor', 'rep_tipo'
    ];
    protected $table = 'cda_relatorios_parametros';
    public $timestamps = false;
    protected $primaryKey = 'rep_id';
}
