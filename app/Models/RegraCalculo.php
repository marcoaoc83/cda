<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RegraCalculo extends Model
{
    protected $fillable = [
        'RegCalcSg',
        'RegCalcNome',
        'TpRegCalcId',
        'IndReajId',
        'TpJuroId',
        'InicioDt',
        'TerminoDt',
        'RegCalcNomGui',
        'bancoId',
        'ageCodCed',
        'JuroTx',
        'MultaTx',
        'DescontoTx',
        'HonorarioTx'
    ];

    protected $table = 'cda_regcalc';

    protected $primaryKey = 'RegCalcId';

    public $timestamps = false;

    protected $dateFormat = 'd/m/Y';

    protected $dates = ['InicioDt', 'TerminoDt'];

    protected $casts = [
        'driver_expiration'     => 'date'
    ];

    public function setInicioDtAttribute($value)
    {
        if($value)
            $this->attributes['InicioDt'] = Carbon::createFromFormat("d/m/Y",$value)->format('Y-m-d');
    }
    public function setTerminoDtAttribute($value)
    {
        if($value)
            $this->attributes['TerminoDt'] = Carbon::createFromFormat("d/m/Y",$value)->format('Y-m-d');
    }

}
