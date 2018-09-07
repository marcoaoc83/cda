<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [
        'PESSOAFJ', 'CPF_CNPJNR', 'PESSOANMRS'
    ];
    protected $table = 'cda_pessoa';
    protected $primaryKey = 'PESSOAID';
    public $timestamps = false;
}
