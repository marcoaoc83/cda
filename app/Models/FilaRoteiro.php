<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilaRoteiro extends Model
{
    protected $fillable = ['fixro_fila','fixro_roteiro'];
    protected $table = 'cda_fila_x_roteiro';
    protected $primaryKey = 'fixro_id';
    public $timestamps = false;
}
