<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carteira extends Model
{
    protected $fillable = [
        'CARTEIRAORD', 'CARTEIRASG', 'CARTEIRANM','TPASID','OBJCARTID','ORIGTRIBID'
    ];
    protected $table = 'cda_carteira';
    protected $primaryKey = 'CARTEIRAID';
    public $timestamps = false;
}
