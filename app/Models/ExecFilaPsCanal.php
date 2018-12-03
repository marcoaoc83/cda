<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecFilaPsCanal extends Model
{
    protected $fillable = [
        'Lote','PsCanalId'
    ];
    protected $table = 'cda_execfila_pscanal';
    public $timestamps = false;
    protected $primaryKey = 'efpa_id';
}
