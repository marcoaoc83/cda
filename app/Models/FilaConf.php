<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilaConf extends Model
{
    protected $fillable = [
        'FilaTrabId', 'FilaConfId', 'FilaConfDs', 'TABSYSID'
    ];
    protected $table = 'cda_filaconf';
    public $timestamps = false;
    protected $primaryKey = 'id';

}
