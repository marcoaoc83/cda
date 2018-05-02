<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrRotCanal extends Model
{
    protected $fillable = [
        'CarteiraId', 'RoteiroId', 'PrioridadeNr', 'TpPosId'
    ];
    protected $table = 'cda_prrotcanal';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
