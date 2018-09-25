<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guia extends Model
{
    protected $fillable = [
        'guia_pessoa_id', 'guia_im', 'guia_valor'
    ];
    protected $table = 'cda_guia';
    protected $primaryKey = 'guia_id';
    public $timestamps = false;
}
