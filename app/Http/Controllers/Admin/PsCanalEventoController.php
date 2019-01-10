<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PsCanalEventoController extends Controller
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
     * @param  \App\Models\PsCanalEvento  $PsCanalEvento
     * @return \Illuminate\Http\Response
     */
    public function show(PsCanalEvento $PsCanalEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PsCanalEvento  $PsCanalEvento
     * @return \Illuminate\Http\Response
     */
    public function edit(PsCanalEvento $PsCanalEvento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PsCanalEvento  $PsCanalEvento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PsCanalEvento $PsCanalEvento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PsCanalEvento  $PsCanalEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy(PsCanalEvento $PsCanalEvento)
    {
        //
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_parcela = DB::select("Select
                                      DATE_FORMAT(cda_canal_fila.cafi_entrada,'%d/%m/%Y') as EVENTODT,
                                      cda_canal.CANALSG As Canal,
                                      cda_filatrab.FilaTrabSg As Fila,
                                      cda_evento.EventoSg As Evento,
                                      TpPos.REGTABSG as Tipo,
                                      objetivo.REGTABSG as Objetivo,
                                      FonteTB.REGTABSG as Fonte
                                    From
                                      cda_canal_fila
                                      Inner Join
                                      cda_evento On cda_canal_fila.cafi_evento = cda_evento.EventoId
                                       LEFT Join
                                      cda_regtab AS objetivo On cda_evento.ObjEventoId = objetivo.REGTABID
                                      LEFT Join
                                      cda_pscanal On cda_canal_fila.cafi_pscanal = cda_pscanal.PsCanalId
                                      LEFT Join
                                      cda_regtab as FonteTB On cda_pscanal.FonteInfoId = FonteTB.REGTABID
                                      LEFT Join
                                      cda_regtab as TpPos On cda_pscanal.TipPosId = TpPos.REGTABID
                                      LEFT Join
                                      cda_canal On cda_pscanal.CANALID = cda_canal.CANALID
                                      Inner Join
                                      cda_filatrab On cda_canal_fila.cafi_fila = cda_filatrab.FilaTrabId
                                      where 
                                      cda_canal_fila.cafi_pscanal ='{$request->pscanal}'
                          ")
        ;

        return Datatables::of($cda_parcela)->make(true);
    }
}
