<?php

namespace App\Http\Controllers\Admin;

use App\Models\SolicitarAcesso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class SolicitarAcessoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cda_solicitar_acesso = DB::table('cda_solicitar_acesso')->get();
        return view('solicitar_acesso.index',compact('cda_solicitar_acesso'));
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

        SolicitarAcesso::create($data);
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('solicitar_acesso.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SolicitarAcesso  $solicitarAcesso
     * @return \Illuminate\Http\Response
     */
    public function show(SolicitarAcesso $solicitarAcesso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SolicitarAcesso  $solicitarAcesso
     * @return \Illuminate\Http\Response
     */
    public function edit(SolicitarAcesso $solicitarAcesso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SolicitarAcesso  $solicitarAcesso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitarAcesso $solicitarAcesso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SolicitarAcesso  $solicitarAcesso
     * @return \Illuminate\Http\Response
     */
    public function destroy( $solicitarAcesso)
    {
        $var = SolicitarAcesso::find($solicitarAcesso);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }


    public function getDadosDataTable()
    {
        $cda_solicitacao = SolicitarAcesso::select(['soa_id','soa_tipo', 'soa_nome','soa_documento','soa_data_nasc','soa_nome_mae','soa_datetime']);

        return Datatables::of($cda_solicitacao)
            ->addColumn('action', function ($cda_solicitacao) {

                return '
                <a href="javascript:;" onclick="deleteSolicitarAcesso('.$cda_solicitacao->soa_id.')" class="btn btn-xs btn-danger deletedeleteSolicitarAcesso" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
