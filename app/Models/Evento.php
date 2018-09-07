<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'EventoSg', 'EventoNm', 'EventoOrd', 'TpASId', 'ObjEventoId', 'TransfCtrId', 'FilaTrabId'
    ];
    protected $table = 'cda_evento';
    protected $primaryKey = 'EventoId';
    public $timestamps = false;
}
