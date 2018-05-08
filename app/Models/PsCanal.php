<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsCanal extends Model
{
    protected $fillable = [
        'PessoaId','InscrMunId', 'FonteInfoId', 'TipPosId', 'CEPId',  'LogradouroId',  'EnderecoNr',  'Complemento', 'TelefoneNr', 'Email', 'CanalId', 'LogradouroDesc', 'Bairro', 'Cidade', 'UF'
    ];
    protected $table = 'cda_pscanal';
    public $timestamps = false;
    protected $primaryKey = 'PsCanalId';
}
