<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegTab extends Model
{
    protected $fillable = [
        'REGTABSG', 'REGTABNM', 'REGTABSQL','TABSYSID','REGTABIMP',
    ];
    protected $table = 'cda_regtab';
    protected $primaryKey = 'REGTABID';
    public $timestamps = false;
}
