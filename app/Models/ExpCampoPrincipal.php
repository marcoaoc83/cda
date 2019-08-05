<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpCampoPrincipal extends Model
{
    protected $fillable = [
        'epc_layout_id', 'epc_ord', 'epc_campo', 'epc_titulo'
    ];
    protected $table = 'cda_exportacao_principal_campo';
    protected $primaryKey = 'epc_id';
    public $timestamps = false;
}
