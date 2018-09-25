<?php

namespace App\Http\Controllers\Admin;

use App\Models\RegraTributo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RegraTributoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        if (RegraTributo::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegraTributo  $regraTributo
     * @return \Illuminate\Http\Response
     */
    public function show(RegraTributo $regraTributo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegraTributo  $regraTributo
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
     * @param  \App\Models\RegraTributo  $regraTributo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ExecRot = RegraTributo::findOrFail($id);
        if($ExecRot->update($request->all()))
            return \response()->json(true);
        return \response()->json(false);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegraTributo  $regraTributo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = RegraTributo::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable(Request $request)
    {
        $cda_RegraTributo = RegraTributo::select(['cda_regra_tributo.*','cda_regtab.REGTABID','cda_regtab.REGTABNM'])
            ->leftjoin('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_regra_tributo.TributoId')
            ->where('cda_regra_tributo.RegCalcId',$request->RegCalcId)
            ->get();

        return Datatables::of($cda_RegraTributo)->make(true);
    }
}
