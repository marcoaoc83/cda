<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanalFila extends Model
{
    protected $fillable = [
        'cafi_fila'  ,
'cafi_pscanal',
'cafi_evento',
'cafi_entrada',
'cafi_saida'
    ];
    protected $table = 'cda_canal_fila';
    protected $primaryKey = 'cafi_id';
    public $timestamps = false;
}
