<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpArquivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpArquivoController extends Controller
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

        if (ExpArquivo::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *expArquivo
     * @param  \App\Models\ExpArquivo  $expArquivo
     * @return \Illuminate\Http\Response
     */
    public function show(ExpArquivo $expArquivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpArquivo  $expArquivo
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
     * @param  \App\Models\ExpArquivo  $expArquivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $ExpArquivo = ExpArquivo::findOrFail($id);
        $ExpArquivo->ext_layout_id         = $request->ext_layout_id;
        $ExpArquivo->ext_tabela         = $request->ext_tabela;
        $ExpArquivo->ext_campo          = $request->ext_campo;
        $ExpArquivo->ext_campo_fk       = $request->ext_campo_fk;

        if($ExpArquivo->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpArquivo  $expArquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = ExpArquivo::findOrFail($request->exc_id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable(Request $request)
    {
        $var = ExpArquivo::where('ext_layout_id',$request->exp_id)->get();

         return Datatables::of($var)->make(true);
    }
}
