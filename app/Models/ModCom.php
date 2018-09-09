<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModCom extends Model
{
    protected $fillable = [
        'ModComSg', 'ModComNm', 'TpModId','CanalId','ModComAnxId','ModTexto','RegCalId'
    ];
    protected $table = 'cda_modcom';
    protected $primaryKey = 'ModComId';
    public $timestamps = false;

    public function modCom_RegraCalc(){
        return $this->hasOne(RegraCalculo::class, 'RegCalcId', 'RegCalId');
    }

    public function Variaveis(){
        return $this->hasMany(ModeloVar::class, 'ModComId', 'ModComId');
    }
}
