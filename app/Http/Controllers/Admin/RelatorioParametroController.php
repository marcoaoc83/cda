<?php

namespace App\Http\Controllers\Admin;

use App\Models\RelatorioParametro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RelatorioParametroController extends Controller
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
        if (RelatorioParametro::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RelatorioParametro  $relatorioParametro
     * @return \Illuminate\Http\Response
     */
    public function show(RelatorioParametro $relatorioParametro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RelatorioParametro  $relatorioParametro
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $RelatorioParametro = RelatorioParametro::findOrFail($request->rep_id)->toArray();

        return $RelatorioParametro;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RelatorioParametro  $relatorioParametro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $RelatorioParametro = RelatorioParametro::findOrFail($id);
        $update=$RelatorioParametro->update($request->except(['_token']));
        if($update)
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RelatorioParametro  $relatorioParametro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = RelatorioParametro::findOrFail($request->rep_id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $var = RelatorioParametro::where('rep_rel_id',$request->rel_id)->get();

        return Datatables::of($var)->make(true);
    }
}
