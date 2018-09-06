<?php

namespace App\Http\Controllers\Admin;

use App\Models\HoraExec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class HoraExecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_horexec = DB::table('cda_horexec')->get();

        return view('admin.fila.horaexec.index',compact('cda_horexec'));
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

        if (HoraExec::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HoraExec  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function show(HoraExec $horaExec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HoraExec  $horaExec
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
     * @param  \App\Models\HoraExec  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $HoraExec = HoraExec::findOrFail($id);
        $HoraExec->DiaSemId       = $request->DiaSemId;
        $HoraExec->HInicial       = $request->HInicial;
        $HoraExec->HFinal       = $request->HFinal;
        if($HoraExec->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HoraExec  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = HoraExec::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }



    public function getDadosDataTable(Request $request)
    {
        $horexec = HoraExec::select(['cda_horexec.id','REGTABSG', 'REGTABNM', 'cda_horexec.DiaSemId','cda_horexec.HInicial', 'cda_horexec.HFinal'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_horexec.DiaSemId')
            ->where('cda_horexec.FilaTrabId',$request->FilaTrabId)
            ->get();
        ;

        return Datatables::of($horexec)->make(true);
    }
}
