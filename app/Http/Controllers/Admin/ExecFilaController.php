<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ExecFilaJob;
use App\Jobs\ExecFilaParcelaJob;
use App\Models\ExecFila;
use App\Models\Fila;
use App\Models\Parcela;
use App\Models\RegTab;
use App\Models\Tarefas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class ExecFilaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_evento = DB::table('cda_evento')->get();
        $FilaTrab = DB::table('cda_filatrab')->get();
        return view('admin.execfila.index',compact('FilaTrab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $fila = Fila::find($request->filaId);
        $tarefa=Tarefas::create([
            'tar_categoria' => 'execfilaParcela',
            'tar_titulo' => 'Execução de '.$fila->FilaTrabNm,
            'tar_status' => 'Aguardando'
        ]);

        ExecFilaParcelaJob::dispatch($request->parcelas,$tarefa->tar_id)->onQueue("execfilaparcela");
        SWAL::message('Salvo','Execução de Fila enviada para lista de tarefas!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('execfila.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExecFila  $execFila
     * @return \Illuminate\Http\Response
     */
    public function show(ExecFila $execFila)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExecFila  $execFila
     * @return \Illuminate\Http\Response
     */
    public function edit(ExecFila $execFila)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExecFila  $execFila
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExecFila $execFila)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExecFila  $execFila
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExecFila $execFila)
    {
        //
    }


    public function getDadosDataTableFxAtraso()
    {
        $FxAtraso = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 32");

        return Datatables::of($FxAtraso)->make(true);
    }

    public function getDadosDataTableFxValor()
    {
        $FxValor = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 33");
        return Datatables::of($FxValor)->make(true);
    }

    public function getDadosDataTableParcela(Request $request)
    {
        ini_set('memory_limit', '-1');

        $where=' 1 ';

        $limit=100000;
        if($request->limit!=null){
            $limit=$request->limit;
        }

        if($request->FilaTrabId){
            $where.=' AND cda_roteiro.FilaTrabId='.$request->FilaTrabId;
        }

        if($request->roteirosId){
            $where.=' AND cda_roteiro.RoteiroId IN ('.implode(',',$request->roteirosId).')';
        }

        if($request->VencimentoInicio){
            $request->VencimentoInicio=Carbon::createFromFormat('d/m/Y', $request->VencimentoInicio)->format('Y-m-d');
            $where.=" AND cda_parcela.VencimentoDt >='".$request->VencimentoInicio."'";
        }
        if($request->VencimentoFinal){
            $request->VencimentoFinal=Carbon::createFromFormat('d/m/Y', $request->VencimentoFinal)->format('Y-m-d');
            $where.=" AND cda_parcela.VencimentoDt <='".$request->VencimentoFinal."'";
        }

        $Pessoas = Parcela::select([
            'cda_parcela.*',
            DB::raw("datediff(NOW(), MAX(VencimentoDt))  as MAX_VENC"),
            DB::raw("SUM(TotalVr)  as Total"),
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy('cda_parcela.PessoaId')
            ->limit($limit)
            ->get();
        $arrayFxAtraso=[];
        if($request->FxAtrasoId){

            $regtab=RegTab::whereRaw(' REGTABID IN ('.implode(',',$request->FxAtrasoId).')')->get();
            foreach ($regtab as $value){
                $fxa=explode('*',$value['REGTABSQL']);
                $arrayFxAtraso[$value['REGTABID']]['Min']=$fxa[0] ;
                $arrayFxAtraso[$value['REGTABID']]['Max']= isset($fxa[1])?$fxa[1]:null;
                $arrayFxAtraso[$value['REGTABID']]['Desc']= $value['REGTABSG'];
            }

        }
        $arrayFxValor=[];
        if($request->FxValorId){

            $regtab=RegTab::whereRaw(' REGTABID IN ('.implode(',',$request->FxAtrasoId).')')->get();
            foreach ($regtab as $value){
                $fxa=explode('*',$value['REGTABSQL']);
                $arrayFxValor[$value['REGTABID']]['Min']=$fxa[0] ;
                $arrayFxValor[$value['REGTABID']]['Max']=isset($fxa[1])?$fxa[1]:null;
                $arrayFxValor[$value['REGTABID']]['Desc']= $value['REGTABSG'];
            }
        }
        $FxAtraso=$FxValor=[];



        foreach ($Pessoas as $pessoa){
            foreach ($arrayFxAtraso as $key=>$value){
                if($pessoa['MAX_VENC']>$value['Min']){
                    if($value['Max']){
                        if($pessoa['MAX_VENC']<=$value['Max']){
                            $FxAtraso[$pessoa['PessoaId']]=$key;
                        }
                    }else{
                        $FxAtraso[$pessoa['PessoaId']]=$key;
                    }
                }
            }
            foreach ($arrayFxValor as $key=>$value){
                if($pessoa['Total']>$value['Min']){
                    if($value['Max']){
                        if($pessoa['Total']<=$value['Max']){
                            $FxValor[$pessoa['PessoaId']]=$key;
                        }
                    }else{
                        $FxValor[$pessoa['PessoaId']]=$key;
                    }
                }
            }
        }

        if($FxAtraso){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxAtraso)).')';
        }
        if($FxValor){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxValor)).')';
        }

        $Parcelas = Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABNM as SitPag',
            'OrigTribT.REGTABNM as OrigTrib',
            DB::raw("if(cda_pessoa.PESSOANMRS IS NULL,'Não Informado',cda_pessoa.PESSOANMRS) as Nome"),
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy('cda_parcela.ParcelaId')
            ->limit($limit)
            ->get();


        $i=0;
        $collect=[];
        foreach ($Parcelas as $parcela){
            $collect[$i]['Nome']=$parcela['Nome'];
            $collect[$i]['SitPag']=$parcela['SitPag'];
            $collect[$i]['OrigTrib']=$parcela['OrigTrib'];
            $collect[$i]['LancamentoNr']=$parcela['LancamentoNr'];
            $collect[$i]['ParcelaNr']=$parcela['ParcelaNr'];
            $collect[$i]['PlanoQt']=$parcela['PlanoQt'];
            $collect[$i]['VencimentoDt']=$parcela['VencimentoDt']->format('d/m/Y');
            $collect[$i]['TotalVr']=$parcela['TotalVr'];
            $collect[$i]['FxAtraso']=$FxAtraso?$arrayFxAtraso[$FxAtraso[$parcela['PessoaId']]]['Desc']:'';
            $collect[$i]['FxValor']=$FxValor?$arrayFxValor[$FxValor[$parcela['PessoaId']]]['Desc']:'';
            $collect[$i]['ParcelaId']=$parcela['ParcelaId'];
            $i++;
        }

        $collection = collect($collect);
        return Datatables::of($collection)->make(true);

    }
}
