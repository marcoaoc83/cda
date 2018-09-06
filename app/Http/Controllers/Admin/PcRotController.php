<?php

namespace App\Http\Controllers\Admin;

use App\Models\PcRot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PcRotController extends Controller
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
     * @param  \App\Models\PcRot  $pcRot
     * @return \Illuminate\Http\Response
     */
    public function show(PcRot $pcRot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PcRot  $pcRot
     * @return \Illuminate\Http\Response
     */
    public function edit(PcRot $pcRot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PcRot  $pcRot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PcRot $pcRot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PcRot  $pcRot
     * @return \Illuminate\Http\Response
     */
    public function destroy(PcRot $pcRot)
    {
        //
    }
    public function getDadosDataTable(Request $request)
    {
        $cda_parcela = DB::select("Select
                                      cda_pcrot.CarteiraId,
                                      cda_pcrot.ParcelaId,
                                      cda_pcrot.RoteiroId,
                                      cda_pcrot.EntradaDt,
                                      cda_pcrot.SaidaDt,
                                      cda_carteira.CARTEIRASG As Carteira,
                                      cda_roteiro.RoteiroOrd As Ordem,
                                      cda_regtab.REGTABSG As Fase,
                                      cda_evento.EventoSg As Evento
                                    From
                                      cda_pcrot
                                      Inner Join
                                      cda_carteira On cda_pcrot.CarteiraId = cda_carteira.CARTEIRAID
                                      Inner Join
                                      cda_roteiro On cda_pcrot.RoteiroId = cda_roteiro.RoteiroId
                                      Inner Join
                                      cda_regtab On cda_roteiro.FaseCartId = cda_regtab.REGTABID
                                      Inner Join
                                      cda_evento On cda_roteiro.EventoId = cda_evento.EventoId
                                      where 
                                      cda_pcrot.ParcelaId ='{$request->ParcelaId}'
                          ")
;

        return Datatables::of($cda_parcela)->make(true);
    }
}
