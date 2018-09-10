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
        //
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
    public function edit(RelatorioParametro $relatorioParametro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RelatorioParametro  $relatorioParametro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RelatorioParametro $relatorioParametro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RelatorioParametro  $relatorioParametro
     * @return \Illuminate\Http\Response
     */
    public function destroy(RelatorioParametro $relatorioParametro)
    {
        //
    }

    public function getDadosDataTable(Request $request)
    {
        $var = RelatorioParametro::where('rep_rel_id',$request->rel_id)->get();

        return Datatables::of($var)->make(true);
    }
}
