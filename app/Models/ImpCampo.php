<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpCampo extends Model
{
    protected $fillable = [
        'LayoutId', 'ArquivoId', 'CampoNm', 'TabelaDB',  'CampoDB', 'CampoValorFixo', 'FKTabela', 'TipoDados',  'OrdTable',  'FKCampo', 'CampoTipo'
    ];
    protected $table = 'cda_imp_campo';
    protected $primaryKey = 'CampoID';
    public $timestamps = false;
}
