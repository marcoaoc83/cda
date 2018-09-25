<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\CredPort;
use App\Models\Faq;
use App\Models\Guia;
use App\Models\GuiaParcela;
use App\Models\Legislacao;
use App\Models\Parcela;
use App\Models\Pessoa;
use App\Models\PortalAdm;
use App\Models\PsCanal;
use App\Models\SolicitarAcesso;
use Barryvdh\DomPDF\Facade as PDF;
use Canducci\Cep\Cep;
use Eduardokum\LaravelBoleto\Pessoa as BoletoPessoa;
use Carbon\Carbon;
use Eduardokum\LaravelBoleto\Boleto\Banco\Caixa;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

define("cEndereco", 1);
define("cEmail", 2);
define("cTelefone", 5);
define("cCelular", 6);
define("cWhatsapp", 8);

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

    public function cep(Request $r)
    {
        $cep =  Cep($r->cep);
        $cepInfo = $cep->toJson();
        return response()->json( $cepInfo->result());
    }

    public function solicitacaoSendPF(Request $request)
    {
        $data = $request->all();

        $data['soa_documento']=preg_replace('/[^0-9]/','',$data['soa_documento']);

        if($data['soa_data_nasc']){
            $data['soa_data_nasc']=Carbon::createFromFormat('d/m/Y', $data['soa_data_nasc'])->format('Y-m-d');
        }

        $pessoa=Pessoa::where("CPF_CNPJNR",$data['soa_documento'])
            ->where("DATA_NASCIMENTO",$data['soa_data_nasc'])
            ->where("NOME_MAE",$data['soa_nome_mae'])
            ->where("PESSOANMRS",$data['soa_nome'])
            ->get()
        ;
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        if(count($pessoa)>0){

            return view('portal.index.solicitacaoPF2')
                ->with('Var',$Var[0])
                ->with('pessoa',$pessoa[0])
                ;
        }else{
            SWAL::message('Solicitação','Seus dados não conferem, entre em contato com a prefeitura!','error',['timer'=>4000,'showConfirmButton'=>false]);
            return view('portal.index.solicitacao') ->with('Var',$Var[0]);
        }
        //SolicitarAcesso::create($data);
        //SWAL::message('Solicitação','Enviada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);

    }
    public function solicitacaoSendPJ(Request $request)
    {
        $data = $request->all();

        $data['soa_documento']=preg_replace('/[^0-9]/','',$data['soa_documento']);

        $pessoa=Pessoa::where("CPF_CNPJNR",$data['soa_documento'])
            ->where("PESSOANMRS",$data['soa_nome'])
            ->get();
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        if(count($pessoa)>0){

                return view('portal.index.solicitacaoPJ2')
                ->with('Var',$Var[0])
                ->with('pessoa',$pessoa[0])
                ;
        }else{
            SWAL::message('Solicitação','Seus dados não conferem, entre em contato com a prefeitura!','error',['timer'=>4000,'showConfirmButton'=>false]);
            return view('portal.index.solicitacao') ->with('Var',$Var[0]);
        }
        //SolicitarAcesso::create($data);
        //SWAL::message('Solicitação','Enviada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);

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
    public function dados()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.meusdados')->with('Var',$Var[0]);
    }

    public function acessoLogin(Request $request)
    {
        $login = CredPort::join('cda_pessoa as Pessoa', 'Pessoa.PESSOAID', '=', 'cda_credport.PessoaId')
            ->where('Pessoa.CPF_CNPJNR',$request->documento)
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

        //return view('portal.pdf.extrato')->with('Var',$Var[0])->with('cda_parcela',$cda_parcela);
        $Var=$Var[0];

        $pdf = App::make('dompdf.wrapper');
        // Send data to the view using loadView function of PDF facade
        $pdf->loadView('portal.pdf.extrato',  compact('cda_parcela','Var'));
        // If you want to store the generated pdf to the server then you can use the store function
        // Finally, you can download the file using download function
        //$pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('extrato.pdf');;
    }

    public function credenciais(Request $request)
    {
        $data=$request->all();
        CredPort::create([
            'PessoaId' => $data['pessoa_id'],
            'Senha' => md5($data['senha']),
        ]);
        //Canal Endereco
        PsCanal::create([
            'PessoaId' => $data['pessoa_id'],
            'FonteInfoId' =>21,
            'CanalId' =>cEndereco,
            'CEP' =>$data['cep'],
            'EnderecoNr' =>$data['numero'],
            'Complemento' =>$data['complemento'],
            'Logradouro' =>$data['logradouro'],
            'Bairro' =>$data['bairro'],
            'Cidade' =>$data['cidade'],
            'UF' =>$data['uf']
        ]);
        //Canal Celular
        PsCanal::create([
            'PessoaId' => $data['pessoa_id'],
            'FonteInfoId' =>21,
            'CanalId' =>cCelular,
            'TelefoneNr' =>$data['celular']
        ]);
        if($data['comercial']) {
            //Canal Residencia
            PsCanal::create([
                'PessoaId' => $data['pessoa_id'],
                'FonteInfoId' => 21,
                'CanalId' => cTelefone,
                'TelefoneNr' => $data['residencial']
            ]);
        }
        if($data['comercial']) {
            //Canal Comercial
            PsCanal::create([
                'PessoaId' => $data['pessoa_id'],
                'FonteInfoId' => 21,
                'CanalId' => cTelefone,
                'TelefoneNr' => $data['comercial']
            ]);
        }
        if($data['email']) {
            //Canal Comercial
            PsCanal::create([
                'PessoaId' => $data['pessoa_id'],
                'FonteInfoId' => 21,
                'CanalId' => cTelefone,
                'Email' => $data['email']
            ]);
        }
        SWAL::message('Solicitação','Enviada com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.acesso')->with('Var',$Var[0]);
    }
    public function guias()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.guias')->with('Var',$Var[0]);
    }

    public function exportGuia(Request $request)
    {

        if($request->PESSOAID != Session::get('acesso_cidadao')['PESSOAID']){
            $Var = PortalAdm::select(['cda_portal.*'])->get();
            return view('portal.index.acesso')->with('Var',$Var[0]);
        }
        $Var = PortalAdm::select(['cda_portal.*'])->get();

        $cda_parcela = Parcela::select([
            'cda_parcela.*',
            'cda_pessoa.*',
            DB::raw("DATE_FORMAT(if(cda_parcela.VencimentoDt='0000-00-00',null,cda_parcela.VencimentoDt),'%d/%m/%Y') as Vencimento"),
            DB::raw("datediff(NOW(), cda_parcela.VencimentoDt)  as Atraso"),
            'SitPagT.REGTABNM as  SitPag',
            'SitCobT.REGTABNM as  SitCob',
            'OrigTribT.REGTABNM as  OrigTrib',
            'TributoT.REGTABNM as  Tributo',
            'cda_inscrmun.INSCRMUNNR as INSCRICAO',
            'cda_inscrmun.INSCRMUNID as INSCRMUNID'

        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->join('cda_pessoa', 'cda_pessoa.PessoaId', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_inscrmun', 'cda_parcela.InscrMunId', '=', 'cda_inscrmun.INSCRMUNID')
            ->whereIn('cda_parcela.ParcelaId',$request->parcelas)
            ->get();

        $endereco= PsCanal::where("PessoaId",$request->PESSOAID)->where('CanalId',1)->orderBy('PsCanalId','Desc')->get();
        if(count($endereco)==0){
            $endereco->Logradouro='';
            $endereco->Bairro='';
            $endereco->Cidade='';
            $endereco->UF='';
            $endereco->CEP='';
        }else{
            $endereco=$endereco[0];
        }
        $info=$cda_parcela[0];
        $Var = PortalAdm::select(['cda_portal.*'])->get();
//        return view('portal.pdf.guia')
//            ->with('Var',$Var[0])
//            ->with('cda_parcela',$cda_parcela)
//            ->with('endereco',$endereco)
//            ->with('info',$info);
        $Var=$Var[0];
        $total=0;
        $GuiaNR = Guia::create([
            'guia_pessoa_id'=>$request->PESSOAID,
            'guia_im'=>$info->INSCRMUNID
        ])->guia_id;
        foreach($cda_parcela as $parcela){
            $total += $parcela->TotalVr;
            GuiaParcela::create([
                'gupa_guia_id'=>$GuiaNR,
                'gupa_parcela_id'=>$parcela->ParcelaId
            ]);
        }
        $dados= new Collection();
        $dados->documento=$info->CPF_CNPJNR;
        $dados->nome=$info->PESSOANMRS;
        $dados->cep=$endereco->CEP;
        $dados->endereco=$endereco->Logradouro;
        $dados->bairro=$endereco->Bairro;
        $dados->uf=$endereco->UF;
        $dados->cidade=$endereco->Cidade;
        $dados->GuiaNR=$GuiaNR;
        $dados->Total=$total;

        $info->barcode=$this->retornaBarcode($dados);
        $info->GuiaNR=$GuiaNR;


        $pdf = App::make('dompdf.wrapper');
        // Send data to the view using loadView function of PDF facade
        $pdf->loadView('portal.pdf.guia',  compact( 'Var','cda_parcela','endereco','info'));
        // If you want to store the generated pdf to the server then you can use the store function
        // Finally, you can download the file using download function
        //$pdf->setOptions(['dpi' => 96, 'defaultFont' => 'sans-serif']);
        return $pdf->stream('extrato.pdf');
    }

    private function retornaBarcode($dados){

        $cda_portal = PortalAdm::get();
        $cda_portal=$cda_portal[0];
        $beneficiario = new BoletoPessoa([
            'documento' => $cda_portal->port_boleto_nr_documento,
            'nome'      => $cda_portal->port_titulo,
            'cep'       => '',
            'endereco'  => $cda_portal->port_endereco,
            'bairro'    => '',
            'uf'        => '',
            'cidade'    => '',
        ]);
        $pagador = new BoletoPessoa([
            'documento' => $dados->documento,
            'nome'      => $dados->nome,
            'cep'       => $dados->cep,
            'endereco'  => $dados->endereco,
            'bairro' =>  $dados->bairro,
            'uf'        => $dados->uf,
            'cidade'    => $dados->cidade
        ]);

        $caixa = new Caixa();
        //$caixa->setLogo(asset('images/portal/'.$cda_portal->port_logo_topo));
        $caixa->setDataVencimento( Carbon::now()->endOfMonth());
        $caixa->setValor($dados->Total);
        $caixa->setNumero($dados->GuiaNR);
        $caixa->setNumeroDocumento($dados->GuiaNR);
        $caixa->setPagador($pagador);
        $caixa->setBeneficiario($beneficiario);
        $caixa->setCarteira('RG');
        $caixa->setAgencia($cda_portal->port_boleto_agencia);
        $caixa->setCodigoCliente($cda_portal->port_boleto_codigo_cliente);
        //$caixa->setDescricaoDemonstrativo(['Origem:'.$dados->OrigTrib,'Tributo:'.$dados->Tributo]);
        //$caixa->setInstrucoes([$cda_portal->port_boleto_instrucao1,$cda_portal->port_boleto_instrucao2,$cda_portal->port_boleto_instrucao3,$cda_portal->port_boleto_instrucao4]);
        //$caixa->addDescricaoDemonstrativo('demonstrativo 4');
        return $caixa->getCodigoBarras();


        $caixa->renderPDF(true);

        $pdf = new Pdf();
        $pdf->addBoleto($caixa);
        $pdf->showPrint();
        $pdf->hideInstrucoes();
        $pdf->gerarBoleto($dest = Pdf::OUTPUT_STANDARD, $save_path = null);
    }

    public function parcelamento()
    {
        $Var = PortalAdm::select(['cda_portal.*'])->get();
        return view('portal.index.parcelamento')->with('Var',$Var[0]);
    }

}


