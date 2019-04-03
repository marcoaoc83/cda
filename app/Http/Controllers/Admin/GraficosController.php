<?php

namespace App\Http\Controllers\Admin;

use App\Models\Graficos;
use App\Models\GraficosTipo;
use App\Models\GraficosValores;
use App\Models\Parcela;
use App\Models\PcEvento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $graficos =Graficos::with('children_rec')->where('graf_grafico_ref',null)->get()->toArray();
        return view('admin.graficos.index2',compact('graficos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        $Tipo =GraficosTipo::all();
        $GraficosAll = Graficos::all();
        return view('admin.graficos.create',compact('Tipo','GraficosAll'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        Graficos::create($data);


        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('graficos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Graficos  $graficos
     * @return \Illuminate\Http\Response
     */
    public function show(Graficos $graficos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Graficos  $graficos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // show the view and pass the nerd to it
        $GraficosAll = Graficos::where('graf_id', '!=' , $id)->get();
        $Graficos = Graficos::find($id);
        $Tipo = GraficosTipo::all();
        return view('admin.graficos.edit',[
            'Graficos'=>$Graficos,
            'GraficosAll'=>$GraficosAll,
            'Tipo'=>$Tipo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Graficos  $graficos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Graficos = Graficos::findOrFail($id);
        $Graficos->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('graficos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Graficos  $graficos
     * @return \Illuminate\Http\Response
     */
    public function destroy($graficos)
    {
        $var = Graficos::find($graficos);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $graficos = Graficos::get();

        return Datatables::of($graficos)
            ->addColumn('action', function ($graficos) {

                return '
                <a href="graficos/'.$graficos->graf_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteGraficos('.$graficos->graf_id.')" class="btn btn-xs btn-danger deleteGraficos" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function home(Request $request){

        if($request->id){
            $Graficos=Graficos::select(['cda_graficos.*','cda_graficos_tipos.*','child.graf_id as ref'])
                ->join('cda_graficos_tipos', 'cda_graficos_tipos.grti_id', '=', 'cda_graficos.graf_tipo')
                ->leftjoin('cda_graficos as child', 'child.graf_grafico_ref', '=', 'cda_graficos.graf_id')
                ->where('cda_graficos.graf_id',$request->id)
                ->groupBy('cda_graficos.graf_id')
                ->get();
        }else{
            $Graficos=Graficos::select(['cda_graficos.*','cda_graficos_tipos.*','child.graf_id as ref'])
                ->join('cda_graficos_tipos', 'cda_graficos_tipos.grti_id', '=', 'cda_graficos.graf_tipo')
                ->leftjoin('cda_graficos as child', 'child.graf_grafico_ref', '=', 'cda_graficos.graf_id')
                ->where('cda_graficos.graf_principal',1)
                ->where('cda_graficos.graf_grafico_ref',null)
                ->groupBy('cda_graficos.graf_id')
                ->get();
        }


        $retorno=[];

        $x=0;
        $id="";
        $y=0;
        foreach ($Graficos as $linha){

            $sql = "SELECT 
                  cda_parcela.*,
                  SitPagT.REGTABNM as SitPag,
                  SitCobT.REGTABNM as SitCob,
                  OrigTribT.REGTABNM as OrigTrib,
                  TribT.REGTABSG as Trib,
                  cda_carteira.CARTEIRASG as Carteira 
              FROM cda_parcela ";
            $sql .= " LEFT JOIN cda_regtab as SitPagT ON SitPagT.REGTABID=cda_parcela.SitPagId";
            $sql .= " LEFT JOIN cda_regtab as SitCobT ON SitCobT.REGTABID=cda_parcela.SitCobId";
            $sql .= " LEFT JOIN cda_regtab as OrigTribT ON OrigTribT.REGTABID=cda_parcela.OrigTribId";
            $sql .= " LEFT JOIN cda_regtab as TribT ON TribT.REGTABID=cda_parcela.TributoId";
            $sql .= " LEFT JOIN cda_pcrot     ON cda_pcrot.ParcelaId=cda_parcela.ParcelaId";
            $sql .= " LEFT JOIN cda_roteiro   ON cda_roteiro.RoteiroId=cda_pcrot.RoteiroId";
            $sql .= " LEFT JOIN cda_carteira     ON cda_carteira.CARTEIRAID=cda_roteiro.RoteiroId";
            $sql .= " GROUP BY cda_parcela.ParcelaId";

            $valor = $linha->graf_sql_valor . " as Valor";
            $alias = $linha->graf_sql_campo . " as Campo";
            if( $linha->graf_sql_condicao) $where = $linha->graf_sql_condicao;
            $group = $linha->graf_sql_agrupamento;

            if($request->filtros){
                $i=1;
                foreach ($request->filtros as $filtro){
                    $where=str_replace('{{VAR'.$i.'}}', "'$filtro'", $where);
                    $i++;
                }
            }

            $sql = "SELECT $valor,$alias FROM ($sql) as Parcelas WHERE 1 $where";
            if ($group) $sql .= " GROUP BY $group";

            $resultado = DB::select($sql);

            $retorno[$x]['tipo']=$linha['grti_nome'];
            $retorno[$x]['titulo']=$linha['graf_titulo'];
            $retorno[$x]['pai']=$linha['graf_id'];
            $retorno[$x]['ref']=$linha['ref'];
            $y=0;
            foreach ($resultado as $res){
                $retorno[$x]['series']['name']=$linha['graf_subtitulo'];
                $retorno[$x]['series']['data'][$y]['name']=$res->Campo;
                $retorno[$x]['series']['data'][$y]['y']=$res->Valor;
                $retorno[$x]['series']['data'][$y]['drilldown']="drilldown".$linha['graf_grafico_ref'];
                $y++;
            }
            $x++;
        }
        return \response()->json($retorno);
    }

}
