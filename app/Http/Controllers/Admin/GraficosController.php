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

    public function origem(Request $request){


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
        $parc=Parcela::select('OrigTribT.REGTABNM as nome','cda_parcela.TotalVr as total')
            ->join('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->join('cda_pcevento','cda_parcela.ParcelaId','=','cda_pcevento.PARCELAID')
            ->join('cda_roteiro','cda_roteiro.RoteiroId','=','cda_pcevento.ROTEIROID')
            ->whereRaw($where)
            ->groupBy('cda_pcevento.PARCELAID')
            ->get();

        $arr=[];
        foreach ($parc as $value){
            if(isset($arr[$value->nome]))
                $arr[$value->nome]+=$value->total;
            else
                $arr[$value->nome]=$value->total;
        }
        $res=[];
        $x=0;
        foreach ($arr as $key => $value){
            $res[$x]['label']=strval($key);
            $res[$x]['value']=$value;
            $x++;
        }
        if(empty($res)){
            $res[0]['label']='Nenhum registro';
            $res[0]['value']=0;
        }
        return json_encode($res);
    }

    public function carteira(Request $request){

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
        $parc=Parcela::select('cda_carteira.CARTEIRASG as nome','cda_parcela.TotalVr as total')

            ->join('cda_pcevento','cda_parcela.ParcelaId','=','cda_pcevento.PARCELAID')
            ->join('cda_roteiro','cda_roteiro.RoteiroId','=','cda_pcevento.ROTEIROID')
            ->join('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_pcevento.CARTEIRAID')
            ->whereRaw($where)
            ->groupBy('cda_pcevento.PARCELAID')
            ->get();

        $arr=[];
        $total=0;
        foreach ($parc as $value){
            $total+=$value->total;
            if(isset($arr[$value->nome]))
                $arr[$value->nome]+=$value->total;
            else
                $arr[$value->nome]=$value->total;
        }
        $res=[];
        $x=0;
        foreach ($arr as $key => $value){
            $res[$x]['label']=strval($key);
            $res[$x]['value']=number_format(($value*100)/$total,1);
            $x++;
        }
        if(empty($res)){
            $res[0]['label']='Nenhum registro';
            $res[0]['value']=0;
        }
        return json_encode($res);
    }

    public function fase(Request $request){

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
        $parc=Parcela::select('Fase.REGTABNM as nome','cda_parcela.TotalVr as total')

            ->join('cda_pcevento','cda_parcela.ParcelaId','=','cda_pcevento.PARCELAID')
            ->join('cda_roteiro','cda_roteiro.RoteiroId','=','cda_pcevento.ROTEIROID')
            ->join('cda_regtab as Fase', 'Fase.REGTABID', '=', 'cda_roteiro.FaseCartId')
            ->whereRaw($where)
            ->groupBy('cda_pcevento.PARCELAID')
            ->get();

        $arr=[];
        $total=0;
        foreach ($parc as $value){
            $total+=$value->total;
            if(isset($arr[$value->nome]))
                $arr[$value->nome]+=$value->total;
            else
                $arr[$value->nome]=$value->total;
        }
        $res=[];
        $x=0;
        foreach ($arr as $key => $value){
            $res[$x]['label']=strval($key);
            $res[$x]['value']=($value*100)/$total;
            $x++;
        }
        if(empty($res)){
            $res[0]['label']='Nenhum registro';
            $res[0]['value']=0;
        }
        return json_encode($res);
    }

}
