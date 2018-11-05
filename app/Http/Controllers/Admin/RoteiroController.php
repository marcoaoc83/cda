<?php

namespace App\Http\Controllers\Admin;

use App\Models\Roteiro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoteiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_roteiro = DB::table('cda_roteiro')->get();

        return view('admin.carteira.roteiro.index',compact('cda_roteiro'));
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

        if (Roteiro::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roteiro  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function show(Roteiro $horaExec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roteiro  $horaExec
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
     * @param  \App\Models\Roteiro  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $Roteiro = Roteiro::findOrFail($id);
        $Roteiro->RoteiroOrd       = $request->RoteiroOrd;
        $Roteiro->FaseCartId       = $request->FaseCartId;
        $Roteiro->EventoId       = $request->EventoId;
        $Roteiro->ModComId       = $request->ModComId;
        $Roteiro->FilaTrabId       = $request->FilaTrabId;
        $Roteiro->CanalId       = $request->CanalId;
        $Roteiro->RoteiroProxId       = $request->RoteiroProxId;

        if($Roteiro->save())
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roteiro  $horaExec
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = Roteiro::findOrFail($request->id);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }



    public function getDadosDataTable(Request $request)
    {
        $roteiro = Roteiro::select([
            'cda_roteiro.*',
            'Fase.REGTABSG as FaseCartNM',
            'Evento.EventoSg as EventoNM',
            'ModCom.ModComSg as ModComNM',
            'FilaTrab.FilaTrabSg as FilaTrabNM',
            'CANAL.CANALSG as CanalNM',
            'PROX.RoteiroOrd as RoteiroProxNM',
            ])

            ->leftJoin('cda_regtab  as Fase', 'Fase.REGTABID', '=', 'cda_roteiro.FaseCartId')
            ->leftJoin('cda_evento as  Evento', 'Evento.EventoId', '=', 'cda_roteiro.EventoId')
            ->leftJoin('cda_modcom  as ModCom', 'ModCom.ModComId', '=', 'cda_roteiro.ModComId')
            ->leftJoin('cda_filatrab  as FilaTrab', 'FilaTrab.FilaTrabId', '=', 'cda_roteiro.FilaTrabId')
            ->leftJoin('cda_canal  as CANAL', 'CANAL.CANALID', '=', 'cda_roteiro.CanalId')
            ->leftJoin('cda_roteiro  as PROX', 'PROX.RoteiroId', '=', 'cda_roteiro.RoteiroProxId');

        if($request->CarteiraId){
            $roteiro->whereIn('cda_roteiro.CarteiraId', [$request->CarteiraId]);
        }
        if($request->CARTEIRAID){
            $roteiro->whereIn('cda_roteiro.CarteiraId', [$request->CARTEIRAID]);
        }
        $roteiro->get();
        return Datatables::of($roteiro)->make(true);
    }
}
