<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpArquivo extends Model
{
    protected $fillable = [
         'ext_layout_id','ext_tabela','ext_campo','ext_campo_fk'
    ];
    protected $table = 'cda_exportacao_tabela';
    protected $primaryKey = 'ext_id';
    public $timestamps = false;
}
