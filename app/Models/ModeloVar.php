<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloVar extends Model
{
    protected $fillable = [
        'var_titulo', 'var_codigo', 'var_tabela',  'var_campo', 'ModComId',  'var_tipo'
    ];
    protected $table = 'cda_modcom_var';
    protected $primaryKey = 'var_id';
    public $timestamps = false;
}
