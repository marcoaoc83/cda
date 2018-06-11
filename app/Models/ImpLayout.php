<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpLayout extends Model
{
    protected $fillable = [
        'LayoutSg', 'LayoutNm','LayoutTabela','DiretorioDs'
    ];
    protected $table = 'cda_imp_layout';
    protected $primaryKey = 'LayoutId';
    public $timestamps = false;
}
