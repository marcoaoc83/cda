<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValEnv extends Model
{
    protected $fillable = [
        'CanalId', 'ValEnvId', 'EventoId'
    ];
    protected $table = 'cda_valenv';
    public $timestamps = false;

    protected $primaryKey = 'id';


}
