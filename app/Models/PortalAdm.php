<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalAdm extends Model
{
    protected $fillable = [
        'port_titulo',
        'port_logo_topo',
        'port_logo_rodape',
        'port_endereco',
        'port_horario',
        'port_banner_lateral',
        'port_banner1',
        'port_banner2',
        'port_banner3',
        'port_banner4',
        'port_banner5',
        'port_cor',
        'port_cor_letra',
        'port_cor_menu1',
        'port_cor_menu2',
        'port_cor_menu_letra',
        'port_cor_rodape1',
        'port_cor_rodape2',
        'port_cor_rodape_letra',
        'port_boleto_nr_documento',
        'port_boleto_agencia',
        'port_boleto_codigo_cliente',
        'port_boleto_instrucao1',
        'port_boleto_instrucao2',
        'port_boleto_instrucao3',
        'port_boleto_instrucao4',
    ];
    protected $table = 'cda_portal';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;


}
