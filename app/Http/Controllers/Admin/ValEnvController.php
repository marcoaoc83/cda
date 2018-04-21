<?php

namespace App\Http\Controllers\Admin;

use App\Models\ValEnv;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ValEnvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_valenv = DB::table('cda_valenv')->get();

        return view('admin.canal.valenv.index',compact('cda_valenv'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

        if (ValEnv::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ValEnv  $valEnv
     * @return \Illuminate\Http\Response
     */
    public function show(ValEnv $valEnv)
    {
        //
    }

    public function edit(Request $request)
    {
        return($request);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ValEnv  $valEnv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ValEnv = ValEnv::findOrFail($id);
        $ValEnv->ValEnvId       = $request->ValEnvId;
        $ValEnv->EventoId       = $request->EventoId;
        if($ValEnv->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ValEnv  $valEnv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $model = ValEnv::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $valenv = ValEnv::select(['cda_valenv.id','REGTABSG', 'REGTABNM', 'EventoSg','cda_valenv.EventoId','cda_valenv.ValEnvId'])
            ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_valenv.CanalId')
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_valenv.ValEnvId')
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_valenv.EventoId')
            ->where('cda_valenv.CanalId',$request->CANALID)
            ->get();
        ;

        return Datatables::of($valenv)->make(true);
    }

}
