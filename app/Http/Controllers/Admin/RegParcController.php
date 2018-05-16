<?php

namespace App\Http\Controllers\Admin;

use App\Models\RegParc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RegParcController extends Controller
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

        if (RegParc::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegParc  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function show(RegParc $psCanal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegParc  $psCanal
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
     * @param  \App\Models\RegParc  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ExecRot = RegParc::findOrFail($id);
        if($ExecRot->update($request->all()))
            return \response()->json(true);
        return \response()->json(false);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegParc  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = RegParc::findOrFail($request->RegParcId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_regparc = RegParc::select(['cda_regparc.*','cda_regtab.REGTABID','cda_regtab.REGTABNM'])
            ->leftjoin('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_regparc.OpRegId')
            ->where('cda_regparc.RegCalcId',$request->RegCalcId)
            ->get();

        return Datatables::of($cda_regparc)->make(true);
    }
}
