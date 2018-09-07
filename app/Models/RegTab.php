<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegTab extends Model
{
    protected $fillable = [
        'REGTABSG','REGTABSGUSER', 'REGTABNM', 'REGTABSQL','TABSYSID','REGTABIMP',
    ];
    protected $table = 'cda_regtab';
    protected $primaryKey = 'REGTABID';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tabSysRegTab(){
        return $this->hasOne(RegTab::class, 'TABSYSID', 'TABSYSID');
    }
}
