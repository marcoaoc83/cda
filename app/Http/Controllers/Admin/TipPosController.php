<?php

namespace App\Http\Controllers\Admin;

use App\Models\TipPos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TipPosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_tippos = DB::table('cda_tippos')->get();

        return view('admin.canal.tippos.index',compact('cda_tippos'));
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

        if (TipPos::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipPos  $tipPos
     * @return \Illuminate\Http\Response
     */
    public function show(TipPos $tipPos)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipPos  $tipPos
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
     * @param  \App\Models\TipPos  $tipPos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $TipPos = TipPos::findOrFail($id);
        $TipPos->TipPosId       = $request->TipPosId;
        if($TipPos->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipPos  $tipPos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = TipPos::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }



    public function getDadosDataTable(Request $request)
    {
        $tippos = TipPos::select(['cda_tippos.id','REGTABSG', 'REGTABNM', 'cda_tippos.TipPosId'])
            ->join('cda_regtab', 'cda_regtab.REGTABID', '=', 'cda_tippos.TipPosId')
            ->where('cda_tippos.CanalId',$request->CANALID)
            ->get();
        ;

        return Datatables::of($tippos)->make(true);
    }
}
