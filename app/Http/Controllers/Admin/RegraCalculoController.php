<?php

namespace App\Http\Controllers\Admin;

use App\Models\Parcela;
use App\Models\RegraCalculo;
use App\Models\RegraTributo;
use App\Models\RegTab;
use App\Models\TabelasSistema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegraCalculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_regcalc = DB::table('cda_regcalc')->get();
        return view('admin.regra.index',compact('cda_regcalc'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $TpRegCalc = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpRegCalc')
            ->get();
        ;
        $IndReaj = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','IndReaj')
            ->get();
        ;
        $TpJuro = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpJuro')
            ->get();
        ;
        $bank = RegTab::where('TABSYSID', 44)->get();
        $ModCom = DB::table('cda_modcom')->get();
        // show the view and pass the nerd to it
        return view('admin.regra.create',[
            'TpRegCalc'=>$TpRegCalc,
            'IndReaj'=>$IndReaj,
            'TpJuro'=>$TpJuro,
            'ModCom'=>$ModCom,
            'banco' => $bank
        ]);
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

        RegraCalculo::create($data);

        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);

        return redirect()->route('regcalc.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegraCalculo  $regcalc
     * @return \Illuminate\Http\Response
     */
    public function show(RegraCalculo $regcalc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegraCalculo  $regcalc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd
        $regcalc = RegraCalculo::find($id);

        $TpRegCalc = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpRegCalc')
            ->get();
        ;
        $IndReaj = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','IndReaj')
            ->get();
        ;
        $TpJuro = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','TpJuro')
            ->get();
        ;
        $OpReg = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','OpReg')
            ->get();
        ;

        $bank = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','Banco')
            ->get();
        $ModCom = DB::table('cda_modcom')->get();
        $Tributo = DB::table('cda_regtab')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_regtab.TABSYSID')
            ->where('TABSYSSG','Tributo')
            ->get();
        // show the view and pass the nerd to it
        return view('admin.regra.edit',[
            'RegraCalculo'=>$regcalc,
            'banco'=>$bank,
            'TpRegCalc'=>$TpRegCalc,
            'IndReaj'=>$IndReaj,
            'OpReg'=>$OpReg,
            'ModCom'=>$ModCom,
            'Tributo'=>$Tributo,
            'TpJuro'=>$TpJuro
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegraCalculo  $regcalc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $regcalc = RegraCalculo::findOrFail($id);
        $regcalc->update($request->except(['_token']));

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('regcalc.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegraCalculo  $regcalc
     * @return \Illuminate\Http\Response
     */
    public function destroy($regcalc)
    {
        $var = RegraCalculo::find($regcalc);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $cda_regcalc = RegraCalculo::select(['RegCalcId','RegCalcSg', 'RegCalcNome']);

        return Datatables::of($cda_regcalc)
            ->addColumn('action', function ($regcalc) {

                return '
                <a href="regcalc/'.$regcalc->RegCalcId.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteRegraCalculo('.$regcalc->RegCalcId.')" class="btn btn-xs btn-danger deleteRegraCalculo" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function gerarRegra(){

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

            $parcelas= Parcela::where('SitPagId',61)->whereIn('TributoId',$tipos_tributos);
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
                Parcela::find($parcela->ParcelaId)->update([
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
