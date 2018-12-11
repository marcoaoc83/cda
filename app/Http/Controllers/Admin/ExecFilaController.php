<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ExecFilaJob;
use App\Jobs\ExecFilaParcelaJob;
use App\Models\CanalFila;
use App\Models\Carteira;
use App\Models\Evento;
use App\Models\ExecFila;
use App\Models\Fila;
use App\Models\ModCom;
use App\Models\Parcela;
use App\Models\PsCanal;
use App\Models\RegTab;
use App\Models\Roteiro;
use App\Models\Tarefas;
use App\Models\TratRet;
use App\Models\ValEnv;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
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
        ExecFilaParcelaJob::dispatch($request->parcelas,$tarefa->tar_id,$gravar,$request->filaId)->onQueue("execfilaparcela");

        $data = Parcela::select([
            'cda_parcela.*',
            'cda_inscrmun.INSCRMUNNR',
            'cda_pessoa.CPF_CNPJNR',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("if(PagamentoDt='0000-00-00',null,PagamentoDt) as PagamentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABSG as SitPag',
            'SitCobT.REGTABSG as SitCob',
            'OrigTribT.REGTABSG as OrigTrib',
            'TribT.REGTABSG as Trib',
            'cda_parcela.TotalVr',
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
            ->whereIn('cda_parcela.ParcelaId',explode(',',$request->parcelas))
            ->groupBy('cda_parcela.ParcelaId')
            ->orderBy('cda_parcela.ParcelaId')
            ->get();

        if($request->gCSV) {
            $targetpath=storage_path("../public/export");
            $file="fila-".date('Ymd')."-".$tarefa->tar_id;
            Excel::create($file, function ($excel) use ($data) {
                $excel->sheet('mySheet', function ($sheet) use ($data) {
                    foreach ($data as &$dt) {
                        $dt = (array)$dt;
                    }
                    $sheet->fromArray($data);
                });
            })->store("csv",$targetpath);
            $Tarefa= Tarefas::findOrFail($tarefa->tar_id);
            $Tarefa->update([
                'tar_descricao' =>  $Tarefa->tar_descricao."<h6><a href='".URL::to('/')."/export/".$file.".csv' target='_blank'>Arquivo - CSV</a></h6>"
            ]);
        }
        if($request->gTXT) {
            $targetpath=storage_path("../public/export");
            $file="fila-".date('Ymd')."-".$tarefa->tar_id;
            Excel::create($file, function ($excel) use ($data) {
                $excel->sheet('mySheet', function ($sheet) use ($data) {
                    foreach ($data as &$dt) {
                        $dt = (array)$dt;
                    }
                    $sheet->fromArray($data);
                });
            })->store("txt",$targetpath);
            $Tarefa= Tarefas::findOrFail($tarefa->tar_id);
            $Tarefa->update([
                'tar_descricao' =>  $Tarefa->tar_descricao."<h6><a href='".URL::to('/')."/export/".$file.".txt' target='_blank'>Arquivo - TXT</a></h6>"
            ]);

        }
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

    public function getDadosEventos(Request $r)
    {
        $Var =Evento::join('cda_canal_eventos', 'cda_canal_eventos.EventoId', '=', 'cda_evento.EventoId')
            ->join("cda_roteiro","cda_roteiro.CanalId","cda_canal_eventos.CanalId")
            ->where("cda_roteiro.FilaTrabId",$r->fila)
            ->groupBy("cda_evento.EventoId")
            ->get();
        if(count($Var)>0) {
            return Datatables::of($Var)->make(true);
        }else{
            $Var =Evento::where("TpASId",79)
                ->groupBy("cda_evento.EventoId")
                ->get();
            return Datatables::of($Var)->make(true);
        }
    }

    public function getDadosTratRet(Request $r)
    {
        $tratret = TratRet::select(['RetornoCd', 'RetornoCdNr', 'EventoSg','cda_tratret.EventoId','TratRetId'])
            ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_tratret.CanalId')
            ->join("cda_roteiro","cda_roteiro.CanalId","cda_canal.CanalId")
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_tratret.EventoId')
            ->where('cda_roteiro.FilaTrabId',$r->fila)
            ->groupBy("TratRetId")
            ->get();
        if(count($tratret)>0) {
            return Datatables::of($tratret)->make(true);
        }else{
            $tratret = TratRet::select(['RetornoCd', 'RetornoCdNr', 'EventoSg','cda_tratret.EventoId','TratRetId'])
                ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_tratret.CanalId')
                ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_tratret.EventoId')

                ->orderBy("RetornoCdNr")
                ->groupBy("TratRetId")
                ->get();
            return Datatables::of($tratret)->make(true);
        }

    }

    public function getDadosDataTableOrigTrib()
    {
        $Var = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 16 order by REGTABNM");
        return Datatables::of($Var)->make(true);
    }

    public function getDadosDataTableTributo()
    {
        $Var = DB::select("Select cda_regtab.REGTABID, cda_regtab.REGTABSG, cda_regtab.REGTABNM From cda_regtab Where cda_regtab.TABSYSID = 43 order by REGTABSG");
        return Datatables::of($Var)->make(true);
    }

    public function getDadosDataTableParcela(Request $request)
    {
        ini_set('memory_limit', '-1');

        $where=' `cda_pcrot`.`SaidaDt` IS NULL ';

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

        if($request->TributoId){
            $where.=' AND cda_parcela.TributoId IN ('.implode(',',$request->TributoId).')';
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
        }else{
            $regtab= RegTab::where('TABSYSID',32)->get();
        }
        foreach ($regtab as $value){
            $fxa=explode('*',$value['REGTABSQL']);
            $arrayFxAtraso[$value['REGTABID']]['Min']=$fxa[0] ;
            $arrayFxAtraso[$value['REGTABID']]['Max']= isset($fxa[1])?$fxa[1]:null;
            $arrayFxAtraso[$value['REGTABID']]['Desc']= $value['REGTABSG'];
        }

        $arrayFxValor=[];
        if($request->FxValorId) {
            $regtab = RegTab::whereRaw(' REGTABID IN (' . implode(',', $request->FxValorId) . ')')->get();
        }else{
            $regtab= RegTab::where('TABSYSID',33)->get();
        }
        foreach ($regtab as $value){
            $fxa=explode('*',$value['REGTABSQL']);
            $arrayFxValor[$value['REGTABID']]['Min']=$fxa[0] ;
            $arrayFxValor[$value['REGTABID']]['Max']=isset($fxa[1])?$fxa[1]:null;
            $arrayFxValor[$value['REGTABID']]['Desc']= $value['REGTABSG'];
        }


        $FxAtraso=$FxValor=$seqValor=$Nqtde=[];

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
            $seqValor[$pessoa['Total']]=$pessoa['PessoaId'];
//            if($request->nmaiores && $pessoa['Qtde']<=$request->nmaiores){
//                $Nqtde[]=$pessoa['PessoaId'];
//            }
//            if($request->nmenores && $pessoa['Qtde']>=$request->nmenores){
//                $Nqtde[]=$pessoa['PessoaId'];
//            }
        }
        if($request->nmaiores){
            krsort($seqValor);
            foreach ($seqValor as $pess){
                $seqValor2[]=$pess;
            }
            for($x=0;$x<$request->nmaiores;$x++){
                $Nqtde[]=$seqValor2[$x];
            }
        }
        if($request->nmenores){
            ksort($seqValor);
            foreach ($seqValor as $pess){
                $seqValor3[]=$pess;
            }
            for($x=0;$x<$request->nmenores;$x++){
                $Nqtde[]=$seqValor3[$x];
            }
        }

        if($FxAtraso){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxAtraso)).')';
        }elseif($request->FxAtrasoId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
        }

        if($FxValor){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxValor)).')';
        }elseif($request->FxValorId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
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
        $where.=' AND cda_pcrot.SaidaDt is null ';
        $group=['cda_parcela.ParcelaId','cda_roteiro.CarteiraId'];
        if($request->group=='Pes'){
            $group='cda_parcela.PessoaId';
        }
        if($request->group=='IM'){
            $group='cda_parcela.InscrMunId';
        }

        $Parcelas = Parcela::select([
            'cda_parcela.*',
            'cda_inscrmun.INSCRMUNNR',
            'cda_pessoa.CPF_CNPJNR',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABSG as SitPag',
            'SitCobT.REGTABSG as SitCob',
            'OrigTribT.REGTABSG as OrigTrib',
            'TribT.REGTABSG as Trib',
            'cda_carteira.CARTEIRASG as Carteira',
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
            ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy($group)
            ->orderBy('cda_parcela.PessoaId')
            ->orderBy('cda_parcela.ParcelaId')
            ->limit($limit)
            ->get();


        $i=0;
        $collect=[];
        foreach ($Parcelas as $parcela){
            $doc='';
            if(strlen($parcela['CPF_CNPJNR'])==11){
                $doc= self::maskString($parcela['CPF_CNPJNR'],'###.###.###-##');
            }
            if(strlen($parcela['CPF_CNPJNR'])==14){
                $doc= self::maskString($parcela['CPF_CNPJNR'],'##.###.###/####-##');
            }
            $collect[$i]['Nome']=$parcela['Nome'];
            $collect[$i]['Carteira']=$parcela['Carteira'];
            $collect[$i]['SitPag']=$parcela['SitPag'];
            $collect[$i]['PessoaId']=$parcela['PessoaId'];
            $collect[$i]['INSCRMUNNR']=$parcela['INSCRMUNNR'];
            $collect[$i]['CPFCNPJ']=$doc;
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

            ->whereRaw(" cda_roteiro.FilaTrabId = '$request->fila'")
            ->orderBy('cda_carteira.CARTEIRAORD','asc')
            ->groupBy('cda_carteira.CARTEIRAID')
            ->get();

        return Datatables::of($var)->make(true);
    }

    public function getDadosDataTableValidacao(Request $request){

        $valenv = ValEnv::select(['cda_valenv.id','REGTABSG', 'REGTABNM', 'EventoSg','cda_valenv.EventoId','cda_valenv.ValEnvId'])
            ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_valenv.CanalId')
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_valenv.ValEnvId')
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_valenv.EventoId')
            ->get();

        return Datatables::of($valenv)->make(true);
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
            'CANAL.CANALID as CANALID',
            'PROX.RoteiroOrd as RoteiroProxNM',
        ])
            ->leftJoin('cda_regtab  as Fase', 'Fase.REGTABID', '=', 'cda_roteiro.FaseCartId')
            ->leftJoin('cda_evento as  Evento', 'Evento.EventoId', '=', 'cda_roteiro.EventoId')
            ->leftJoin('cda_modcom  as ModCom', 'ModCom.ModComId', '=', 'cda_roteiro.ModComId')
            ->leftJoin('cda_filatrab  as FilaTrab', 'FilaTrab.FilaTrabId', '=', 'cda_roteiro.FilaTrabId')
            ->leftJoin('cda_canal  as CANAL', 'CANAL.CANALID', '=', 'cda_roteiro.CanalId')
            ->leftJoin('cda_carteira  as Carteira', 'Carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->leftJoin('cda_roteiro  as PROX', 'PROX.RoteiroId', '=', 'cda_roteiro.RoteiroProxId')

            ->whereRaw($where)
            ->orderBy('cda_roteiro.RoteiroOrd','asc')
            ->get();

        return Datatables::of($roteiro)->make(true);
    }

    /**
     * Função para mascarar uma string, mascara tipo ##-##-##
     *
     * @param string $val
     * @param string $mask
     *
     * @return string
     */
    public static function maskString($val, $mask)
    {
        if (empty($val)) {
            return $val;
        }
        $maskared = '';
        $k = 0;
        if (is_numeric($val)) {
            $val = sprintf('%0' . mb_strlen(preg_replace('/[^#]/', '', $mask)) . 's', $val);
        }
        for ($i = 0; $i <= mb_strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }

        return $maskared;
    }

    public function getDadosDataTableValidar(Request $request)
    {
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }
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

        if($request->TributoId){
            $where.=' AND cda_parcela.TributoId IN ('.implode(',',$request->TributoId).')';
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
        }else{
            $regtab= RegTab::where('TABSYSID',32)->get();
        }
        foreach ($regtab as $value){
            $fxa=explode('*',$value['REGTABSQL']);
            $arrayFxAtraso[$value['REGTABID']]['Min']=$fxa[0] ;
            $arrayFxAtraso[$value['REGTABID']]['Max']= isset($fxa[1])?$fxa[1]:null;
            $arrayFxAtraso[$value['REGTABID']]['Desc']= $value['REGTABSG'];
        }

        $arrayFxValor=[];
        if($request->FxValorId) {
            $regtab = RegTab::whereRaw(' REGTABID IN (' . implode(',', $request->FxValorId) . ')')->get();
        }else{
            $regtab= RegTab::where('TABSYSID',33)->get();
        }
        foreach ($regtab as $value){
            $fxa=explode('*',$value['REGTABSQL']);
            $arrayFxValor[$value['REGTABID']]['Min']=$fxa[0] ;
            $arrayFxValor[$value['REGTABID']]['Max']=isset($fxa[1])?$fxa[1]:null;
            $arrayFxValor[$value['REGTABID']]['Desc']= $value['REGTABSG'];
        }


        $FxAtraso=$FxValor=$seqValor=$Nqtde=[];

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
            $seqValor[$pessoa['Total']]=$pessoa['PessoaId'];
//            if($request->nmaiores && $pessoa['Qtde']<=$request->nmaiores){
//                $Nqtde[]=$pessoa['PessoaId'];
//            }
//            if($request->nmenores && $pessoa['Qtde']>=$request->nmenores){
//                $Nqtde[]=$pessoa['PessoaId'];
//            }
        }
        if($request->nmaiores){
            krsort($seqValor);
            foreach ($seqValor as $pess){
                $seqValor2[]=$pess;
            }
            for($x=0;$x<$request->nmaiores;$x++){
                $Nqtde[]=$seqValor2[$x];
            }
        }
        if($request->nmenores){
            ksort($seqValor);
            foreach ($seqValor as $pess){
                $seqValor3[]=$pess;
            }
            for($x=0;$x<$request->nmenores;$x++){
                $Nqtde[]=$seqValor3[$x];
            }
        }

        if($FxAtraso){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxAtraso)).')';
        }elseif($request->FxAtrasoId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
        }

        if($FxValor){
            $where.=' AND cda_parcela.PessoaId IN ('.implode(',',array_keys($FxValor)).')';
        }elseif($request->FxValorId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
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
        $where.=' AND cda_pcrot.SaidaDt is null ';
        $group=['cda_parcela.ParcelaId','cda_roteiro.CarteiraId'];
        if($request->group=='Pes'){
            $group='cda_parcela.PessoaId';
        }
        if($request->group=='IM'){
            $group='cda_parcela.InscrMunId';
        }

        $Parcelas = Parcela::select([
            'cda_parcela.*',
            'cda_roteiro.CanalId',
            'cda_roteiro.FilaTrabId'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as  TribT', 'TribT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.PESSOAID', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy($group)
            ->orderBy('cda_parcela.ParcelaId')
            ->limit($limit)
            ->get();


        $i=0;
        $collect=[];
        $Validacao=[];
        $x=0;
        foreach ($Parcelas as $parcela){
            $pessoa=$parcela['PessoaId'];
            $canal =$parcela['CanalId'];
            $fila =$parcela['FilaTrabId'];
            $pscanais = PsCanal::select([
                'cda_pscanal.PsCanalId',
                'cda_pscanal.PessoaId',
                'cda_pscanal.InscrMunId',
                'cda_pscanal.FonteInfoId',
                'cda_pscanal.CanalId',
                'cda_pscanal.TipPosId',
                'cda_pscanal.CEP',
                'cda_pscanal.LogradouroId',
                'cda_pscanal.EnderecoNr',
                'cda_pscanal.Complemento',
                'cda_pscanal.TelefoneNr',
                'cda_pscanal.Email',
                'cda_pscanal.BairroId',
                'cda_pscanal.CidadeId',
                'cda_cidade.cida_uf as UF',
                'FonteInfoId.REGTABSG as FonteInfo',
                'TipPosId.REGTABNM as TipPos',
                'cda_canal.CANALSG',
                'cda_inscrmun.INSCRMUNNR',
                'cda_pessoa.PESSOANMRS as Nome',
                DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
                DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
                DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade')
            ])
                ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
                ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
                ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
                ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
                ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
                ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
                ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
                ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_pscanal.PessoaId')
                ->where('cda_pscanal.PessoaId',$pessoa)
                ->where('cda_pscanal.CanalId',$canal)
                ->where('cda_pscanal.Ativo',1)
                ->get()->toArray();

            //error_log(print_r($pscanais,1));

            foreach ($pscanais as $dado){
                $dado=array_change_key_case($dado,CASE_LOWER);


                $ValEnv= ValEnv::join('cda_evento','cda_evento.EventoId','=','cda_valenv.EventoId')
                    ->join('cda_regtab','cda_regtab.REGTABID','=','cda_valenv.ValEnvId')
                    ->where('cda_valenv.CanalId',$dado['canalid'])
                    ->get();

                foreach ($ValEnv as $val){
                    $sql=$val->REGTABSQL;
                    $sql=explode("*",$sql);
                    list($campo, $sinal, $valor) = $sql;
                    //error_log(print_r($dado,1));
                    if(strtolower($valor)=='null'){
                        //error_log(print_r($dado,1));

                        if(empty($dado[strtolower($campo)])){

                            $Dados=$dado['logradouro'].' '.$dado['endereconr'].' '.$dado['bairro'].' '.$dado['cidade'].' '.$dado['uf'].' '.$dado['cep'].' '.$dado['email'].' '.$dado['telefonenr'];
                            //error_log($campo.'='.$Dados);
                            $Validacao[$x]['PessoaId']=$dado['pessoaid'];
                            $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
                            $Validacao[$x]['EventoId']=$val->EventoId;
                            $Validacao[$x]['FilaTrabId']=2;
                            $Validacao[$x]['Nome']=$dado['nome'];
                            $Validacao[$x]['Canal']=$dado['canalsg'];
                            $Validacao[$x]['TipoPos']=$dado['tippos'];
                            $Validacao[$x]['Evento']=$val->EventoNm;
                            $Validacao[$x]['Fonte']=$dado['fonteinfo'];
                            $Validacao[$x]['Dados']=trim($Dados);


                            $x++;
                        }
                    }else{
                        $com=$dado[strtolower($campo)].$sinal.$valor;
                        if(eval($com)){
                            $Dados=$dado['logradouro'].' '.$dado['endereconr'].' '.$dado['bairro'].' '.$dado['cidade'].' '.$dado['uf'].' '.$dado['cep'].' '.$dado['email'].' '.$dado['telefonenr'];
                            //error_log($campo.'='.$Dados);
                            $Validacao[$x]['PessoaId']=$dado['pessoaid'];
                            $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
                            $Validacao[$x]['EventoId']=$val->EventoId;
                            $Validacao[$x]['FilaTrabId']=2;
                            $Validacao[$x]['Nome']=$dado['nome'];
                            $Validacao[$x]['Canal']=$dado['canalsg'];
                            $Validacao[$x]['Evento']=$val->EventoNm;
                            $Validacao[$x]['TipoPos']=$dado['tippos'];
                            $Validacao[$x]['Fonte']=$dado['fonteinfo'];
                            $Validacao[$x]['Dados']=trim($Dados);
                            $x++;
                        }
                    }

                }
            }

        }

        $collection = collect($Validacao);
        return Datatables::of($collection)->make(true);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validar(Request $request)
    {
        $dados=(json_decode($request->dados, true));
        $tarefa=Tarefas::create([
            'tar_categoria' => 'execValidacao',
            'tar_titulo' => 'Execução de Fila de Emissão de Cartas – Validação',
            'tar_user' => auth()->id(),
            'tar_inicio' => date("Y-m-d H:i:s"),
            'tar_final' => date("Y-m-d H:i:s"),
            'tar_status' => 'Finalizado'
        ]);
        if($request->csv){
            $targetpath=storage_path("../public/export");
            $file=md5(uniqid(rand(), true));
            $csv= Excel::create($file, function($excel) use ($dados) {
                $excel->sheet('mySheet', function($sheet) use ($dados)
                {
                    $sheet->fromArray($dados);
                });
            })->store("csv",$targetpath);
            $Tarefa= Tarefas::findOrFail($tarefa->tar_id);
            $Tarefa->update([
                'tar_descricao' =>  $Tarefa->tar_descricao."<h6><a href='".URL::to('/')."/export/".$file.".csv' target='_blank'>Arquivo - CSV</a></h6>"
            ]);
        }
        if($request->txt){
            $targetpath=storage_path("../public/export");
            $file=md5(uniqid(rand(), true));
            $csv= Excel::create($file, function($excel) use ($dados) {
                $excel->sheet('mySheet', function($sheet) use ($dados)
                {
                    $sheet->fromArray($dados);
                });
            })->store("txt",$targetpath);

            $Tarefa= Tarefas::findOrFail($tarefa->tar_id);
            $Tarefa->update([
                'tar_descricao' =>  $Tarefa->tar_descricao."<h6><a href='".URL::to('/')."/export/".$file.".txt' target='_blank'>Arquivo - TXT</a></h6>"
            ]);
        }
        if($request->gravar){
            foreach ($dados as $dado){
                PsCanal::findOrFail($dado['PsCanalId'])->update(['Ativo'=>0]);
                CanalFila::create([
                    'cafi_fila' => $dado['FilaTrabId'],
                    'cafi_pscanal' => $dado['PsCanalId'],
                    'cafi_evento' => $dado['EventoId'],
                    'cafi_entrada' => Carbon::now()->format('Y-m-d')
                ]);
            }
        }
        return \response()->json(true);
    }

    public function getDadosDataTableValidacoes(Request $request)
    {
        $where=1;
        if($request->fila){
            $where.=" AND cda_roteiro.FilaTrabId = '$request->fila'";
        }

        $canal = Roteiro::select([
            'CANAL.CANALID as CANALID'
        ])
            ->leftJoin('cda_regtab  as Fase', 'Fase.REGTABID', '=', 'cda_roteiro.FaseCartId')
            ->leftJoin('cda_evento as  Evento', 'Evento.EventoId', '=', 'cda_roteiro.EventoId')
            ->leftJoin('cda_modcom  as ModCom', 'ModCom.ModComId', '=', 'cda_roteiro.ModComId')
            ->leftJoin('cda_filatrab  as FilaTrab', 'FilaTrab.FilaTrabId', '=', 'cda_roteiro.FilaTrabId')
            ->leftJoin('cda_canal  as CANAL', 'CANAL.CANALID', '=', 'cda_roteiro.CanalId')
            ->leftJoin('cda_carteira  as Carteira', 'Carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->leftJoin('cda_roteiro  as PROX', 'PROX.RoteiroId', '=', 'cda_roteiro.RoteiroProxId')

            ->whereRaw($where)
            ->orderBy('cda_roteiro.RoteiroOrd','asc')
            ->get();

        $canais=[];
        foreach ($canal as $cn){
            $canais[]=$cn->CANALID;
        }

        $valenv = ValEnv::select(['cda_valenv.id','REGTABSG', 'REGTABNM', 'EventoSg','cda_valenv.EventoId','cda_valenv.ValEnvId'])
            ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_valenv.CanalId')
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_valenv.ValEnvId')
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_valenv.EventoId');
        if(count($canais)>0){
            $valenv->whereIn('cda_canal.CANALID',$canais);
        }
        $valenv->get();

        return Datatables::of($valenv)->make(true);
    }

    public function getDadosDataTableTratRetorno(Request $request){
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }
        $Retorno=ExecFila::select(['*'])
            ->join("cda_execfila_pscanal","cda_execfila.exfi_lote","=","cda_execfila_pscanal.Lote");

        if($request->notLote){
            $Retorno->where("cda_execfila.exfi_lote",$request->notLote);
        }
        if($request->notNotificacao){
            $Retorno->where("cda_execfila_pscanal.efpa_id",$request->notNotificacao);
        }
        if($request->notInicio){
            $notInicio=Carbon::createFromFormat('d/m/Y', $request->notInicio)->format('Y-m-d');
            $Retorno->where("cda_execfila.exfi_data",">=",$notInicio);
        }
        if($request->notFinal){
            $notFinal=Carbon::createFromFormat('d/m/Y', $request->notFinal)->format('Y-m-d');
            $Retorno->where("cda_execfila.exfi_data","<=",$notFinal);
        }
        $resultado=$Retorno->get();
        $x=0;
        $Validacao=[];
        foreach ($resultado as $linha){
            $pscanais = PsCanal::select([
                'cda_pscanal.PsCanalId',
                'cda_pscanal.PessoaId',
                'cda_pscanal.InscrMunId',
                'cda_pscanal.FonteInfoId',
                'cda_pscanal.CanalId',
                'cda_pscanal.TipPosId',
                'cda_pscanal.CEP',
                'cda_pscanal.LogradouroId',
                'cda_pscanal.EnderecoNr',
                'cda_pscanal.Complemento',
                'cda_pscanal.TelefoneNr',
                'cda_pscanal.Email',
                'cda_pscanal.BairroId',
                'cda_pscanal.CidadeId',
                'cda_cidade.cida_uf as UF',
                'FonteInfoId.REGTABSG as FonteInfo',
                'TipPosId.REGTABNM as TipPos',
                'cda_canal.CANALSG',
                'cda_inscrmun.INSCRMUNNR',
                'cda_pessoa.PESSOANMRS as Nome',
                DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
                DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
                DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade')
            ])
                ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
                ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
                ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
                ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
                ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
                ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
                ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
                ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_pscanal.PessoaId')
                ->where('cda_pscanal.PsCanalId',$linha->PsCanalId)
                ->first()->toArray();

            $dado=array_change_key_case($pscanais,CASE_LOWER);
            $Dados=$dado['logradouro'].' '.$dado['endereconr'].' '.$dado['bairro'].' '.$dado['cidade'].' '.$dado['uf'].' '.$dado['cep'].' '.$dado['email'].' '.$dado['telefonenr'];
            $Validacao[$x]['PessoaId']=$dado['pessoaid'];
            $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
            $Validacao[$x]['EventoId']="";
            $Validacao[$x]['FilaTrabId']=2;
            $Validacao[$x]['Nome']=$dado['nome'];
            $Validacao[$x]['Canal']=$dado['canalsg'];
            $Validacao[$x]['Evento']="";
            $Validacao[$x]['Dados']=trim($Dados);
            $Validacao[$x]['Lote']=trim($linha->Lote);
            $Validacao[$x]['Notificacao']=trim($linha->efpa_id);
            $x++;
        }

        $collection = collect($Validacao);
        return Datatables::of($collection)->addColumn('action', function ($pessoa) {

            return '
                <a href="#" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Novo</a>
                <a href="#" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                ';
        })->make(true);
    }

    function getDadosDataTableParcelasExec(Request $request){
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }
        $Parcelas = Parcela::select([
            'cda_parcela.*',
            'cda_inscrmun.INSCRMUNNR',
            'cda_pessoa.CPF_CNPJNR',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABSG as SitPag',
            'SitCobT.REGTABSG as SitCob',
            'OrigTribT.REGTABSG as OrigTrib',
            'TribT.REGTABSG as Trib',
            'cda_carteira.CARTEIRASG as Carteira',
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
            ->join('cda_execfila_pscanal_parcela', 'cda_execfila_pscanal_parcela.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.PESSOAID', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->where("cda_execfila_pscanal_parcela.Lote",$request->lote)
            ->where("cda_execfila_pscanal_parcela.Notificacao",$request->notificacao)
            ->groupBy("cda_parcela.ParcelaId")
            ->orderBy('cda_parcela.ParcelaId')
            ->get();


        $i=0;
        $collect=[];
        foreach ($Parcelas as $parcela){
            $doc='';
            if(strlen($parcela['CPF_CNPJNR'])==11){
                $doc= self::maskString($parcela['CPF_CNPJNR'],'###.###.###-##');
            }
            if(strlen($parcela['CPF_CNPJNR'])==14){
                $doc= self::maskString($parcela['CPF_CNPJNR'],'##.###.###/####-##');
            }
            $collect[$i]['Nome']=$parcela['Nome'];
            $collect[$i]['Carteira']=$parcela['Carteira'];
            $collect[$i]['SitPag']=$parcela['SitPag'];
            $collect[$i]['PessoaId']=$parcela['PessoaId'];
            $collect[$i]['INSCRMUNNR']=$parcela['INSCRMUNNR'];
            $collect[$i]['CPFCNPJ']=$doc;
            $collect[$i]['SitCob']=$parcela['SitCob'];
            $collect[$i]['OrigTrib']=$parcela['OrigTrib'];
            $collect[$i]['Trib']=$parcela['Trib'];
            $collect[$i]['LancamentoNr']=$parcela['LancamentoNr'];
            $collect[$i]['ParcelaNr']=$parcela['ParcelaNr'];
            $collect[$i]['PlanoQt']=$parcela['PlanoQt'];
            $collect[$i]['VencimentoDt']=$parcela['VencimentoDt']->format('d/m/Y');
            $collect[$i]['TotalVr']="R$ ".number_format($parcela['TotalVr2'],2,',','.');
            $collect[$i]['ParcelaId']=$parcela['ParcelaId'];
            $i++;
        }

        $collection = collect($collect);
        return Datatables::of($collection)->make(true);
    }
}
