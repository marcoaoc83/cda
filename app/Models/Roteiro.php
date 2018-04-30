<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roteiro extends Model
{
    protected $fillable = [
        'CarteiraId', 'RoteiroOrd', 'FaseCartId', 'EventoId', 'ModComId','FilaTrabId','CanalId','RoteiroProxId'
    ];
    protected $table = 'cda_roteiro';
    public $timestamps = false;
    protected $primaryKey = 'RoteiroId';
}
