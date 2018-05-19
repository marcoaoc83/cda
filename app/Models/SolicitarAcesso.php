<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitarAcesso extends Model
{
    protected $fillable = [
        'soa_tipo', 'soa_nome','soa_documento','soa_data_nasc','soa_nome_mae','soa_datetime'
    ];
    protected $table = 'cda_solicitar_acesso';
    protected $primaryKey = 'soa_id';
    public $timestamps = false;
}
