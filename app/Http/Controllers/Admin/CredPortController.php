<?php

namespace App\Http\Controllers\Admin;

use App\Models\CredPort;
use App\Models\Pessoa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CredPortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $data['Senha'] = md5($data['Senha']);

        CredPort::create($data)->CredPortId;

        return \response()->json(true);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CredPort  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function show(CredPort $psCanal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CredPort  $psCanal
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
     * @param  \App\Models\CredPort  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $CredPort = CredPort::findOrFail($id);

        $inicio=$request->InicioDt?$request->InicioDt:date('d/m/Y');
        $CredPort->InicioDt     =  $inicio ;
        $CredPort->TerminoDt    =   $request->TerminoDt;
        $CredPort->Ativo    =   1;

        if($CredPort->save()){
            return \response()->json(true);
        }


        return \response()->json(false);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CredPort  $psCanal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $model = CredPort::findOrFail($request->CredPortId);
        if($model->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_credport = CredPort::select(['cda_credport.*','cda_pessoa.PESSOANMRS','cda_pessoa.CPF_CNPJNR'])
            ->leftjoin('cda_pessoa', 'cda_pessoa.PESSOAID', '=', 'cda_credport.PessoaId')
            ->where('cda_credport.PESSOAID',$request->PESSOAID)
            ->where('cda_credport.Ativo',0)
            ->get();

        return Datatables::of($cda_credport)->make(true);
    }

    public function getDadosDataTable2(Request $request)
    {
        $cda_credport = CredPort::select(['cda_credport.*','cda_pessoa.PESSOANMRS','cda_pessoa.CPF_CNPJNR'])
            ->leftjoin('cda_pessoa', 'cda_pessoa.PESSOAID', '=', 'cda_credport.PessoaId')
            ->where('cda_credport.Ativo',0)
            ->get();

        return Datatables::of($cda_credport)
            ->addColumn('action', function ($credport) {

                return '
                <a href="javascript:ativar('.$credport->CredPortId.')" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Ativar
                </a>
                ';
            })->make(true);
    }
}
