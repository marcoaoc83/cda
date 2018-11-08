<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ExecFilaJob;
use App\Jobs\ExecFilaParcelaJob;
use App\Models\Carteira;
use App\Models\ExecFila;
use App\Models\Fila;
use App\Models\ModCom;
use App\Models\Parcela;
use App\Models\RegTab;
use App\Models\Roteiro;
use App\Models\Tarefas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
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
        $gravar=$request->gravar?true:false;
        ExecFilaParcelaJob::dispatch($request->parcelas,$tarefa->tar_id,$gravar)->onQueue("execfilaparcela");
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

    public function getDadosDataTableSitPag()
    {
        $Var = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 22 order by REGTABNM");
        return Datatables::of($Var)->make(true);
    }

    public function getDadosDataTableSitCob()
    {
        $Var = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 20 order by REGTABNM");
        return Datatables::of($Var)->make(true);
    }

    public function getDadosDataTableOrigTrib()
    {
        $Var = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 16 order by REGTABNM");
        return Datatables::of($Var)->make(true);
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

        if($request->CARTEIRAID){
            $where.=' AND cda_roteiro.CarteiraId IN ('.implode(',',$request->CARTEIRAID).')';
        }

        if($request->CARTEIRAID){
            $where.=' AND cda_roteiro.CarteiraId IN ('.implode(',',$request->CARTEIRAID).')';
        }
        if($request->VencimentoInicio){
            $request->VencimentoInicio=Carbon::createFromFormat('d/m/Y', $request->VencimentoInicio)->format('Y-m-d');
            $where.=" AND cda_parcela.VencimentoDt >='".$request->VencimentoInicio."'";
        }
        if($request->VencimentoFinal){
            $request->VencimentoFinal=Carbon::createFromFormat('d/m/Y', $request->VencimentoFinal)->format('Y-m-d');
            $where.=" AND cda_parcela.VencimentoDt <='".$request->VencimentoFinal."'";
        }

        if($request->ContribuinteId){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',$request->ContribuinteId).')';
        }
        if($request->ContribuinteResId){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',$request->ContribuinteResId).')';
        }

        if($request->SitPagId){
            $where.=' AND cda_parcela.SitPagId IN ('.implode(',',$request->SitPagId).')';
        }

        if($request->SitCobId){
            $where.=' AND cda_parcela.SitCobId IN ('.implode(',',$request->SitCobId).')';
        }

        if($request->OrigTribId){
            $where.=' AND cda_parcela.OrigTribId IN ('.implode(',',$request->OrigTribId).')';
        }
        $Pessoas = Parcela::select([
            'cda_parcela.*',
            DB::raw("datediff(NOW(), MIN(VencimentoDt))  as MAX_VENC"),
            DB::raw("SUM(TotalVr)  as Total"),
            DB::raw("COUNT(cda_parcela.ParcelaId)  as Qtde"),
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

            $regtab=RegTab::whereRaw(' REGTABID IN ('.implode(',',$request->FxValorId).')')->get();
            foreach ($regtab as $value){
                $fxa=explode('*',$value['REGTABSQL']);
                $arrayFxValor[$value['REGTABID']]['Min']=$fxa[0] ;
                $arrayFxValor[$value['REGTABID']]['Max']=isset($fxa[1])?$fxa[1]:null;
                $arrayFxValor[$value['REGTABID']]['Desc']= $value['REGTABSG'];
            }
        }

        $FxAtraso=$FxValor=$Nqtde=[];

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
            if($request->nmaiores && $pessoa['Qtde']<=$request->nmaiores){
                $Nqtde[]=$pessoa['PessoaId'];
            }
            if($request->nmenores && $pessoa['Qtde']>=$request->nmenores){
                $Nqtde[]=$pessoa['PessoaId'];
            }
        }

        if($FxAtraso){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxAtraso)).')';
        }
        if($FxValor){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxValor)).')';
        }
        if($Nqtde){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',$Nqtde).')';
        }

        if($request->filtro_contribuinteC && empty($request->filtro_contribuinteS)){
            $where.=' AND cda_pessoa.CPF_CNPJNR >1';
        }
        if($request->filtro_contribuinteS && empty($request->filtro_contribuinteC)){
            $where.=' AND cda_pessoa.CPF_CNPJNR < 1';
        }
        if($request->filtro_contribuinteN){
            $where.=' AND cda_pessoa.CPF_CNPJNR ='.$request->filtro_contribuinteN;
        }

        if($request->filtro_contribuinteC2 && empty($request->filtro_contribuinteS)){
            $where.=' AND cda_inscrmun.INSCRMUNNR >1';
        }
        if($request->filtro_contribuinteS2 && empty($request->filtro_contribuinteC2)){
            $where.=' AND cda_inscrmun.INSCRMUNNR < 1';
        }
        if($request->filtro_contribuinteN2){
            $where.=' AND cda_inscrmun.INSCRMUNNR ='.$request->filtro_contribuinteN;
        }

        $group='cda_parcela.ParcelaId';
        if($request->group=='Pes'){
            $group='cda_parcela.PessoaId';
        }
        if($request->group=='IM'){
            $group='cda_parcela.InscrMunId';
        }

        $Parcelas = Parcela::select([
            'cda_parcela.*',
            'cda_pessoa.CPF_CNPJNR',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABSG as SitPag',
            'SitCobT.REGTABSG as SitCob',
            'OrigTribT.REGTABSG as OrigTrib',
            'TribT.REGTABSG as Trib',
            DB::raw("sum(cda_parcela.TotalVr)  as TotalVr2"),
            DB::raw("if(cda_pessoa.PESSOANMRS IS NULL,'Não Informado',cda_pessoa.PESSOANMRS) as Nome"),
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as  TribT', 'TribT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.PESSOAID', '=', 'cda_parcela.PessoaId')
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy($group)
            ->limit($limit)
            ->get();


        $i=0;
        $collect=[];
        foreach ($Parcelas as $parcela){
            $collect[$i]['Nome']=$parcela['Nome'];
            $collect[$i]['SitPag']=$parcela['SitPag'];
            $collect[$i]['PessoaId']=$parcela['PessoaId'];
            $collect[$i]['CPFCNPJ']=$parcela['CPF_CNPJNR'];
            $collect[$i]['SitCob']=$parcela['SitCob'];
            $collect[$i]['OrigTrib']=$parcela['OrigTrib'];
            $collect[$i]['Trib']=$parcela['Trib'];
            $collect[$i]['LancamentoNr']=$parcela['LancamentoNr'];
            $collect[$i]['ParcelaNr']=$parcela['ParcelaNr'];
            $collect[$i]['PlanoQt']=$parcela['PlanoQt'];
            $collect[$i]['VencimentoDt']=$parcela['VencimentoDt']->format('d/m/Y');
            $collect[$i]['TotalVr']="R$ ".number_format($parcela['TotalVr2'],2,',','.');
            $collect[$i]['FxAtraso']=$FxAtraso?$arrayFxAtraso[$FxAtraso[$parcela['PessoaId']]]['Desc']:'';
            $collect[$i]['FxValor']=$FxValor?$arrayFxValor[$FxValor[$parcela['PessoaId']]]['Desc']:'';
            $collect[$i]['ParcelaId']=$parcela['ParcelaId'];
            $i++;
        }

        $collection = collect($collect);
        return Datatables::of($collection)->make(true);

    }

    public function getDadosFila(Request $request)
    {
        $fila = Fila::where('FilaTrabId',$request->fila)->first()->toArray();

        return response()->json($fila);
    }

    public function getDadosDataTableCarteira(Request $request)
    {

        $var = Carteira::leftJoin('cda_roteiro', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->join("cda_fila_x_carteira",function($join){
                $join->on("fixca_fila","=","cda_roteiro.FilaTrabId")
                    ->on("fixca_carteira","=","cda_roteiro.CarteiraId");
            })
            ->whereRaw(" cda_roteiro.FilaTrabId = '$request->fila'")
            ->orderBy('cda_carteira.CARTEIRAORD','asc')
            ->groupBy('cda_carteira.CARTEIRAID')
            ->get();

        return Datatables::of($var)->make(true);
    }

    public function getDadosDataTableRoteiro(Request $request)
    {
        $where=1;
        if($request->fila){
            $where.=" AND cda_roteiro.FilaTrabId = '$request->fila'";
        }
        if($request->CARTEIRAID){
            $where.=" AND cda_roteiro.CarteiraId = '$request->CARTEIRAID'";
        }
        $roteiro = Roteiro::select([
            'cda_roteiro.*',
            'Carteira.CARTEIRASG',
            'Fase.REGTABSG as FaseCartNM',
            'Evento.EventoSg as EventoNM',
            'ModCom.ModComSg as ModComNM',
            'FilaTrab.FilaTrabSg as FilaTrabNM',
            'CANAL.CANALSG as CanalNM',
            'PROX.RoteiroOrd as RoteiroProxNM',
        ])
            ->leftJoin('cda_regtab  as Fase', 'Fase.REGTABID', '=', 'cda_roteiro.FaseCartId')
            ->leftJoin('cda_evento as  Evento', 'Evento.EventoId', '=', 'cda_roteiro.EventoId')
            ->leftJoin('cda_modcom  as ModCom', 'ModCom.ModComId', '=', 'cda_roteiro.ModComId')
            ->leftJoin('cda_filatrab  as FilaTrab', 'FilaTrab.FilaTrabId', '=', 'cda_roteiro.FilaTrabId')
            ->leftJoin('cda_canal  as CANAL', 'CANAL.CANALID', '=', 'cda_roteiro.CanalId')
            ->leftJoin('cda_carteira  as Carteira', 'Carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->leftJoin('cda_roteiro  as PROX', 'PROX.RoteiroId', '=', 'cda_roteiro.RoteiroProxId')
            ->join("cda_fila_x_roteiro",function($join){
                $join->on("fixro_fila","=","cda_roteiro.FilaTrabId")
                    ->on("fixro_roteiro","=","cda_roteiro.RoteiroId");
            })
            ->whereRaw($where)
            ->orderBy('cda_roteiro.RoteiroOrd','asc')
            ->get();

        return Datatables::of($roteiro)->make(true);
    }
}
