<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ExecFilaJob;
use App\Jobs\ExecFilaParcelaJob;
use App\Models\Bairro;
use App\Models\CanalFila;
use App\Models\Carteira;
use App\Models\Cidade;
use App\Models\Evento;
use App\Models\ExecFila;
use App\Models\ExecFilaPsCanal;
use App\Models\ExecFilaPsCanalParcela;
use App\Models\Fila;
use App\Models\Logradouro;
use App\Models\ModCom;
use App\Models\Parcela;
use App\Models\PortalAdm;
use App\Models\PrRotCanal;
use App\Models\PsCanal;
use App\Models\RegTab;
use App\Models\Roteiro;
use App\Models\Tarefas;
use App\Models\TratRet;
use App\Models\ValEnv;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        $FonteInfoId=\App\Models\RegTab::join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')->where('TABSYSSG','FonteInfo')->get();
        $Canal=\App\Models\Canal::get();
        $TipPos=\App\Models\RegTab::join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')->where('TABSYSSG','TpPos')->get();
        $Trat=TratRet::all();
        return view('admin.execfila.index',compact('FilaTrab','Canal','FonteInfoId','TipPos','Trat'));
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
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
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
            ->join("cda_roteiro","cda_roteiro.CanalId","cda_canal_eventos.CanalId");
        if($r->fila){
            $Var->where("cda_roteiro.FilaTrabId",$r->fila);
        }
        if($r->canal){
            $Var->where("cda_canal_eventos.CanalId",$r->canal);
        }
        $Var->get();

        $pkCount = (is_array($Var) ? count($Var) : 0);
        if ($pkCount == 0){
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
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_tratret.EventoId');
        if($r->fila){
            $tratret->where('cda_roteiro.FilaTrabId',$r->fila);
        }
        if($r->canal){
            $tratret->where('cda_canal.CanalId',$r->canal);
        }
        $tratret->groupBy("TratRetId")->get();
        $pkCount = (is_array($tratret) ? count($tratret) : 0);
        if ($pkCount == 0){
            return Datatables::of($tratret)->make(true);
        }else{
            $tratret = TratRet::select(['RetornoCd', 'RetornoCdNr', 'EventoSg','cda_tratret.EventoId','TratRetId'])
                ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_tratret.CanalId')
                ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_tratret.EventoId');
            if($r->canal){
                $tratret->where('cda_canal.CanalId',$r->canal);
            }
            $tratret->orderBy("RetornoCdNr")
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
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }
        ini_set('memory_limit', '-1');
        $limit=100000;

        $where=self::filtroParcela($request,$FxAtraso,$FxValor,$arrayFxValor,$arrayFxAtraso);

        if(empty($where)){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }

        $group=['cda_parcela.ParcelaId','cda_roteiro.CarteiraId'];
        if($request->group=='Pes'){
            $group='cda_parcela.PessoaId';
        }
        if($request->group=='IM'){
            $group='cda_inscrmun.InscrMunId';
        }

        $Parcelas = Parcela::select([
            'cda_parcela.*',
            'cda_inscrmun.INSCRMUNNR',
            'cda_inscrmun.INSCRMUNID',
            'cda_pessoa.CPF_CNPJNR',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            DB::raw("datediff(NOW(), VencimentoDt)  as Atraso"),
            'SitPagT.REGTABSG as SitPag',
            'SitCobT.REGTABSG as SitCob',
            'OrigTribT.REGTABSG as OrigTrib',
            'TribT.REGTABSG as Trib',
            'cda_carteira.CARTEIRASG as Carteira',
            'cda_modcom.ModComSg as ModComSg',
            DB::raw("sum(cda_parcela.TotalVr)  as TotalVr2"),
            DB::raw("if(cda_pessoa.PESSOANMRS IS NULL,'Não Informado',cda_pessoa.PESSOANMRS) as Nome"),
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as  TribT', 'TribT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->leftjoin('cda_modcom', 'cda_roteiro.ModComId', '=', 'cda_modcom.ModComId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
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
            $collect[$i]['Modelo']=$parcela['ModComSg'];
            $collect[$i]['Carteira']=$parcela['Carteira'];
            $collect[$i]['SitPag']=$parcela['SitPag'];
            $collect[$i]['PessoaId']=$parcela['PessoaId'];
            $collect[$i]['INSCRMUNNR']=$parcela['INSCRMUNNR'];
            $collect[$i]['INSCRMUNID']=$parcela['INSCRMUNID'];
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
            if($request->group=='IM'){
                $collect[$i]['FxAtraso']=$FxAtraso?$arrayFxAtraso[$FxAtraso[$parcela['InscrMunId']]]['Desc']:'';
            }
            $collect[$i]['FxValor']=$FxValor?$arrayFxValor[$FxValor[$parcela['PessoaId']]]['Desc']:'';
            if($request->group=='IM'){
                $collect[$i]['FxValor']=$FxValor?$arrayFxValor[$FxValor[$parcela['InscrMunId']]]['Desc']:'';
            }
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

        if($roteiro->count()==0){
            $where="1";
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
        }
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
                if( $dado['TransfCtrId'] ==81 && !empty($dado['TransfFilaTrabId']))
                CanalFila::create([
                    'cafi_fila' => $dado['TransfFilaTrabId'],
                    'cafi_fila_origem' => $dado['FilaTrabId'],
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
        if($request->canal){
            $canais=[];
            $canais[]=$request->canal;
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
            $where=" (cda_canal_fila.cafi_entrada is null or cda_canal_fila.cafi_saida is not null)";
            if($request->ContribuinteResId){
                $where.=' AND cda_pscanal.PessoaId IN ('.implode(',',$request->ContribuinteResId).')';
            }
            if($request->ContribuinteResIMId && ($request->group!='IM')){
                $where.=' AND cda_pscanal.InscrMunId IN ('.implode(',',$request->ContribuinteResIMId).')';
            }
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
                'cda_inscrmun.INSCRMUNID',
                'cda_inscrmun.INSCRMUNNR',
                'cda_pessoa.PESSOANMRS as Nome',
                'cda_pessoa.CPF_CNPJNR as Documento',
                DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
                DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
                DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade'),
                DB::raw('IF(cda_cidade.cida_uf IS NOT NULL , cda_cidade.cida_uf,cda_pscanal.UF) AS UF')
            ])
                ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
                ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
                ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
                ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
                ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
                ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
                ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
                ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_pscanal.PessoaId')
                ->leftjoin('cda_canal_fila', 'cda_canal_fila.cafi_pscanal', '=', 'cda_pscanal.PsCanalId')
                ->where('cda_pscanal.PsCanalId',$linha->PsCanalId)
                ->where('cda_pscanal.CanalId',$request->Canal)
                ->where('cda_pscanal.Ativo',1)
                ->whereRaw($where)
                ->first();

            if ($pscanais) {
                $pscanais = $pscanais->toArray();
            }else{
                continue;
            }

            $dado=array_change_key_case($pscanais,CASE_LOWER);
            $Dados=$dado['logradouro'].' '.$dado['endereconr'].' '.$dado['bairro'].' '.$dado['cidade'].' '.$dado['uf'].' '.$dado['cep'].' '.$dado['email'].' '.$dado['telefonenr'];
            $Validacao[$x]['PessoaId']=$dado['pessoaid'];
            $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
            $Validacao[$x]['EventoId']="";
            $Validacao[$x]['FilaTrabId']=2;
            $Validacao[$x]['Nome']=$dado['nome'];
            $Validacao[$x]['Documento']=$dado['documento'];
            $Validacao[$x]['Canal']=$dado['canalsg'];
            $Validacao[$x]['CanalId']=$dado['canalid'];
            $Validacao[$x]['INSCRMUNID']=$dado['inscrmunid'];
            $Validacao[$x]['INSCRMUNNR']=$dado['inscrmunnr'];
            $Validacao[$x]['Evento']="";
            $Validacao[$x]['Fonte']="";
            $Validacao[$x]['TipoPos']="";
            $Validacao[$x]['Dados']=trim($Dados);
            $Validacao[$x]['Lote']=trim($linha->Lote);
            $Validacao[$x]['Notificacao']=trim($linha->efpa_id);
            $x++;
        }
        if($request->group=='Pes'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['PessoaId']]['PessoaId']=$value['PessoaId'];
                $tempValidacao[$value['PessoaId']]['Nome']=$value['Nome'];
                $tempValidacao[$value['PessoaId']]['CPFCNPJ']=$value['Documento'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        if($request->group=='IM'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNID']=$value['INSCRMUNID'];
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNNR']=$value['INSCRMUNNR'];
                $tempValidacao[$value['INSCRMUNID']]['Nome']=$value['Nome'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        $collection = collect($Validacao);

        return Datatables::of($collection)->addColumn('action', function ($var) {
            return '
                <a onclick="abreNovoCanal('.$var['PessoaId'].','.$var['PsCanalId'].')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i>  </a>
                <a onclick="abreEditaCanal('.$var['PessoaId'].','.$var['PsCanalId'].')"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>  </a>
                ';
        })->addColumn('action2', function ($var) {
            $sel='<select id="PsTratRetId'.$var['PsCanalId'].'" name="PsTratRetId[]" class="PsTratRetId">
                    <option value=""> </option>';
            $Trat=TratRet::where('CanalId',$var['CanalId'])->orderBy('RetornoCd')->get();
            foreach($Trat as $value){
                $sel.='<option value="'.$var['PsCanalId'].'_'.$value->EventoId.'">'.$value->RetornoCd.'</option>';
            }
            $sel.='</select>';
            return $sel;
        })->addColumn('action3', function ($var) {
            $sel='<select id="AcCanal'.$var['PsCanalId'].'" name="AcCanal[]" class="AcCanal">
                    <option value=""> </option>';
            $AcCanal=RegTab::where('TABSYSID',47)->get();
            foreach($AcCanal as $value){
                $sel.='<option value="'.$var['PsCanalId'].'_'.$value->REGTABID.'">'.$value->REGTABNM.'</option>';
            }
            $sel.='</select>';
            return $sel;
        })->rawColumns(['action', 'action2', 'action3'])->make(true);
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
            'cda_modcom.ModComSg as Modelo',
            DB::raw("sum(cda_parcela.TotalVr)  as TotalVr2"),
            DB::raw("if(cda_pessoa.PESSOANMRS IS NULL,'Não Informado',cda_pessoa.PESSOANMRS) as Nome"),
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as  TribT', 'TribT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->join('cda_modcom', 'cda_roteiro.ModComId', '=', 'cda_modcom.ModComId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->join('cda_execfila_pscanal_parcela', 'cda_execfila_pscanal_parcela.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
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
            $collect[$i]['Modelo']=$parcela['Modelo'];
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

    function getDadosDataTableValidarAll(Request $request){

        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }


        /***********************************************/


        $where=self::filtroParcela($request, $FxAtraso, $FxValor, $arrayFxValor, $arrayFxAtraso);

        if(empty($where)){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }
        $Parcelas = Parcela::select([
            'cda_parcela.PessoaId'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as  TribT', 'TribT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->leftjoin('cda_modcom', 'cda_roteiro.ModComId', '=', 'cda_modcom.ModComId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
            ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy('cda_parcela.PessoaId')
            ->orderBy('cda_parcela.PessoaId')
            ->get();
        foreach ($Parcelas as $par){
            $pessoa[]=$par->PessoaId;
        }
        $where=1;
        if($pessoa){
            $where.=" AND cda_pscanal.PessoaId in (".implode(',',$pessoa).")";
        }
        if($request->Canal){
            $where.=" AND cda_pscanal.CanalId = '$request->Canal'";
        }
        if($request->ContribuinteResId){
            $where.=' AND cda_pessoa.PessoaId IN ('.implode(',',$request->ContribuinteResId).')';
        }
        if($request->ContribuinteResIMId && ($request->group!='IM')){
            $where.=' AND cda_pscanal.InscrMunId IN ('.implode(',',$request->ContribuinteResIMId).')';
        }
        $Validacao=[];
        $x=0;
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
            'cda_inscrmun.INSCRMUNID',
            'cda_inscrmun.INSCRMUNNR',
            'cda_pessoa.PESSOANMRS as Nome',
            'cda_pessoa.CPF_CNPJNR as Documento',
            DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
            DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
            DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade'),
            DB::raw('IF(cda_cidade.cida_uf IS NOT NULL , cda_cidade.cida_uf,cda_pscanal.UF) AS UF')
        ])
            ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
            ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
            ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
            ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
            ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
            ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
            ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_pscanal.PessoaId')
            ->where('cda_pscanal.Ativo',1)
            ->whereRaw($where)
            ->limit(100)
            ->groupBy('cda_pscanal.PsCanalId')
            ->get()->toArray();

        //error_log(print_r($pscanais,1));

        foreach ($pscanais as $dado){
            $where=' 1 ';
            if($request->ValEnvId){
                $where='   cda_valenv.ValEnvId IN ('.implode(',',$request->ValEnvId).')';
            }
            $dado=array_change_key_case($dado,CASE_LOWER);
            $ValEnv= ValEnv::join('cda_evento','cda_evento.EventoId','=','cda_valenv.EventoId')
                ->join('cda_regtab','cda_regtab.REGTABID','=','cda_valenv.ValEnvId')
                ->where('cda_valenv.CanalId',$dado['canalid'])
                ->whereRaw($where)
                ->get();


            foreach ($ValEnv as $val){
                $sql=$val->REGTABSQL;
                $sql=explode("*",$sql);
                list($campo, $sinal, $valor) = $sql;
                //error_log(print_r($dado,1));
                if(strtolower($valor)=='null'){
                    if(empty($dado[strtolower($campo)])){
                        $Dados=$dado['logradouro'].' '.$dado['endereconr'].' '.$dado['bairro'].' '.$dado['cidade'].' '.$dado['uf'].' '.$dado['cep'].' '.$dado['email'].' '.$dado['telefonenr'];
                        $Validacao[$x]['PessoaId']=$dado['pessoaid'];
                        $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
                        $Validacao[$x]['EventoId']=$val->EventoId;
                        $Validacao[$x]['TransfCtrId']=$val->TransfCtrId;
                        $Validacao[$x]['TransfFilaTrabId']=$val->FilaTrabId;
                        $Validacao[$x]['FilaTrabId']=11;
                        $Validacao[$x]['Nome']=$dado['nome'];
                        $Validacao[$x]['Documento']=$dado['documento'];
                        $Validacao[$x]['INSCRMUNID']=$dado['inscrmunid'];
                        $Validacao[$x]['INSCRMUNNR']=$dado['inscrmunnr'];
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
                        $Validacao[$x]['PessoaId']=$dado['pessoaid'];
                        $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
                        $Validacao[$x]['EventoId']=$val->EventoId;
                        $Validacao[$x]['FilaTrabId']=11;
                        $Validacao[$x]['Nome']=$dado['nome'];
                        $Validacao[$x]['Documento']=$dado['documento'];
                        $Validacao[$x]['INSCRMUNID']=$dado['inscrmunid'];
                        $Validacao[$x]['INSCRMUNNR']=$dado['inscrmunnr'];
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
        if($request->group=='Pes'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['PessoaId']]['PessoaId']=$value['PessoaId'];
                $tempValidacao[$value['PessoaId']]['Nome']=$value['Nome'];
                $tempValidacao[$value['PessoaId']]['CPFCNPJ']=$value['Documento'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        if($request->group=='IM'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNID']=$value['INSCRMUNID'];
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNNR']=$value['INSCRMUNNR'];
                $tempValidacao[$value['INSCRMUNID']]['Nome']=$value['Nome'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        $collection = collect($Validacao);
        return Datatables::of($collection)->addColumn('action', function ($var) {
            return '
                <a onclick="abreNovoCanal('.$var['PessoaId'].','.$var['PsCanalId'].')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i>  </a>
                <a onclick="abreEditaCanal('.$var['PessoaId'].','.$var['PsCanalId'].')"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>  </a>
                ';
        })->addColumn('action2', function ($var) {
            $sel='<select id="PsTratRetId'.$var['PsCanalId'].'" name="PsTratRetId[]" class="PsTratRetId">
                    <option value=""> </option>';
            $Trat=TratRet::where('CanalId',$var['CanalId'])->orderBy('RetornoCd')->get();
            foreach($Trat as $value){
                $sel.='<option value="'.$var['PsCanalId'].'_'.$value->EventoId.'">'.$value->RetornoCd.'</option>';
            }
            $sel.='</select>';
            return $sel;
        })->addColumn('action3', function ($var) {
            $sel='<select id="AcCanal'.$var['PsCanalId'].'" name="AcCanal[]" class="AcCanal">
                    <option value=""> </option>';
            $AcCanal=RegTab::where('TABSYSID',47)->get();
            foreach($AcCanal as $value){
                $sel.='<option value="'.$var['PsCanalId'].'_'.$value->REGTABID.'">'.$value->REGTABNM.'</option>';
            }
            $sel.='</select>';
            return $sel;
        })->rawColumns(['action', 'action2', 'action3'])->make(true);
    }

    ########################
    /**********************/
    public function teste()
    {
        //dd('oi');
        $TarefaId=1;
        $parcelas='9,10,11,12,13,14';
        $Gravar=false;
        $Fila=4;

        $filas=[];
        $Tarefa= Tarefas::findOrFail($TarefaId);
        $Tarefa->update([
            "tar_inicio"    => date("Y-m-d H:i:s")
        ]);

        $dir="filas/tarefa".$TarefaId;
        if(!Storage::exists($dir)) {
            Storage::makeDirectory($dir);
        }
        if($Gravar) {
            $ExecFila = ExecFila::create([
                'exfi_fila' => $Fila,
                'exfi_tarefa' => $TarefaId,
            ]);

            $Lote = $ExecFila->exfi_lote;
        }
        $sql="Select
              cda_parcela.PARCELAID,
              cda_parcela.PESSOAID,
              cda_parcela.SITPAGID,
              cda_parcela.SITCOBID,
              cda_parcela.INSCRMUNID as IM,
              cda_parcela.ORIGTRIBID,
              cda_parcela.LancamentoDt,
              cda_parcela.VencimentoDt,
              cda_parcela.PlanoQt,
              cda_parcela.ParcelaNr,
              cda_parcela.TRIBUTOID,
              cda_parcela.PrincipalVr,
              cda_parcela.JurosVr,
              cda_parcela.MultaVr,
              cda_parcela.DescontoVr,
              cda_parcela.Honorarios,
              cda_parcela.TotalVr,
              TRIB.REGTABSG as TRIBUTONM,
              cda_pcrot.SaidaDt,
              cda_roteiro.RoteiroId  as idRoteiro,
              cda_roteiro.CarteiraId,
              cda_roteiro.FaseCartId,
              cda_roteiro.EventoId,
              cda_roteiro.ModComId,
              cda_roteiro.FilaTrabId,
              cda_roteiro.CanalId,
              cda_pessoa.*,
              cda_carteira.*,
              cda_inscrmun.*
            From
              cda_parcela
              INNER Join
              cda_pcrot On cda_parcela.PARCELAID = cda_pcrot.ParcelaId
              INNER Join
              cda_roteiro On cda_pcrot.RoteiroId = cda_roteiro.RoteiroId
              INNER Join
              cda_carteira On cda_roteiro.CarteiraId = cda_carteira.CARTEIRAID
              INNER Join
              cda_pessoa On cda_pessoa.PESSOAID = cda_parcela.PessoaId 
              LEFT Join
              cda_inscrmun On cda_parcela.INSCRMUNID = cda_inscrmun.INSCRMUNID   
              LEFT Join
              cda_regtab TRIB On cda_parcela.TRIBUTOID = TRIB.REGTABID  
       
            Where
               cda_parcela.PARCELAID in (".$parcelas.") and FilaTrabId=$Fila and SaidaDt is Null and ModComId > 0";


        //Log::info($sql." GROUP BY cda_parcela.ParcelaId");
        $parcelas= DB::select($sql." GROUP BY cda_parcela.ParcelaId");
        $arrPsCanal=[];
        foreach ($parcelas as $linha){
            $campoPrincipal=$linha->IM;
            $tppos=PrRotCanal::where('CarteiraId',$linha->CarteiraId)
                ->where('RoteiroId',$linha->idRoteiro)
                ->orderBy('PrioridadeNr')->get();
            $pscanal=null;

            if(count($tppos)>0){
                foreach ($tppos as $tp) {
                    $pscanal = PsCanal::where("InscrMunId", $campoPrincipal)
                        ->where('TipPosId', $tp->TpPosId)
                        ->where('Ativo', 1)
                        ->first();
                    if ($pscanal->PsCanalId) {
                        break;
                    }
                }
            }else{
                $pscanal = PsCanal::where("InscrMunId", $campoPrincipal)
                    ->where('Ativo', 1)
                    ->first();
            }

            if(!isset($pscanal->PsCanalId)) continue;

            if($this->Gravar){
                $sql="INSERT INTO cda_pcevento SET ";
                $sql.="PESSOAID='".$linha->PESSOAID."',";
                $sql.="INSCRMUNID='".$linha->INSCRMUNID."',";
                $sql.="PARCELAID='".$linha->PARCELAID."',";
                $sql.="EVENTOID='".$linha->EventoId."',";
                $sql.="EVENTODT='".date('Y-m-d')."',";
                $sql.="CARTEIRAID='".$linha->CarteiraId."',";
                $sql.="FILATRABID='".$linha->FilaTrabId."',";
                $sql.="PSCANALID='".$pscanal->PsCanalId."',";
                $sql.="MODCOMID='".$linha->ModComId."'";
                DB::beginTransaction();
                try {
                    DB::insert($sql);
                    if(!in_array($pscanal->PsCanalId,$arrPsCanal)) {
                        $cafi_evento=65;
                        if($Fila==5){
                            $cafi_evento=67;
                        }
                        CanalFila::create([
                            'cafi_fila' => $linha->FilaTrabId,
                            'cafi_fila_origem' => $linha->FilaTrabId,
                            'cafi_pscanal' => $pscanal->PsCanalId,
                            'cafi_evento' => $cafi_evento,
                            'cafi_entrada' => date("Y-m-d"),
                            'cafi_saida' => date("Y-m-d")
                        ]);
                        $arrPsCanal[]=$pscanal->PsCanalId;
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    DB::rollback();
                }
            }
            if($linha->ModComId>0) {
                $modelo=$linha->ModComId;
                $bairro=$pscanal->Bairro;
                $cidade=$pscanal->Cidade;
                $linha->logradouro= $pscanal->Logradouro.','.$pscanal->EnderecoNr.' '.$pscanal->Complemento.'<br>'.$bairro.'<br>'.$cidade;
                $linha->PsCanalId=$pscanal->PsCanalId;
                $linha->telefone=$pscanal->TelefoneNr;
                $linha->email=$pscanal->Email;
                $filas[$modelo][$linha->IM][] = $linha;
            }
        }
        $html="";
        if($Fila!=5) {
            $html .= "<style>table, th, td {border: 1px solid #D0CECE;} .page-break { page-break-after: always;}   @page { margin:5px; } html {margin:5px;} </style>";
        }
        foreach ($filas as $modelo=> $fila){
            foreach ($fila as $pessoa){
                $idLote=0;
                if($Gravar) {
                    $Notificacao = ExecFilaPsCanal::create([
                        "Lote" => $Lote,
                        "PsCanalId" => $pessoa[0]->PsCanalId,
                    ]);
                    $idLote=$Notificacao->efpa_id;
                }
                $html.=self::geraModelo($pessoa,$modelo,$Notificacao);
                if($Fila!=5) {
                    $html .= "<div class='page-break'></div>";
                }else{
                    $html=strip_tags($html);
                    $this->SMS($pessoa[0]->telefone,$html,$idLote );
                    $html="";
                }
                $email=$pessoa[0]->email;
            }
            if($Fila==4) {
                $this->EMAIL($email,$html);
                $html="";
            }
        }

        if($Fila==3) { //Cartas

            $Variaveis=RegTab::where('TABSYSID',46)->get();
            foreach ($Variaveis as $var){
                $html=str_replace("{{".$var->REGTABSG."}}","",$html);
            }

            $dir = public_path() . "/filas/";
            $file = "carta-" . date('Ymd') . "-" . $TarefaId . ".pdf";
            $html = str_replace("{{BREAK}}", "<div class='page-break'></div>", $html);
            $html = str_replace('pt;', 'px;', $html);
            $html = str_replace('0.0001px;', '0.0001pt;', $html);
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper('b4')->setWarnings(false)->loadHTML($html);
            $pdf->save($dir . $file);
        }

        $Tarefa= Tarefas::findOrFail($TarefaId);
        $Tarefa->update([
            "tar_status"    => "Finalizado",
            "tar_final"    => date("Y-m-d H:i:s"),
            'tar_descricao' =>  $Tarefa->tar_descricao."<a href='".URL::to('/')."/filas/".$file."' target='_blank'>".URL::to('/')."/filas/".$file."</a>"
        ]);

        return false;
    }

    function geraModelo($pessoa,$modeloid,$Notificacao=null){

        $Gravar=false;

        $Modelo= ModCom::find($modeloid);

        $html=$Modelo->ModTexto;

        if($Notificacao) {
            $NotificacaoNR = $Notificacao->Lote . "." . $Notificacao->efpa_id;
            $NotificacaoNR = str_pad($NotificacaoNR, 10, "0", STR_PAD_LEFT);
            $ExecFila = ExecFila::find($Notificacao->Lote);
        }

        $Variaveis=RegTab::where('TABSYSID',46)->get();

        $x=0;
        foreach ($Variaveis as $var){

            $vs=explode("*=",$var->REGTABSQL);
            $key=$vs[0];
            if(!$key) continue;
            $replace[$key][$x]['sg']=$var['REGTABSG'];
            $replace[$key][$x]['campo']=$vs[1]??null;
            $x++;
        }
        $result=[];
        $i=1;
        foreach ($pessoa as $linha) {

            if(isset($linha->PARCELAID) && $Gravar){
                ExecFilaPsCanalParcela::create([
                    "Lote"          =>$Notificacao->Lote,
                    "Notificacao"   =>$Notificacao->efpa_id,
                    "ParcelaId"     =>$linha->PARCELAID
                ]);
            }
            //foreach ($linhas as $linha) {
            //$linha=$linha[0];
            if($Notificacao) {
                $linha->NotificacaoNR = $NotificacaoNR;
                $linha->NotificacaoData = $ExecFila->exfi_data;
            }else{
                $linha->NotificacaoNR = "00000000000";
                $linha->NotificacaoData = date("d/m/Y");
            }
            foreach ($replace as $tipo => $campo) {
                foreach ($campo as  $campos) {
                    $sg = $campos['sg'];
                    $campo = $campos['campo'];
                    switch ($tipo) {
                        case "fixo":
                            $result[$i][$sg] = $campo;
                            break;
                        case "data":
                            if (isset($linha->$campo)) {
                                $valor = Carbon::createFromFormat('Y-m-d', $linha->$campo)->format('d/m/Y');
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "numero":
                            if (isset($linha->$campo)) {
                                $valor = number_format($linha->$campo, 2, ',', '.');
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "texto":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                $result[$i][$sg] = $valor;
                            }
                            break;
                        case "textoFirst":
                            if (isset($linha->$campo)) {
                                $valor = explode(' ',$linha->$campo);
                                $result[$i][$sg] = trim($valor[0]);
                            }
                            break;
                        case "array":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                if (strpos($valor, '-') !== false) {
                                    $valor = Carbon::createFromFormat('Y-m-d', $linha->$campo)->format('d/m/Y');
                                }
                                $result[$i][self::soLetra($sg) . $i] = $valor;
                            }
                            break;
                        case "arrayNumber":
                            if (isset($linha->$campo)) {
                                $valor = $linha->$campo;
                                if(is_numeric($valor))
                                    $valor =number_format($valor, 2, ',', '.');
                                $result[$i][self::soLetra($sg) . $i] = $valor;
                            }
                            break;
                        case "soma":
                            if (isset($linha->$campo)) {
                                if (isset($result[$i - 1][$sg])) {
                                    $valor = $result[$i - 1][$sg] + $linha->$campo;
                                } else {
                                    $valor = $linha->$campo;
                                }

                                $result[$i][$sg] = $valor;
                            }
                            break;
                    }
                }
                // }
            }
            $i++;
        }
        foreach ($result as $campos) {
            foreach ($campos as $key=>$val) {
                $sg = "{{" . $key . "}}";
                $value = $val;
                $html = str_replace($sg,$value, $html);
            }
        }

        return $html;

    }

    private function soLetra($str) {
        return preg_replace("/[^A-Za-z]/", "", $str);
    }

    private function filtroParcela($request,&$FxAtraso,&$FxValor,&$arrayFxValor,&$arrayFxAtraso){
        $where=' `cda_pcrot`.`SaidaDt` IS NULL ';

        $limit=100000;
        if($request->limit!=null){
            $limit=$request->limit;
        }

        if($request->FilaTrabId){
            if ($request->FilaTrabId==11)
                $where.=' AND cda_roteiro.FilaTrabId=3';
            else
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

        if($request->IMRes){
            $where.=' AND cda_parcela.InscrMunId IN ('.implode(',',$request->IMRes).')';
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

        $Pessoas = Parcela::select([

            DB::raw("Distinct cda_parcela.ParcelaId"),
            'cda_parcela.PessoaId'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
            ->join('cda_pscanal',  function($join)
            {
                $join->on('cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId');
                $join->on( 'cda_roteiro.CanalId', '=', 'cda_pscanal.CanalId');
                $join->where('cda_pscanal.Ativo','=', 1);
            })
            ->where('cda_parcela.SitPagId', '61')
            ->whereRaw($where)
            ->groupBy('cda_parcela.PessoaId','cda_parcela.ParcelaId')
            ->limit($limit)
            ->get();
        foreach ($Pessoas as $pess){
            $parc[]=$pess->ParcelaId;
        }

        $grp="cda_parcela.PessoaId";
        if($request->group=='IM'){
            $grp="cda_parcela.InscrMunId";
        }

        if($parc) {
            $where.=" AND cda_parcela.ParcelaId IN (".implode(',',$parc).")";
            $Pessoas = Parcela::select([
                DB::raw("Distinct cda_parcela.ParcelaId"),
                'cda_parcela.PessoaId',
                'cda_parcela.InscrMunId',
                DB::raw("datediff(NOW(), MIN(VencimentoDt))  as MAX_VENC"),
                DB::raw("SUM(TotalVr)  as Total"),
                DB::raw("COUNT(cda_parcela.ParcelaId)  as Qtde"),
            ])
                ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
                ->join('cda_roteiro', 'cda_roteiro.RoteiroId', '=', 'cda_pcrot.RoteiroId')
                ->leftjoin('cda_carteira', 'cda_carteira.CARTEIRAID', '=', 'cda_roteiro.CarteiraId')
                ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
                ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
                ->where('cda_parcela.SitPagId', '61')
                ->whereRaw($where)
                ->groupBy($grp)
                ->get();
        }else{
            return false;
        }

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
                            if($request->group=='IM'){
                                $FxAtraso[$pessoa['InscrMunId']]=$key;
                            }else{
                                $FxAtraso[$pessoa['PessoaId']]=$key;
                            }
                        }
                    }else{
                        if($request->group=='IM'){
                            $FxAtraso[$pessoa['InscrMunId']]=$key;
                        }else{
                            $FxAtraso[$pessoa['PessoaId']]=$key;
                        }
                    }
                }
            }

            foreach ($arrayFxValor as $key=>$value){
                if($pessoa['Total']>$value['Min']){
                    if($value['Max']){
                        if($pessoa['Total']<=$value['Max']){
                            if($request->group=='IM'){
                                $FxValor[$pessoa['InscrMunId']]=$key;
                            }else{
                                $FxValor[$pessoa['PessoaId']]=$key;
                            }
                        }
                    }else{
                        if($request->group=='IM'){
                            $FxValor[$pessoa['InscrMunId']]=$key;
                        }else{
                            $FxValor[$pessoa['PessoaId']]=$key;
                        }
                    }
                }
            }
            if($request->group=='IM'){
                $seqValor[$pessoa['Total']]=$pessoa['InscrMunId'];
            }else{
                $seqValor[$pessoa['Total']]=$pessoa['PessoaId'];
            }

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
            if($request->group=='IM') {
                $where .= ' AND cda_parcela.InscrMunId IN (' . implode(',', array_keys($FxAtraso)) . ')';
            }else{
                $where .= ' AND cda_parcela.PessoaId IN (' . implode(',', array_keys($FxAtraso)) . ')';
            }
        }elseif($request->FxAtrasoId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
        }

        if($FxValor){
            if($request->group=='IM') {
                $where .= ' AND cda_parcela.InscrMunId IN (' . implode(',', array_keys($FxValor)) . ')';
            }else{
                $where .= ' AND cda_parcela.PessoaId IN (' . implode(',', array_keys($FxValor)) . ')';
            }
        }elseif($request->FxValorId){
            $where.=' AND cda_parcela.PessoaId IN (0)';
        }

        if($Nqtde){
            if($request->group=='IM') {
                $where .= ' AND cda_parcela.InscrMunId IN (' .implode(',',$Nqtde).')';
            }else{
                $where .= ' AND cda_parcela.PessoaId IN (' .implode(',',$Nqtde).')';
            }
        }
        return $where;
    }

    public function getDadosDataTableHigiene(Request $request)
    {
        if($request->none){
            $collection = collect([]);
            return Datatables::of($collection)->make(true);
        }

        $where=1;
        if($request->ValEnvId && !$request->TratRetId){
            $where.=' AND  cda_valenv.ValEnvId IN ('.implode(',',$request->ValEnvId).')';
        }
        if($request->TratRetId && !$request->ValEnvId){
            $where.=' AND  cda_tratret.TratRetId IN ('.implode(',',$request->TratRetId).')';
        }
        if($request->TratRetId && $request->ValEnvId){
            $where.=' AND ( cda_valenv.ValEnvId IN ('.implode(',',$request->ValEnvId).')';
            $where.=' or  cda_tratret.TratRetId IN ('.implode(',',$request->TratRetId).'))';
        }
        if($request->Canal){
            $where.=" AND cda_pscanal.CanalId = '$request->Canal'";
        }
        if($request->ContribuinteResId){
            $where.=' AND cda_pessoa.PessoaId IN ('.implode(',',$request->ContribuinteResId).')';
        }
        if($request->ContribuinteResIMId && ($request->group!='IM')){
            $where.=' AND cda_pscanal.InscrMunId IN ('.implode(',',$request->ContribuinteResIMId).')';
        }
        $Validacao=[];
        $x=0;
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
            
            'FonteInfoId.REGTABSG as FonteInfo',
            'TipPosId.REGTABNM as TipPos',
            'cda_canal.CANALSG',
            'cda_inscrmun.INSCRMUNID',
            'cda_inscrmun.INSCRMUNNR',
            'cda_pessoa.PESSOANMRS as Nome',
            'cda_pessoa.CPF_CNPJNR as Documento',
            'cda_evento.*',
            DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
            DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
            DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade'),
            DB::raw('IF(cda_cidade.cida_uf IS NOT NULL , cda_cidade.cida_uf,cda_pscanal.UF) AS UF')
        ])
            ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
            ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
            ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
            ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
            ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
            ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
            ->leftjoin('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_pscanal.PessoaId')
            ->join('cda_canal_fila', 'cda_canal_fila.cafi_pscanal', '=', 'cda_pscanal.PsCanalId')
            ->join('cda_evento','cda_evento.EventoId','=','cda_canal_fila.cafi_evento')
            ->leftjoin('cda_valenv','cda_valenv.EventoId','=','cda_evento.EventoId')
            ->leftjoin('cda_tratret','cda_tratret.EventoId','=','cda_evento.EventoId')
            ->where('cda_canal_fila.cafi_fila',$request->FilaTrabId)
            ->whereNull('cda_canal_fila.cafi_saida')
            ->whereRaw($where)
            ->limit(100)
            ->groupBy('cda_canal_fila.cafi_id')
            ->get()->toArray();

        //error_log(print_r($pscanais,1));

        foreach ($pscanais as $dado){
            $dado=array_change_key_case($dado,CASE_LOWER);
            $Dados=$dado['logradouro'].' '.$dado['endereconr'].' '.$dado['bairro'].' '.$dado['cidade'].' '.$dado['uf'].' '.$dado['cep'].' '.$dado['email'].' '.$dado['telefonenr'];
            $Validacao[$x]['PessoaId']=$dado['pessoaid'];
            $Validacao[$x]['PsCanalId']=$dado['pscanalid'];
            $Validacao[$x]['EventoId']=$dado['eventoid'];
            $Validacao[$x]['Evento']=$dado['eventosg'];
            $Validacao[$x]['FilaTrabId']=2;
            $Validacao[$x]['Nome']=$dado['nome'];
            $Validacao[$x]['Documento']=$dado['documento'];
            $Validacao[$x]['INSCRMUNID']=$dado['inscrmunid'];
            $Validacao[$x]['INSCRMUNNR']=$dado['inscrmunnr'];
            $Validacao[$x]['Canal']=$dado['canalsg'];
            $Validacao[$x]['TipoPos']=$dado['tippos'];
            $Validacao[$x]['Fonte']=$dado['fonteinfo'];
            $Validacao[$x]['Dados']=trim($Dados);
            $x++;
        }
        if($request->group=='Pes'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['PessoaId']]['PessoaId']=$value['PessoaId'];
                $tempValidacao[$value['PessoaId']]['Nome']=$value['Nome'];
                $tempValidacao[$value['PessoaId']]['CPFCNPJ']=$value['Documento'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        if($request->group=='IM'){
            $tempValidacao=[];
            foreach ($Validacao as $key => $value){
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNID']=$value['INSCRMUNID'];
                $tempValidacao[$value['INSCRMUNID']]['INSCRMUNNR']=$value['INSCRMUNNR'];
                $tempValidacao[$value['INSCRMUNID']]['Nome']=$value['Nome'];
            }
            ksort($tempValidacao);
            $Validacao=$tempValidacao;
        }
        $collection = collect($Validacao);

            return Datatables::of($collection)->addColumn('action', function ($var) {
                return '
                <a onclick="abreNovoCanal('.$var['PessoaId'].','.$var['PsCanalId'].')" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i>  </a>
                <a onclick="abreEditaCanal('.$var['PessoaId'].','.$var['PsCanalId'].')"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>  </a>
                ';
            })->addColumn('action2', function ($var) {
                $sel='<select id="PsTratRetId'.$var['PsCanalId'].'" name="PsTratRetId[]" class="PsTratRetId">
                    <option value=""> </option>';
                $Trat=TratRet::where('CanalId',$var['CanalId'])->orderBy('RetornoCd')->get();
                foreach($Trat as $value){
                    $sel.='<option value="'.$var['PsCanalId'].'_'.$value->EventoId.'">'.$value->RetornoCd.'</option>';
                }
                $sel.='</select>';
                return $sel;
            })->addColumn('action3', function ($var) {
                $sel='<select id="AcCanal'.$var['PsCanalId'].'" name="AcCanal[]" class="AcCanal">
                    <option value=""> </option>';
                $AcCanal=RegTab::where('TABSYSID',47)->get();
                foreach($AcCanal as $value){
                    $sel.='<option value="'.$var['PsCanalId'].'_'.$value->REGTABID.'">'.$value->REGTABNM.'</option>';
                }
                $sel.='</select>';
                return $sel;
            })->rawColumns(['action', 'action2', 'action3'])->make(true);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tratar(Request $request)
    {
        $dados=(json_decode($request->dados, true));
        $tarefa=Tarefas::create([
            'tar_categoria' => 'execTratamento',
            'tar_titulo' => 'Execução de Fila – Tratamento Retorno',
            'tar_user' => auth()->id(),
            'tar_inicio' => date("Y-m-d H:i:s"),
            'tar_final' => date("Y-m-d H:i:s"),
            'tar_status' => 'Finalizado'
        ]);
        if(filter_var($request->csv, FILTER_VALIDATE_BOOLEAN)){
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
        if(filter_var($request->txt, FILTER_VALIDATE_BOOLEAN)){
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
            $arr=null;
            parse_str($request->PsTratRetId,$arr);
            foreach ($arr['PsTratRetId'] as $val){
                $vals=explode("_",$val);
                if(!empty($vals[1])) {
                    $filaEv = Evento::find($vals[1]);
                    CanalFila::create([
                        'cafi_fila' => $filaEv->FilaTrabId,
                        'cafi_fila_origem' => 12,
                        'cafi_pscanal' => $vals[0],
                        'cafi_evento' => $vals[1],
                        'cafi_entrada' => Carbon::now()->format('Y-m-d')
                    ]);
                    PsCanal::find($vals[0])->update(['Ativo'=>0]);
                }
            }
        }
        return \response()->json(true);
    }

    public function analisar(Request $request){
        $dados=(json_decode($request->dados, true));
        $tarefa=Tarefas::create([
            'tar_categoria' => 'execTratamento',
            'tar_titulo' => 'Execução de Fila – Analise',
            'tar_user' => auth()->id(),
            'tar_inicio' => date("Y-m-d H:i:s"),
            'tar_final' => date("Y-m-d H:i:s"),
            'tar_status' => 'Finalizado'
        ]);
        if(filter_var($request->csv, FILTER_VALIDATE_BOOLEAN)){
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
        if(filter_var($request->txt, FILTER_VALIDATE_BOOLEAN)){
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
            $arr=null;
            parse_str($request->AcCanal,$arr);
            foreach ($arr['AcCanal'] as $val){
                $vals=explode("_",$val);
                if(!empty($vals[1])) {
                    $RegTab = RegTab::find($vals[1]);
                    $sqlEvent=eval($RegTab->REGTABSQL);
                    CanalFila::where('cafi_fila',14)->where('cafi_pscanal',$vals[0])->update(['cafi_saida'=>Carbon::now()->format('Y-m-d')]);
                    PsCanal::find($vals[0])->update($sqlEvent);
                }
            }
        }
        return \response()->json(true);
    }
    private function SMS($numero,$msg,$lote){
        $msg=html_entity_decode($msg);
        $url="http://54.233.99.254/webservice-rest/send-single?user=marcoaoc83&password=300572&country_code=55&number=6796119286&content=$msg&campaign_id=$lote&type=5";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return true;
    }

    private function EMAIL($email,$msg){
        $cda_portal = PortalAdm::get();
        $cda_portal=$cda_portal[0];

        Mail::to($email)->send(new \App\Mail\SendMailFilas($cda_portal->port_titulo,$msg));
        return true;
    }
}
