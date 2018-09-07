<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecRot extends Model
{
    protected $fillable = [
        'CarteiraId', 'RoteiroId', 'AtivoSN', 'ExecRotId'
    ];
    protected $table = 'cda_execrot';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
