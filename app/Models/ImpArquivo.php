<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpArquivo extends Model
{
    protected $fillable = [
        'LayoutId', 'ArquivoDs','ArquivoOrd','TabelaBD','TpArqId'
    ];
    protected $table = 'cda_imp_arquivo';
    protected $primaryKey = 'ArquivoId';
    public $timestamps = false;
}
