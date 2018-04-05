<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabelasSistema extends Model
{
    protected $fillable = [
        'TABSYSSG', 'TABSYSNM', 'TABSYSSQL',
    ];
    protected $table = 'cda_tabsys';
    protected $primaryKey = 'TABSYSID';
    public $timestamps = false;
}
