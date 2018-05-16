<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegParc extends Model
{
    protected $fillable = [
        'RegCalcId',
        'ParcelaQt',
        'OpRegId',
        'FatorVr',
        'JuroDescTx',
        'MultaDescTx',
        'PrincipalDescTx',
        'EntradaMinVr',
        'ParcelaMinVr'
    ];
    protected $table = 'cda_regparc';
    protected $primaryKey = 'RegParcId';
    public $timestamps = false;
}
