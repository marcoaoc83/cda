<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntCart extends Model
{
    protected $fillable = [
        'CarteiraId', 'EntCartId', 'AtivoSN'
    ];
    protected $table = 'cda_entcart';
    public $timestamps = false;
    protected $primaryKey = 'id';

}
