<?php

namespace App\Http\Controllers\Admin;

use App\Models\ImpCampo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ImpCampoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_imp_campo = DB::table('cda_imp_campo')->get();

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
        if  ($request->CampoPK) {
            $request->CampoPK      =1;
        }else{
            $request->CampoPK      =0;
        }
        $data = $request->all();

        if (ImpCampo::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImpCampo  $impCampo
     * @return \Illuminate\Http\Response
     */
    public function show(ImpCampo $impCampo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImpCampo  $impCampo
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
     * @param  \App\Models\ImpCampo  $impCampo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if  ($request->CampoPK) {
            $request->CampoPK      =1;
        }else{
            $request->CampoPK      =0;
        }
        $ImpCampo = ImpCampo::findOrFail($id);
        $ImpCampo->CampoNm       = $request->CampoNm;
        $ImpCampo->TabelaDB       = $request->TabelaDB;
        $ImpCampo->CampoDB       = $request->CampoDB;
        $ImpCampo->CampoPK       = $request->CampoPK;
        $ImpCampo->CampoValorFixo       = $request->CampoValorFixo;
        $ImpCampo->FKTabela       = $request->FKTabela;
        $ImpCampo->FKCampo       = $request->FKCampo;
        $ImpCampo->CampoTipo       = $request->CampoTipo;
        if($ImpCampo->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImpCampo  $impCampo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = ImpCampo::findOrFail($request->CampoID);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable(Request $request)
    {
        $entcart = ImpCampo::select(['cda_imp_campo.*'])
            ->where('cda_imp_campo.ArquivoId',$request->ArquivoId)
            ->orderBy('OrdTable', 'ASC')
            ->orderBy('CampoID', 'ASC')
            ->get();
        ;

        return Datatables::of($entcart)->make(true);
    }
}
