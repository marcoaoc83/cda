<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TratRet extends Model
{
    protected $fillable = [
        'CanalId', 'RetornoCd', 'RetornoCdNr', 'EventoId'
    ];
    protected $table = 'cda_tratret';
    public $timestamps = false;
    protected $primaryKey = 'TratRetId';
    public function canais(){
        return $this->belongsTo(Canal::class);
    }

    public function eventos(){
        return $this->belongsTo(Evento::class);
    }

}
