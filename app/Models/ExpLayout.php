<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpLayout extends Model
{
    protected $fillable = [
         'exp_nome','exp_tabela'
    ];
    protected $table = 'cda_exportacao_layout';
    protected $primaryKey = 'exp_id';
    public $timestamps = false;
}
