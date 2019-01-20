<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parcela;
use App\Models\PcEvento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GraficosController extends Controller
{
    public function acionamentos(Request $request){


        $dados = array();
        parse_str($request->dados, $dados);
        extract($dados);
        $where="1";
        if($OrigemTrib){
            $where.=" and cda_parcela.OrigTribId in (".implode(',',$OrigemTrib).")";
        }
        if($Carteira){
            $where.=" and cda_pcevento.CARTEIRAID in (".implode(',',$Carteira).")";
        }
        if($Fase){
            $where.=" and cda_roteiro.FaseCartId in (".implode(',',$Fase).")";
        }
        if($Ano){
            $where.=" and Year(cda_parcela.VencimentoDt) in (".implode(',',$Ano).")";
        }
        if($Mes){
            $where.=" and MONTH(cda_parcela.VencimentoDt) in (".implode(',',$Mes).")";
        }
        $parc=Parcela::select(DB::raw('Year(cda_parcela.VencimentoDt) as ano'),'cda_parcela.TotalVr as total')
            ->join('cda_pcevento','cda_parcela.ParcelaId','=','cda_pcevento.PARCELAID')
            ->join('cda_roteiro','cda_roteiro.RoteiroId','=','cda_pcevento.ROTEIROID')
            ->whereRaw($where)
            ->groupBy('cda_pcevento.PARCELAID')
            ->get();

        $arr=[];
        foreach ($parc as $value){
            if(isset($arr[$value->ano]))
                $arr[$value->ano]+=$value->total;
            else
                $arr[$value->ano]=$value->total;
        }
        $res=[];
        $x=0;
        foreach ($arr as $key => $value){
            $res[$x]['y']=strval($key);
            $res[$x]['a']=$value;
            $x++;
        }
        if(empty($res)){
            $res[0]['y']=date('Y');
            $res[0]['a']=0;
        }
        return json_encode($res);
    }
}
