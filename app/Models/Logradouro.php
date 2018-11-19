<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logradouro extends Model
{
    protected $fillable = [
        'logr_tipo','logr_nome'
    ];
    protected $table = 'cda_logradouro';
    protected $primaryKey = 'logr_id';
    public $timestamps = false;
}
