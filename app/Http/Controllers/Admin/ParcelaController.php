<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parcela;
use App\Models\RegraCalculo;
use App\Models\RegraTributo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ParcelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        $data = $request->all();
        $id=Parcela::create($data);
        if ($id){
            self::gerarRegra($id->ParcelaId);
            return \response()->json(true);
        }

        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Parcela  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function show(Parcela $psCanal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Parcela  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Parcela  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ExecRot = Parcela::findOrFail($id);
        if($ExecRot->update($request->all()))
            return \response()->json(true);
        return \response()->json(false);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Parcela  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = Parcela::findOrFail($request->ParcelaId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_parcela = Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            'SitPagT.REGTABSG as  SitPag',
            'SitCobT.REGTABSG as  SitCob',
            'OrigTribT.REGTABSG as  OrigTrib',
            'TributoT.REGTABSG as  Tributo',
            ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->where('cda_parcela.PessoaId',$request->PESSOAID);
        if($request->INSCRMUNID)
            $cda_parcela->where('cda_parcela.INSCRMUNID',$request->INSCRMUNID);
        $cda_parcela->get();

        return Datatables::of($cda_parcela)->make(true);
    }

    private function gerarRegra($id){

        $regras=RegraCalculo::where('TpRegCalcId',167)
            ->where('InicioDt','<=',date('Y-m-d'))
            ->where('TerminoDt','>=',date('Y-m-d'))
            ->orderBy('InicioDt')
        ;
        foreach ($regras->cursor() as $regra){

            $tributos=RegraTributo::where('RegCalcId',$regra->RegCalcId);
            $tipos_tributos=[];
            foreach($tributos->cursor() as $tributo){
                $tipos_tributos[]=$tributo->TributoId;
            }
            if(empty($tipos_tributos)) continue;

            $parcelas= Parcela::where('SitPagId',61)->whereIn('TributoId',$tipos_tributos)->where('ParcelaId',$id);
            foreach($parcelas->cursor() as $parcela){
                $valor=$parcela->PrincipalVr;
                $valorJuros=0;
                $valorMulta=($valor*($regra->MultaTx/100));
                $valorDesconto=($valor*($regra->DescontoTx/100));
                $valorHonorarios=($valor*($regra->HonorarioTx/100));
                if($regra->TpJuroId==169){//Se for Juros Simples
                    $meses=Carbon::parse($parcela->VencimentoDt->format('Y-m-d'))->DiffInMonths(date('Y-m-d'));
                    if($meses==0) continue;
                    for($x=1;$x<=$meses;$x++){
                        $valorJuros=$valorJuros+($valor*($regra->JuroTx/100));
                    }
                }else{//Se for Juros Compostos
                    $meses=Carbon::parse($parcela->VencimentoDt)->DiffInMonths(date('Y-m-d'));

                    for($x=1;$x<=$meses;$x++){
                        $valorJuros=$valorJuros+(($valor+$valorJuros)*($regra->JuroTx/100));
                    }
                }
                $valor=$valor+$valorJuros+$valorHonorarios+$valorMulta-$valorDesconto;
                Parcela::find($id)->update([
                    'MultaVr'=>$valorMulta,
                    'JurosVr'=>$valorJuros,
                    'DescontoVr'=>$valorDesconto,
                    //'AcrescimoVr'=>$valorJuros+$valorHonorarios+$valorMulta-$valorDesconto,
                    'Honorarios'=>$valorHonorarios,
                    'TotalVr'=>$valor
                ]);
            }
        }

    }
}
