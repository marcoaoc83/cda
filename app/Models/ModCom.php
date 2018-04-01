<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModCom extends Model
{
    protected $fillable = [
        'REGTABSG', 'REGTABNM', 'REGTABSQL','TABSYSID','REGTABIMP',
    ];
    protected $table = 'cda_regtab';
    protected $primaryKey = 'REGTABID';
}
