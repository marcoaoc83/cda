<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpCampo extends Model
{
    protected $fillable = [
        'exc_layout_id', 'exc_ord', 'exc_campo', 'exc_titulo'
    ];
    protected $table = 'cda_exportacao_campo';
    protected $primaryKey = 'exc_id';
    public $timestamps = false;
}
