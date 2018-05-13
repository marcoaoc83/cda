<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = [
        'PessoaId',
        'InscrMunId',
        'SitPagId',
        'SitCobId',
        'OrigTribId',
        'TributoId',
        'LancamentoDt',
        'LancamentoNr',
        'VencimentoDt',
        'ParcelaNr',
        'PlanoQt',
        'PrincipalVr',
        'MultaVr',
        'JurosVr',
        'TaxaVr',
        'AcrescimoVr',
        'DescontoVr',
        'Honorarios',
        'TotalVr',
    ];
    protected $table = 'cda_parcela';
    public $timestamps = false;
    protected $primaryKey = 'ParcelaId';

    protected $dateFormat = 'd/m/Y';

    protected $dates = ['LancamentoDt', 'VencimentoDt'];

    protected $casts = [
        'driver_expiration'     => 'date'
    ];

    public function setLancamentoDtAttribute($value)
    {
        if($value)
            $this->attributes['LancamentoDt'] = Carbon::createFromFormat("d/m/Y",$value)->format('Y-m-d');
    }
    public function setVencimentoDtAttribute($value)
    {
        if($value)
            $this->attributes['VencimentoDt'] = Carbon::createFromFormat("d/m/Y",$value)->format('Y-m-d');
    }

}
