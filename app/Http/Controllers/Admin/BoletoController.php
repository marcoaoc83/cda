<?php

namespace App\Http\Controllers\Admin;

use App\Models\Boleto;
use Carbon\Carbon;
use Eduardokum\LaravelBoleto\Boleto\Banco\Caixa;
use Eduardokum\LaravelBoleto\Boleto\Render\Pdf;
use Eduardokum\LaravelBoleto\Pessoa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $caixa->addDescricaoDemonstrativo('demonstrativo 4');


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
    public function show(Boleto $boleto)
    {
        //
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
