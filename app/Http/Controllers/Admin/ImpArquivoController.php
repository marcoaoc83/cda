<?php

namespace App\Http\Controllers\Admin;

use App\Models\ImpArquivo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ImpArquivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_imp_arquivo = DB::table('cda_imp_arquivo')->get();

        return view('admin.implayout.imparvivo.index',compact('cda_imp_arquivo'));
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

        if (ImpArquivo::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImpArquivo  $impArquivo
     * @return \Illuminate\Http\Response
     */
    public function show(ImpArquivo $impArquivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImpArquivo  $impArquivo
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
     * @param  \App\Models\ImpArquivo  $impArquivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $ImpArquivo = ImpArquivo::findOrFail($id);

        if($ImpArquivo->update($request->all()))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImpArquivo  $impArquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = ImpArquivo::findOrFail($request->ArquivoId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $entcart = ImpArquivo::select(['cda_imp_arquivo.*','cda_regtab.*'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_imp_arquivo.TpArqId')
            ->where('cda_imp_arquivo.LayoutId',$request->LayoutId)
            ->get();
        ;

        return Datatables::of($entcart)->make(true);
    }
}
