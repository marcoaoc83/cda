<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\CredPort;
use App\Models\Faq;
use App\Models\Legislacao;
use App\Models\PortalAdm;
use App\Models\SolicitarAcesso;
use Carbon\Carbon;
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

        if($data['soa_data_nasc']){
            $data['soa_data_nasc']=Carbon::createFromFormat('d/m/Y', $data['soa_data_nasc'])->format('Y-m-d');
        }

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

    public function acessoLogin(Request $request)
    {
        $login = CredPort::join('cda_pessoa as Pessoa', 'Pessoa.PESSOAID', '=', 'cda_credport.PessoaId')
            ->where('CPF_CNPJNR',$request->documento)
            ->where('Senha',md5($request->password))
            ->get();
        if(count($login)){
            SWAL::message('Bem vindo',$login[0]->PESSOANMRS,'success',['timer'=>4000,'showConfirmButton'=>false]);
            $request->session()->put('acesso_cidadao',$login[0]);
            $Var = PortalAdm::select(['cda_portal.*'])->get();
            return redirect('debitos')->with('Var',$Var[0]);
            //return view('portal.index.debitos')->with('Var',$Var[0]);
        }else{
            SWAL::message('Acesso','Dados incorretos!','error',['timer'=>4000,'showConfirmButton'=>false]);
            $Var = PortalAdm::select(['cda_portal.*'])->get();
            return view('portal.index.acesso')->with('Var',$Var[0]);
        }

    }

    public function debitos()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.debitos')->with('Var',$Var[0]);
    }

}
