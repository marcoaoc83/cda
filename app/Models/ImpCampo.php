<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpCampo extends Model
{
    protected $fillable = [
        'LayoutId', 'CampoNm', 'CampoDB', 'CampoPK', 'CampoValorFixo'
    ];
    protected $table = 'cda_imp_campo';
    protected $primaryKey = 'CampoID';
    public $timestamps = false;
}
