<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraficosTipo extends Model
{
    protected $fillable = [
        'grti_nome'
    ];
    protected $table = 'cda_graficos_tipos';
    protected $primaryKey = 'grti_id';
    public $timestamps = false;
}
