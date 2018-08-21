<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ExecFilaJob;
use App\Models\ExecFila;
use App\Models\Fila;
use App\Models\Parcela;
use App\Models\Tarefas;
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
        parse_str($request->dados, $dados);

        $fila = Fila::find($dados['FilaTrabId']);
        $tarefa=Tarefas::create([
            'tar_categoria' => 'execfila',
            'tar_titulo' => 'Execução de '.$fila->FilaTrabNm,
            'tar_status' => 'Aguardando'
        ]);

        ExecFilaJob::dispatch($dados,$tarefa->tar_id)->onQueue("execfila");
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


        $Parcela = Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
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

        error_log( Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
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
            ->limit($limit)->toSql());

        return Datatables::of($Parcela)->make(true);

    }
}
