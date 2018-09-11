<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relatorios extends Model
{
    protected $fillable = [
        'rel_titulo','rel_sql'
    ];
    protected $table = 'cda_relatorios';
    protected $primaryKey = 'rel_id';
    public $timestamps = false;

    public function Parametros(){
        return $this->hasMany(RelatorioParametro::class, 'rep_rel_id', 'rel_id');
    }

}
