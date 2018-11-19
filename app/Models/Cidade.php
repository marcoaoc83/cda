<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $fillable = [
        'cida_nome','cida_uf'
    ];
    protected $table = 'cda_cidade';
    protected $primaryKey = 'cida_id';
    public $timestamps = false;
}
