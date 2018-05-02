<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExecRot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ExecRotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_execrot = DB::table('cda_execrot')->get();

        return view('admin.carteira.execrot.index',compact('cda_execrot'));
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
        if  ($request->AtivoSN) {
            $request->AtivoSN      =1;
        }else{
            $request->AtivoSN      =0;
        }
        $data = $request->all();

        if (ExecRot::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExecRot  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function show(ExecRot $horaExec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExecRot  $horaExec
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
     * @param  \App\Models\ExecRot  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if  ($request->AtivoSN) {
            $request->AtivoSN      =1;
        }else{
            $request->AtivoSN      =0;
        }
        $ExecRot = ExecRot::findOrFail($id);
        $ExecRot->ExecRotId       = $request->ExecRotId;
        $ExecRot->AtivoSN       = $request->AtivoSN;
        if($ExecRot->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExecRot  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = ExecRot::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {

        $execrot = ExecRot::select(['cda_execrot.*','REGTABSG','REGTABNM'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_execrot.ExecRotId')
            ->where('cda_execrot.RoteiroId',$request->RoteiroId)
            ->get();
        ;

        return Datatables::of($execrot)->make(true);
    }
}
