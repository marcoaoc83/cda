<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    protected $fillable = [
        'bair_nome'
    ];
    protected $table = 'cda_bairro';
    protected $primaryKey = 'bair_id';
    public $timestamps = false;
}
