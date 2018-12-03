<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanalEvento extends Model
{
    protected $fillable = [
        'CanalId','EventoId'
    ];
    protected $table = 'cda_canal_eventos';
    public $timestamps = false;

    public function canais(){
        return $this->belongsTo(Canal::class,"CanalId");
    }

    public function eventos(){
        return $this->belongsTo(Evento::class,"EventoId");
    }
}
