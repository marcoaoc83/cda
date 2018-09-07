<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InscrMun extends Model
{
    protected $fillable = [
         'INSCRMUNNR', 'ORIGTRIBID', 'PESSOAID',  'INICIODT',  'TERMINODT',  'SITUACAO'
    ];
    protected $table = 'cda_inscrmun';
    public $timestamps = false;
    protected $primaryKey = 'INSCRMUNID';

    protected $dateFormat = 'd/m/Y';

    protected $dates = ['INICIODT', 'TERMINODT'];

    protected $casts = [
        'driver_expiration'     => 'date'
    ];

    public function setINICIODTAttribute($value)
    {
        if($value)
        $this->attributes['INICIODT'] = Carbon::createFromFormat("d/m/Y",$value)->format('Y-m-d');
    }
    public function setTERMINODTAttribute($value)
    {
        if($value)
        $this->attributes['TERMINODT'] = Carbon::createFromFormat("d/m/Y",$value)->format('Y-m-d');
    }


}
