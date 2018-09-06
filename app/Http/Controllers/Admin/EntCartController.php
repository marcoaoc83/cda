<?php

namespace App\Http\Controllers\Admin;

use App\Models\EntCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EntCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_entcart = DB::table('cda_entcart')->get();

        return view('admin.carteira.entcart.index',compact('cda_entcart'));
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

        if (EntCart::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EntCart  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function show(EntCart $horaExec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntCart  $horaExec
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
     * @param  \App\Models\EntCart  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if  ($request->AtivoSN) {
            $request->AtivoSN      =1;
        }else{
            $request->AtivoSN      =0;
        }
        $EntCart = EntCart::findOrFail($id);
        $EntCart->EntCartId       = $request->EntCartId;
        $EntCart->AtivoSN       = $request->AtivoSN;
        if($EntCart->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntCart  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = EntCart::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $entcart = EntCart::select(['cda_entcart.*','REGTABSG','REGTABNM'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_entcart.EntCartId')
            ->where('cda_entcart.CarteiraId',$request->CarteiraId)
            ->get();
        ;

        return Datatables::of($entcart)->make(true);
    }
}
