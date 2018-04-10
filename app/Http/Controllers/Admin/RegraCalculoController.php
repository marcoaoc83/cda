<?php

namespace App\Http\Controllers\Admin;

use App\Models\RegraCalculo;
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
        $ModCom = DB::table('cda_modcom')->get();
        // show the view and pass the nerd to it
        return view('admin.regra.create',[
            'ModCom'=>$ModCom,
            'TpRegCalc'=>$TpRegCalc,
            'IndReaj'=>$IndReaj,
            'TpJuro'=>$TpJuro
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
        $ModCom = DB::table('cda_modcom')->get();
        // show the view and pass the nerd to it
        return view('admin.regra.edit',[
            'RegraCalculo'=>$regcalc,
            'ModCom'=>$ModCom,
            'TpRegCalc'=>$TpRegCalc,
            'IndReaj'=>$IndReaj,
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
}
