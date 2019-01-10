<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    protected $fillable = [
        'fun_nome',
        'fun_menu_json'
    ];
    protected $table = 'cda_user_funcao';
    protected $primaryKey = 'fun_id';
    public $timestamps = false;
}
