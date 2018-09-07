<?php

namespace App\Http\Controllers\Admin;

use App\Models\ModeloVar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ModeloVarController extends Controller
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

        if(ModeloVar::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModeloVar  $modeloVar
     * @return \Illuminate\Http\Response
     */
    public function show(ModeloVar $modeloVar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModeloVar  $modeloVar
     * @return \Illuminate\Http\Response
     */
    public function edit(ModeloVar $modeloVar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModeloVar  $modeloVar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $ModeloVar = ModeloVar::findOrFail($id);
        $update=$ModeloVar->update($request->except(['_token']));
        if($update)
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModeloVar  $modeloVar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = ModeloVar::findOrFail($request->var_id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $info = ModeloVar::select(['cda_modcom_var.*'])
            ->where('cda_modcom_var.ModComId',$request->ModComId)
            ->get();

        return Datatables::of($info)->make(true);
    }
}
