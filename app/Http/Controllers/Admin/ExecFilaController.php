<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExecFila;
use App\Models\Parcela;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $sql="Select
              cda_parcela.PARCELAID,
              cda_parcela.PESSOAID,
              cda_parcela.SITPAGID,
              cda_parcela.SITCOBID,
              cda_parcela.INSCRMUNID,
              cda_parcela.ORIGTRIBID,
              cda_parcela.TRIBUTOID,
              cda_pcrot.SaidaDt,
              cda_roteiro.RoteiroId,
              cda_roteiro.CarteiraId,
              cda_roteiro.FaseCartId,
              cda_roteiro.EventoId,
              cda_roteiro.ModComId,
              cda_roteiro.FilaTrabId,
              cda_roteiro.CanalId
            From
              cda_parcela
              INNER Join
              cda_pcrot On cda_parcela.PARCELAID = cda_pcrot.ParcelaId
              INNER Join
              cda_roteiro On cda_pcrot.RoteiroId = cda_roteiro.RoteiroId
            Where
              (cda_parcela.PARCELAID In (".implode(',',$request->parcelasId).")) And
              (cda_pcrot.SaidaDt Is Null)";


        $parcelas= DB::select($sql);

        $event=false;
        foreach ($parcelas as $linha){

            $sql="INSERT INTO cda_pcevento SET ";
            $sql.="PESSOAID='".$linha->PESSOAID."',";
            $sql.="INSCRMUNID='".$linha->INSCRMUNID."',";
            $sql.="PARCELAID='".$linha->PARCELAID."',";
            $sql.="EVENTOID='".$linha->EventoId."',";
            $sql.="EVENTODT='".date('Y-m-d')."',";
            $sql.="CARTEIRAID='".$linha->CarteiraId."',";
            $sql.="FILATRABID='".$linha->FilaTrabId."',";
            $sql.="PSCANALID='".$linha->CanalId."',";
            $sql.="MODCOMID='".$linha->ModComId."'";

            $event=DB::insert($sql);
        }
        if($event){
            SWAL::message('Salvo','Execução gravada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        }else{
            SWAL::message('Erro','Falha na gravação, nenhuma parcela foi salva!','error',['timer'=>4000,'showConfirmButton'=>false]);
        }
        // redirect
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

    public function getDadosDataTableParcela()
    {
        ini_set('memory_limit', '-1');
        $Parcela = Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            'SitPagT.REGTABNM as  SitPag',
            'SitCobT.REGTABNM as  SitCob',
            'OrigTribT.REGTABNM as  OrigTrib',
            'TributoT.REGTABNM as  Tributo',
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pcrot', 'cda_pcrot.ParcelaId', '=', 'cda_parcela.ParcelaId')
            ->where('cda_parcela.SitPagId', '61')
            ->groupBy('cda_parcela.ParcelaId')
            ->limit(100)
            ->get();
        return Datatables::of($Parcela)->make(true);

    }
}
