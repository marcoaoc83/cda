<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuiaParcela extends Model
{
    protected $fillable = [
        'gupa_guia_id', 'gupa_parcela_id'
    ];
    protected $table = 'cda_guia_parcela';
    protected $primaryKey = 'gupa_id';
    public $timestamps = false;
}
