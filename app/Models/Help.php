<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $fillable = [
        'help_titulo', 'help_texto', 'help_formulario'
    ];
    protected $table = 'cda_help';
    protected $primaryKey = 'help_id';
    public $timestamps = false;

}
