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

        if( $request->Senha)
            $CredPort->Senha = bcrypt($request->Senha);

        $CredPort->PessoaIdCP   =   $request->PessoaIdCP;
        $CredPort->InicioDt     =   $request->InicioDt;
        $CredPort->TerminoDt    =   $request->TerminoDt;

        if($CredPort->save()){
            $arr=[
                'data_inicio' => Carbon::createFromFormat('d/m/Y', $request->InicioDt)->format('Y-m-d') ,
                'data_final' =>  Carbon::createFromFormat('d/m/Y', $request->TerminoDt)->format('Y-m-d')
            ];
            if( $request->Senha){
                $arr=["password" => bcrypt($request->Senha)];
            }
            $user = User::where('CredPortId',$id);
            $user->update($arr);

        }
            return \response()->json(true);

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
            ->leftjoin('cda_pessoa', 'cda_pessoa.PESSOAID', '=', 'cda_credport.PessoaIdCP')
            ->where('cda_credport.PESSOAID',$request->PESSOAID)
            ->get();

        return Datatables::of($cda_credport)->make(true);
    }
}
