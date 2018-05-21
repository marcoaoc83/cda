<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\SolicitarAcesso;
use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;

class PortalController extends Controller
{
    public function index()
    {
        return view('portal.home.index');
    }
    public function solicitacao()
    {
        return view('portal.solicitacao.index');
    }
    public function solicitacaoSend(Request $request)
    {
        $data = $request->all();

        SolicitarAcesso::create($data);
        SWAL::message('Solicitação','Enviada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return view('portal.solicitacao.index');
    }
}
