<?php

namespace App\Http\Controllers\Admin;

use App\Models\CanalEvento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CanalEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_canal_eventos =CanalEvento::get();

        return view('admin.canal.eventos.index',compact('cda_canal_eventos'));
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

        if (CanalEvento::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CanalEvento  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = $request->all();

        if (CanalEvento::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CanalEvento  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $CanalEvento = CanalEvento::find($request['id']);

        return  $CanalEvento;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CanalEvento  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $CanalEvento = CanalEvento::findOrFail($id);
        $CanalEvento->RetornoCd       = $request->RetornoCd;
        $CanalEvento->RetornoCdNr       = $request->RetornoCdNr;
        $CanalEvento->EventoId       = $request->EventoId;
        if($CanalEvento->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CanalEvento  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model =CanalEvento::where('CanalId',$request->CanalId)->
        where('CanalEventoId',$request->CanalEventoId)->
        where('EventoId',$request->EventoId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $tratret = CanalEvento::select(['cda_canal_eventos.*','cda_evento.EventoNm','cda_evento.EventoNm'])
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_canal_eventos.EventoId')
            ->where('cda_canal_eventos.CanalId',$request->CANALID)
            ->get();
        ;

        return Datatables::of($tratret)->make(true);
    }
}
