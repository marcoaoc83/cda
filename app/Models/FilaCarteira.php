<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilaCarteira extends Model
{
    protected $fillable = ['fixca_fila','fixca_carteira'];
    protected $table = 'cda_fila_x_carteira';
    protected $primaryKey = 'fixca_id';
    public $timestamps = false;
}
