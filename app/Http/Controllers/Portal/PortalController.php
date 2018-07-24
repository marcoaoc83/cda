<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Legislacao;
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
        $Legislacao=Legislacao::select(['cda_portal_legislacao.*'])->get();
        return view('portal.index.legislacao')
            ->with('Var',$Var[0])
            ->with('Legislacao',$Legislacao);
    }
    public function solicitacao()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.solicitacao')->with('Var',$Var[0]);
    }
    public function solicitacaoSend(Request $request)
    {
        $data = $request->all();

        $data['soa_documento']=preg_replace('/[^0-9]/','',$data['soa_documento']);

        if($data['soa_data_nasc'])
            $data['soa_data_nasc'] = date("Y-m-d", strtotime($data['soa_data_nasc']));

        SolicitarAcesso::create($data);
        SWAL::message('Solicitação','Enviada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.solicitacao')->with('Var',$Var[0]);
    }
    public function ajuda()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        $Faq=Faq::select(['cda_portal_faq.*'])->orderBy('faq_ordem','ASC')->get();
        return view('portal.index.ajuda')->with('Var',$Var[0])->with('Faq',$Faq);
    }
    public function acesso()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.acesso')->with('Var',$Var[0]);
    }
}
