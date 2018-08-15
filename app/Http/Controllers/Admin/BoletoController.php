<?php

namespace App\Http\Controllers\Admin;

use App\Models\Boleto;
use App\Models\Parcela;
use App\Models\PortalAdm;
use Carbon\Carbon;
use Eduardokum\LaravelBoleto\Boleto\Banco\Caixa;
use Eduardokum\LaravelBoleto\Boleto\Render\Pdf;
use Eduardokum\LaravelBoleto\Pessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BoletoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $beneficiario = new Pessoa([
            'documento' => '00.000.000/0000-00',
            'nome'      => 'Company co.',
            'cep'       => '00000-000',
            'endereco'  => 'Street name, 123',
            'bairro' => 'district',
            'uf'        => 'UF',
            'cidade'    => 'City',
        ]);
        $pagador = new Pessoa([
            'documento' => '00.000.000/0000-00',
            'nome'      => 'Company co.',
            'cep'       => '00000-000',
            'endereco'  => 'Street name, 123',
            'bairro' => 'district',
            'uf'        => 'UF',
            'cidade'    => 'City',
        ]);
        $caixa = new Caixa();
        //$caixa->setLogo('/path/to/logo.png');
        $caixa->setDataVencimento(Carbon::createFromFormat('Y-m-d','2018-10-07'));
        $caixa->setValor('100');
        $caixa->setNumero(1);
        $caixa->setNumeroDocumento(1);
        $caixa->setPagador($pagador);
        $caixa->setBeneficiario($beneficiario);
        $caixa->setCarteira('RG');
        $caixa->setAgencia(1111);
        $caixa->setCodigoCliente(222222);
        $caixa->setDescricaoDemonstrativo(['demonstrativo 1', 'demonstrativo 2', 'demonstrativo 3']);
        $caixa->setInstrucoes(['instrucao 1', 'instrucao 2', 'instrucao 3']);
        //$caixa->addDescricaoDemonstrativo('demonstrativo 4');


        $caixa->renderPDF(true);

        $pdf = new Pdf();
        $pdf->addBoleto($caixa);
        $pdf->showPrint();
        $pdf->hideInstrucoes();
        $pdf->gerarBoleto($dest = Pdf::OUTPUT_STANDARD, $save_path = null);

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function show($parcela)
    {
        $cda_parcela = Parcela::select([
            'cda_parcela.*',
            DB::raw("if(VencimentoDt='0000-00-00',null,VencimentoDt) as VencimentoDt"),
            'SitPagT.REGTABNM as  SitPag',
            'SitCobT.REGTABNM as  SitCob',
            'OrigTribT.REGTABNM as  OrigTrib',
            'TributoT.REGTABNM as  Tributo',
            'Pessoa.*'
        ])
            ->leftjoin('cda_regtab as SitPagT', 'SitPagT.REGTABID', '=', 'cda_parcela.SitPagId')
            ->leftjoin('cda_regtab as SitCobT', 'SitCobT.REGTABID', '=', 'cda_parcela.SitCobId')
            ->leftjoin('cda_regtab as OrigTribT', 'OrigTribT.REGTABID', '=', 'cda_parcela.OrigTribId')
            ->leftjoin('cda_pessoa as Pessoa', 'Pessoa.PESSOAID', '=', 'cda_parcela.PessoaId')
            ->leftjoin('cda_regtab as TributoT', 'TributoT.REGTABID', '=', 'cda_parcela.TributoId')
            ->where(DB::raw('md5(cda_parcela.ParcelaId)'),$parcela)->get();
        //dd($cda_parcela);
        $cda_parcela=$cda_parcela[0];
        $cda_portal = PortalAdm::get();
        $cda_portal=$cda_portal[0];
        $beneficiario = new Pessoa([
            'documento' => $cda_portal->port_boleto_nr_documento,
            'nome'      => $cda_portal->port_titulo,
            'cep'       => '',
            'endereco'  => $cda_portal->port_endereco,
            'bairro'    => '',
            'uf'        => '',
            'cidade'    => '',
        ]);
        $pagador = new Pessoa([
            'documento' => $cda_parcela->CPF_CNPJNR,
            'nome'      => $cda_parcela->PESSOANMRS,
            'cep'       => '',
            'endereco'  => '',
            'bairro' => '',
            'uf'        => '',
            'cidade'    => '',
        ]);

        $caixa = new Caixa();
        //$caixa->setLogo(asset('images/portal/'.$cda_portal->port_logo_topo));
        $caixa->setDataVencimento(Carbon::parse()->addDays(3));
        $caixa->setValor($cda_parcela->TotalVr);
        $caixa->setNumero($cda_parcela->ParcelaId);
        $caixa->setNumeroDocumento($cda_parcela->LancamentoNr);
        $caixa->setPagador($pagador);
        $caixa->setBeneficiario($beneficiario);
        $caixa->setCarteira('RG');
        $caixa->setAgencia($cda_portal->port_boleto_agencia);
        $caixa->setCodigoCliente($cda_portal->port_boleto_codigo_cliente);
        $caixa->setDescricaoDemonstrativo(['Origem:'.$cda_parcela->OrigTrib,'Tributo:'.$cda_parcela->Tributo]);
        $caixa->setInstrucoes([$cda_portal->port_boleto_instrucao1,$cda_portal->port_boleto_instrucao2,$cda_portal->port_boleto_instrucao3,$cda_portal->port_boleto_instrucao4]);
        //$caixa->addDescricaoDemonstrativo('demonstrativo 4');


        $caixa->renderPDF(true);

        $pdf = new Pdf();
        $pdf->addBoleto($caixa);
        $pdf->showPrint();
        $pdf->hideInstrucoes();
        $pdf->gerarBoleto($dest = Pdf::OUTPUT_STANDARD, $save_path = null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function edit(Boleto $boleto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Boleto $boleto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Boleto  $boleto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Boleto $boleto)
    {
        //
    }
}
