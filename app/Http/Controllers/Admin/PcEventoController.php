<?php

namespace App\Http\Controllers\Admin;

use App\Models\PcEvento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PcEventoController extends Controller
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
     * @param  \App\Models\PcEvento  $pcEvento
     * @return \Illuminate\Http\Response
     */
    public function show(PcEvento $pcEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PcEvento  $pcEvento
     * @return \Illuminate\Http\Response
     */
    public function edit(PcEvento $pcEvento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PcEvento  $pcEvento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PcEvento $pcEvento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PcEvento  $pcEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy(PcEvento $pcEvento)
    {
        //
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_parcela = DB::select("Select
                                      DATE_FORMAT(cda_pcevento.EVENTODT,'%d/%m/%Y') as EVENTODT,
                                      cda_canal.CANALSG As Canal,
                                      cda_filatrab.FilaTrabSg As Fila,
                                      cda_evento.EventoSg As Evento,
                                      '' as Tipo,
                                      objetivo.REGTABSG as Objetivo,
                                      FonteTB.REGTABSG as Fonte
                                    From
                                      cda_pcevento
                                      Inner Join
                                      cda_carteira On cda_pcevento.CarteiraId = cda_carteira.CARTEIRAID
                                      Inner Join
                                      cda_evento On cda_pcevento.EventoId = cda_evento.EventoId
                                       Inner Join
                                      cda_regtab AS objetivo On cda_evento.ObjEventoId = objetivo.REGTABID
                                      LEFT Join
                                      cda_pscanal On cda_pcevento.PSCANALID = cda_pscanal.PsCanalId
                                      LEFT Join
                                      cda_regtab as FonteTB On cda_pscanal.FonteInfoId = FonteTB.REGTABID
                                      LEFT Join
                                      cda_canal On cda_pscanal.CANALID = cda_canal.CANALID
                                      Inner Join
                                      cda_filatrab On cda_pcevento.FilaTrabId = cda_filatrab.FilaTrabId
                                      where 
                                      cda_pcevento.PARCELAID ='{$request->ParcelaId}'
                          ")
        ;

        return Datatables::of($cda_parcela)->make(true);
    }
}
