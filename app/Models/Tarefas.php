<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefas extends Model
{
    protected $fillable = [
        'tar_categoria','tar_titulo','tar_descricao','tar_status','tar_jobs','tar_inicio','tar_final'
    ];
    protected $table = 'cda_tarefas';
    public $timestamps = false;
    protected $primaryKey = 'tar_id';

}
