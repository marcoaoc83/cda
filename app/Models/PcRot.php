<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PcRot extends Model
{
    protected $fillable = [
        'CarteiraId',
        'ParcelaId',
        'RoteiroId',
        'EntradaDt',
        'SaidaDt'
    ];
    protected $table = 'cda_pcrot';
    protected $primaryKey = 'pcrot_id';
    public $timestamps = false;
}
