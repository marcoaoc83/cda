<?php

namespace App\Http\Controllers\Admin;

use App\Models\FilaConf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class FilaConfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_filaconf = DB::table('cda_filaconf')->get();

        return view('admin.fila.filaconf.index',compact('cda_filaconf'));
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

        if (FilaConf::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FilaConf  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function show(FilaConf $horaExec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilaConf  $horaExec
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
     * @param  \App\Models\FilaConf  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $FilaConf = FilaConf::findOrFail($id);
        $FilaConf->FilaConfId       = $request->FilaConfId;
        $FilaConf->FilaConfDs       = $request->FilaConfDs;
        $FilaConf->TABSYSID       = $request->TABSYSID;
        if($FilaConf->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilaConf  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = FilaConf::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }
    
    public function getDadosDataTable(Request $request)
    {
        $filaconf = FilaConf::select(['cda_filaconf.*','TABSYSNM','REGTABNM'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_filaconf.FilaConfId')
            ->join('cda_tabsys', 'cda_tabsys.TABSYSID', '=', 'cda_filaconf.TABSYSID')
            ->where('cda_filaconf.FilaTrabId',$request->FilaTrabId)
            ->get();
        ;

        return Datatables::of($filaconf)->make(true);
    }
}
