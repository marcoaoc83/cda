<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpCampoPrincipal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ExpCampoPrincipalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_imp_campo = ExpCampoPrincipal::get();

        return view('admin.implayout.impcampo.index',compact('cda_imp_campo'));
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

        if (ExpCampoPrincipal::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpCampoPrincipal  $impCampo
     * @return \Illuminate\Http\Response
     */
    public function show(ExpCampoPrincipal $impCampo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpCampoPrincipal  $impCampo
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
     * @param  \App\Models\ExpCampoPrincipal  $impCampo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $ExpCampoPrincipal = ExpCampoPrincipal::findOrFail($id);
        $ExpCampoPrincipal->exc_ord         = $request->exc_ord;
        $ExpCampoPrincipal->exc_campo       = $request->exc_campo;
        $ExpCampoPrincipal->exc_titulo       = $request->exc_titulo;

        if($ExpCampoPrincipal->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpCampoPrincipal  $impCampo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = ExpCampoPrincipal::findOrFail($request->exc_id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable(Request $request)
    {
        $entcart = ExpCampoPrincipal::where('exc_layout_id',$request->exp_id)
            ->orderBy('exc_ord', 'ASC')
            ->orderBy('exc_id', 'ASC')
            ->get();

         return Datatables::of($entcart)->make(true);
    }
}
