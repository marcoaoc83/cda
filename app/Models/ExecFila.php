<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecFila extends Model
{
    protected $fillable = [
        'exfi_tarefa', 'exfi_notificacao', 'exfi_data', 'exfi_fila'
    ];
    protected $table = 'cda_execfila';
    public $timestamps = false;
    protected $primaryKey = 'exfi_lote';
}
