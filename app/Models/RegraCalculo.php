<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegraCalculo extends Model
{
    protected $fillable = [
        'RegCalcSg', 'RegCalcNome', 'TpRegCalcId','IndReajId','TpJuroId','InicioDt','TerminoDt','ModComId','JuroTx','MultaTx','DescontoTx','HonorarioTx'
    ];
    protected $table = 'cda_regcalc';
    protected $primaryKey = 'RegCalcId';
    public $timestamps = false;
}
