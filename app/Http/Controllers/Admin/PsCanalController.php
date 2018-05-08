<?php

namespace App\Http\Controllers\Admin;

use App\Models\PsCanal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PsCanalController extends Controller
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
     * @param  \App\Models\PsCanal  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function show(PsCanal $psCanal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PsCanal  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function edit(PsCanal $psCanal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PsCanal  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PsCanal $psCanal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PsCanal  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function destroy(PsCanal $psCanal)
    {
        //
    }


    public function getDadosDataTable(Request $request)
    {
        $inscrmun = PsCanal::select([
            'cda_pscanal.*',
            'FonteInfoId.REGTABNM as FonteInfo',
            'TipPosId.REGTABNM as TipPos',
            'cda_canal.CANALSG',
            'cda_inscrmun.INSCRMUNNR'
        ])
            ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
            ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
            ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
            ->where('cda_pscanal.PESSOAID',$request->PESSOAID)
            ->get();
        ;

        return Datatables::of($inscrmun)->make(true);
    }
}
