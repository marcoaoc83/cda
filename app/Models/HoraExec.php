<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoraExec extends Model
{
    protected $fillable = [
        'FilaTrabId', 'DiaSemId', 'HInicial', 'HFinal'
    ];
    protected $table = 'cda_horexec';
    public $timestamps = false;
    protected $primaryKey = 'id';



}
