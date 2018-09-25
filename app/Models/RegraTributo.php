<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegraTributo extends Model
{
    protected $fillable = [
        'RegCalcId', 'TributoId'
    ];
    protected $table = 'cda_regra_tributo';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
