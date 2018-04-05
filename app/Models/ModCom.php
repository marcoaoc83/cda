<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModCom extends Model
{
    protected $fillable = [
        'ModComSg', 'ModComNm', 'TpModId','CanalId','ModComAnxId','ModTexto'
    ];
    protected $table = 'cda_modcom';
    protected $primaryKey = 'ModComId';
    public $timestamps = false;
}
