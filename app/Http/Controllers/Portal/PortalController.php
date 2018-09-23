<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\CredPort;
use App\Models\Faq;
use App\Models\Legislacao;
use App\Models\Parcela;
use App\Models\PortalAdm;
use App\Models\SolicitarAcesso;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

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

    public function getDataTributo(Request $request)
    {
        $cda_parcela = Parcela::select([
            'TributoT.REGTABNM as  Tributo',
            'IM.INSCRMUNNR as INSCRICAO',
            'IM.INSCRMUNID as INSCRMUNID',
            'Lograd.logr_nome as  Endereco'
        ])
            ->leftjoin('cda_inscrmun as IM', 'IM.INSCRMUNID', '=', 'cda_parcela.InscrMunId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->leftjoin('cda_pscanal as PSCanal',function($join)
            {
                $join->on('PSCanal.InscrMunId', '=', 'IM.INSCRMUNID');
                $join->on('PSCanal.CanalId','=',DB::raw("1"));
            })
            ->leftjoin('cda_logradouro as Lograd', 'PSCanal.LogradouroId', '=', 'Lograd.logr_id')
            ->where('cda_parcela.PessoaId',$request->PESSOAID)
            ->where("cda_parcela.SitPagId", "61")
            ->groupBy(['INSCRICAO','Tributo'])
        ;

        //dd($cda_parcela->toSql());
        $cda_parcela->get();

        return Datatables::of($cda_parcela)->make(true);
    }

    public function getDataParcela(Request $request)
    {
        $cda_parcela = Parcela::select([
            'cda_parcela.*',
            DB::raw("DATE_FORMAT(if(cda_parcela.VencimentoDt='0000-00-00',null,cda_parcela.VencimentoDt),'%d/%m/%Y') as Vencimento"),
            DB::raw("datediff(NOW(), cda_parcela.VencimentoDt)  as Atraso"),
            'SitPagT.REGTABNM as  SitPag',
            'SitCobT.REGTABNM as  SitCob',
            'OrigTribT.REGTABNM as  OrigTrib',
            'TributoT.REGTABNM as  Tributo',
            'cda_inscrmun.INSCRMUNNR as INSCRICAO'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_parcela.InscrMunId', '=', 'cda_inscrmun.INSCRMUNID')
            ->where('cda_parcela.PessoaId',$request->PESSOAID);
        if($request->INSCRMUNID && $request->INSCRMUNID!='null')
            $cda_parcela->where('cda_parcela.INSCRMUNID',$request->INSCRMUNID);
        $cda_parcela->get();

        return Datatables::of($cda_parcela)->make(true);
    }

    public function exportExtrato(Request $request)
    {
        if($request->PESSOAID != Session::get('acesso_cidadao')['PESSOAID']){
            $Var = PortalAdm::select(['cda_portal.*'])->get();
            return view('portal.index.acesso')->with('Var',$Var[0]);
        }
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        if($request->INSCRMUNID && $request->INSCRMUNID!='null') {
            $cda_parcela = Parcela::select([
                'cda_parcela.*',
                DB::raw("DATE_FORMAT(if(cda_parcela.VencimentoDt='0000-00-00',null,cda_parcela.VencimentoDt),'%d/%m/%Y') as Vencimento"),
                DB::raw("datediff(NOW(), cda_parcela.VencimentoDt)  as Atraso"),
                'SitPagT.REGTABNM as  SitPag',
                'SitCobT.REGTABNM as  SitCob',
                'OrigTribT.REGTABNM as  OrigTrib',
                'TributoT.REGTABNM as  Tributo',
                'cda_inscrmun.INSCRMUNNR as INSCRICAO'
            ])
                ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
                ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
                ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
                ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
                ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
                ->leftjoin('cda_inscrmun', 'cda_parcela.InscrMunId', '=', 'cda_inscrmun.INSCRMUNID')
                ->where('cda_parcela.PessoaId', $request->PESSOAID)
                ->where('cda_parcela.INSCRMUNID', $request->INSCRMUNID)->get();
        }else{
            $cda_parcela = Parcela::select([
                'cda_parcela.*',
                DB::raw("DATE_FORMAT(if(cda_parcela.VencimentoDt='0000-00-00',null,cda_parcela.VencimentoDt),'%d/%m/%Y') as Vencimento"),
                DB::raw("datediff(NOW(), cda_parcela.VencimentoDt)  as Atraso"),
                'SitPagT.REGTABNM as  SitPag',
                'SitCobT.REGTABNM as  SitCob',
                'OrigTribT.REGTABNM as  OrigTrib',
                'TributoT.REGTABNM as  Tributo',
                'cda_inscrmun.INSCRMUNNR as INSCRICAO'
            ])
                ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
                ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
                ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
                ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
                ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
                ->leftjoin('cda_inscrmun', 'cda_parcela.InscrMunId', '=', 'cda_inscrmun.INSCRMUNID')
                ->where('cda_parcela.PessoaId', $request->PESSOAID)->get();
        }

        return view('portal.pdf.extrato')->with('Var',$Var[0])->with('cda_parcela',$cda_parcela);
        $Var=$Var[0];

        $pdf = App::make('dompdf.wrapper');
        // Send data to the view using loadView function of PDF facade
        $pdf->loadView('portal.pdf.extrato',  compact('cda_parcela','Var'));
        // If you want to store the generated pdf to the server then you can use the store function
        // Finally, you can download the file using download function
        //$pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('extrato.pdf');;
    }
}
