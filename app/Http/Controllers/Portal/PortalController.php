<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\PortalAdm;
use App\Models\SolicitarAcesso;
use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;

class PortalController extends Controller
{
    public function index()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.home')->with('Var',$Var[0]);
    }
    public function legislacao()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.legislacao')->with('Var',$Var[0]);
    }
    public function solicitacao()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.solicitacao')->with('Var',$Var[0]);
    }
    public function solicitacaoSend(Request $request)
    {
        $data = $request->all();

        SolicitarAcesso::create($data);
        SWAL::message('Solicitação','Enviada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return view('portal.solicitacao.index');
    }
    public function ajuda()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.ajuda')->with('Var',$Var[0]);
    }
    public function acesso()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.acesso')->with('Var',$Var[0]);
    }
}
