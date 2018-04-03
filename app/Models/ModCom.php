<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModCom extends Model
{
    protected $fillable = [
        'ModComSg', 'ModComNm', 'TpModId','CanalId','ModComAnxId','ModComAnxId'
    ];
    protected $table = 'cda_modcom';
    protected $primaryKey = 'ModComId';
}
