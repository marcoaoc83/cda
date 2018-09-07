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
        $cda_execrot = DB::table('cda_execrot')->get();

        return view('admin.carteira.execrot.index',compact('cda_execrot'));
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

        if (PsCanal::create($data))
            return \response()->json(true);
        return \response()->json(false);
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
    public function edit(Request $request)
    {
        return($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PsCanal  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $ExecRot = PsCanal::findOrFail($id);
        if($ExecRot->update($request->all()))
            return \response()->json(true);
        return \response()->json(false);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PsCanal  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = PsCanal::findOrFail($request->PsCanalId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable(Request $request)
    {
        $data = PsCanal::select([
            'cda_pscanal.PsCanalId',
            'cda_pscanal.PessoaId',
            'cda_pscanal.InscrMunId',
            'cda_pscanal.FonteInfoId',
            'cda_pscanal.CanalId',
            'cda_pscanal.TipPosId',
            'cda_pscanal.CEP',
            'cda_pscanal.LogradouroId',
            'cda_pscanal.EnderecoNr',
            'cda_pscanal.Complemento',
            'cda_pscanal.TelefoneNr',
            'cda_pscanal.Email',
            'cda_pscanal.BairroId',
            'cda_pscanal.CidadeId',
            'cda_cidade.cida_uf as UF',
            'FonteInfoId.REGTABNM as FonteInfo',
            'TipPosId.REGTABNM as TipPos',
            'cda_canal.CANALSG',
            'cda_inscrmun.INSCRMUNNR',
            DB::raw('IF(cda_pscanal.LogradouroId IS NOT NULL , CONCAT_WS(" ",cda_logradouro.logr_tipo,cda_logradouro.logr_nome),cda_pscanal.Logradouro) AS Logradouro'),
            DB::raw('IF(cda_pscanal.BairroId IS NOT NULL ,cda_bairro.bair_nome,cda_pscanal.Bairro) AS Bairro'),
            DB::raw('IF(cda_pscanal.CidadeId IS NOT NULL , cda_cidade.cida_nome,cda_pscanal.Cidade) AS Cidade')
        ])
            ->leftjoin('cda_regtab as FonteInfoId', 'FonteInfoId.REGTABID', '=', 'cda_pscanal.FonteInfoId')
            ->leftjoin('cda_regtab as TipPosId', 'TipPosId.REGTABID', '=', 'cda_pscanal.TipPosId')
            ->leftjoin('cda_canal', 'cda_canal.CANALID', '=', 'cda_pscanal.CanalId')
            ->leftjoin('cda_inscrmun', 'cda_inscrmun.INSCRMUNID', '=', 'cda_pscanal.InscrMunId')
            ->leftjoin('cda_logradouro', 'cda_logradouro.logr_id', '=', 'cda_pscanal.LogradouroId')
            ->leftjoin('cda_bairro', 'cda_bairro.bair_id', '=', 'cda_pscanal.BairroId')
            ->leftjoin('cda_cidade', 'cda_cidade.cida_id', '=', 'cda_pscanal.CidadeId')
            ->where('cda_pscanal.PessoaId',$request->PESSOAID);
            if($request->INSCRMUNID)
                $data->where('cda_pscanal.INSCRMUNID',$request->INSCRMUNID);
            $data->get();


        return Datatables::of($data)->make(true);
    }
}
