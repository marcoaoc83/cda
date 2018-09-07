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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tabSysRegTab(){
        return $this->hasOne(RegTab::class, 'TABSYSID', 'TABSYSID');
    }
}
