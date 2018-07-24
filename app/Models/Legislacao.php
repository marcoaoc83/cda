<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legislacao extends Model
{
    protected $fillable = [
        'leg_titulo', 'leg_descricao', 'leg_arquivo', 'leg_link'
    ];
    protected $table = 'cda_portal_legislacao';
    protected $primaryKey = 'leg_id';
    public $timestamps = false;
}
