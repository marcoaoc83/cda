<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relatorios extends Model
{
    protected $fillable = [
        'rel_titulo',
        'rel_saida',
        'filtro_carteira',
        'filtro_roteiro',
        'filtro_validacao',
        'filtro_contribuinte',
        'filtro_parcelas',
        'filtro_eventos',
        'filtro_tratamento',
        'filtro_notificacao',
        'filtro_canal',
        'resultado_contribuinte',
        'resultado_im',
        'resultado_parcelas',
        'resultado_canais'
    ];
    protected $table = 'cda_relatorios';
    protected $primaryKey = 'rel_id';
    public $timestamps = false;

    public function Parametros(){
        return $this->hasMany(RelatorioParametro::class, 'rep_rel_id', 'rel_id');
    }

}
