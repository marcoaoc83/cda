<?php

namespace App\Http\Controllers\Admin;

use App\Models\InscrMun;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InscrMunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_inscrmun = DB::table('cda_inscrmun')->get();

        return view('admin.pessoa.inscrmun.index',compact('cda_inscrmun'));
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

        if (InscrMun::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InscrMun  $inscrmun
     * @return \Illuminate\Http\Response
     */
    public function show(InscrMun $inscrmun)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InscrMun  $inscrmun
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
     * @param  \App\Models\InscrMun  $inscrmun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $InscrMun = InscrMun::findOrFail($id);
        $InscrMun->INSCRMUNNR       = $request->INSCRMUNNR;
        $InscrMun->ORIGTRIBID       = $request->ORIGTRIBID;
        $InscrMun->INICIODT       = $request->INICIODT;
        $InscrMun->TERMINODT       = $request->TERMINODT;
        $InscrMun->SITUACAO       = $request->SITUACAO;
        if($InscrMun->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InscrMun  $inscrmun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = InscrMun::findOrFail($request->INSCRMUNID);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable(Request $request)
    {
        $inscrmun = InscrMun::select(['cda_inscrmun.*','REGTABSG', 'REGTABNM', ])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_inscrmun.ORIGTRIBID')
            ->where('cda_inscrmun.PESSOAID',$request->PESSOAID)
            ->get();
        ;

        return Datatables::of($inscrmun)->make(true);
    }
}
