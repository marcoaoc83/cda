<?php

namespace App\Http\Controllers\Admin;

use App\Models\PrRotCanal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PrRotCanalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_prrotcanal = DB::table('cda_prrotcanal')->get();

        return view('admin.carteira.prrotcanal.index',compact('cda_prrotcanal'));
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

        if (PrRotCanal::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrRotCanal  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function show(PrRotCanal $horaExec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrRotCanal  $horaExec
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
     * @param  \App\Models\PrRotCanal  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $PrRotCanal = PrRotCanal::findOrFail($id);
        $PrRotCanal->PrioridadeNr       = $request->PrioridadeNr;
        $PrRotCanal->TpPosId       = $request->TpPosId;
        if($PrRotCanal->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrRotCanal  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = PrRotCanal::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {

        $prrotcanal = PrRotCanal::select(['cda_prrotcanal.*','REGTABSG','REGTABNM'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_prrotcanal.TpPosId')
            ->where('cda_prrotcanal.RoteiroId',$request->RoteiroId)
            ->get();

        return Datatables::of($prrotcanal)->make(true);
    }
}
