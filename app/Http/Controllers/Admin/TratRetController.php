<?php

namespace App\Http\Controllers\Admin;

use App\Models\TratRet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TratRetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_tratret = DB::table('cda_tratret')->get();

        return view('admin.canal.tratret.index',compact('cda_tratret'));
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

        if (TratRet::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TratRet  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = $request->all();

        if (TratRet::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TratRet  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $TratRet = TratRet::find($request['id']);

        return  $TratRet;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TratRet  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TratRet = TratRet::findOrFail($id);
        $TratRet->RetornoCd       = $request->RetornoCd;
        $TratRet->RetornoCdNr       = $request->RetornoCdNr;
        $TratRet->EventoId       = $request->EventoId;
        if($TratRet->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TratRet  $tratRet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model =TratRet::where('CanalId',$request->CanalId)->
        where('TratRetId',$request->TratRetId)->
        where('EventoId',$request->EventoId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $tratret = TratRet::select(['RetornoCd', 'RetornoCdNr', 'EventoSg','cda_tratret.EventoId','TratRetId'])
            ->join('cda_canal', 'cda_canal.CANALID', '=', 'cda_tratret.CanalId')
            ->join('cda_evento', 'cda_evento.EventoId', '=', 'cda_tratret.EventoId')
            ->where('cda_tratret.CanalId',$request->CANALID)
            ->get();
        ;

        return Datatables::of($tratret)->make(true);
    }
}
