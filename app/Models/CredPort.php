<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CredPort extends Model
{
    protected $fillable = [
        'PessoaId','InscrMunId', 'PessoaIdCP', 'InicioDt', 'TerminoDt','Senha'
    ];
    protected $table = 'cda_credport';
    public $timestamps = false;
    protected $primaryKey = 'CredPortId';

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
