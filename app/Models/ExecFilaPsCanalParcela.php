<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecFilaPsCanalParcela extends Model
{
    protected $fillable = [
        'Lote','Notificacao','ParcelaId'
    ];
    protected $table = 'cda_execfila_pscanal_parcela';
    public $timestamps = false;
    protected $primaryKey = 'eppa_id';
}
