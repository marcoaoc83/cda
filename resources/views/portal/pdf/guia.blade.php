@php
    $total = $juros = $valorlc= $descontos = 0;
@endphp
<table style="height: 180px; width: 100%; border-collapse: collapse; font-size: 12px; border: hidden"  border="1" cellspacing="0" cellpadding="0" >
    <tbody>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style="width: 100%; border-collapse: collapse; border-style: none; height: 110px;" border="0">
                <tbody>
                <tr style="height: 110px;">
                    <td style="width: 13.6913%; text-align: center; height: 110px;">
                       {{--<img height="60px" src="{{asset('images/portal/'.$Var->port_logo_topo)}}" alt="{{$Var->port_titulo}}" />--}}
                    </td>
                    <td style="width: 86.3087%; height: 110px;">
                        <h2 style="text-align: left;">PREFEITURA MUNICIPAL DE CDA</h2>
                        <h4 style="text-align: left;"> DOCUMENTO DE ARRECADA&Ccedil;&Atilde;O</h4>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">&nbsp;</td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style="width: 100%; border-collapse: collapse; border-style: solid; height: 36px;font-size: 12px;" border="1" >
                <tbody>
                <tr style="height: 36px;">
                    <td style="width: 25%; border-style: solid; height: 36px;"><strong>GUIA DAM<br /><br /></strong>{{$info->GuiaNR}}</td>
                    <td style="width: 25%; border-style: solid; height: 36px;"><strong>NOSSO NUMERO<br /><br /></strong>{{$info->GuiaNR}}</td>
                    <td style="width: 25%; border-style: solid; height: 36px;"><strong>DATA DE EMISS&Atilde;O</strong><br /><br /><?=date('d/m/Y')?></td>
                    <td style="width: 25%; border-style: solid; height: 36px;"><strong>AUTENTICIDADE<br /><br /></strong></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style="border-collapse: collapse; width: 100%; height: 36px;font-size: 12px;" border="1">
                <tbody>
                <tr style="height: 36px;">
                    <td style="width: 50%; border-style: solid; height: 36px;"><strong>CONTRIBUINTE / PROPRIET&Aacute;RIO</strong><br /><br />{{ $info->PESSOANMRS }}</td>
                    <td style="width: 50%; border-style: solid; height: 36px;"><strong>COMPROMISS&Aacute;RIO</strong><br /><br /></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style="border-collapse: collapse; width: 100%; height: 36px;font-size: 12px;" border="1">
                <tbody>
                <tr style="height: 36px;">
                    <td style="width: 25%; border-style: solid; height: 36px;"><strong>INSCRI&Ccedil;&Atilde;O</strong><br /><br />{{ $info->INSCRICAO }}</td>
                    <td style="width: 75%; border-style: solid; height: 36px;"><strong>ENDERE&Ccedil;O</strong><br /><br />{{ $endereco->Logradouro }}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style="border-collapse: collapse; width: 100%; height: 36px;font-size: 12px;" border="1">
                <tbody>
                <tr style="height: 36px;">
                    <td style="width: 50.2266%; border-style: solid; height: 36px;"><strong>BAIRRO / LOTEAMENTO</strong><br /><br />{{ $endereco->Bairro }}</td>
                    <td style="width: 34.4788%; border-style: solid; height: 36px;"><strong>CIDADE / UF</strong><br /><br />{{ $endereco->Cidade }} / {{ $endereco->UF }}</td>
                    <td style="width: 15.2946%; border-style: solid;"><strong>CEP<br /><br /></strong> {{ $endereco->CEP }}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style=" border-collapse: collapse; height: 36px; width: 100%; font-size: 10px; border: none; border-color: #666666 " border="1">
                <tbody>
                <tr style="font-size: 9px;">
                    <td style="width: 19.5311%; border-style: solid; text-align: center;  height: 18px;">
                        <strong>IDENTIFICACAO DO D&Eacute;BITO</strong>
                        <br />ANO&nbsp;TRIB&nbsp;PAR LAN&Ccedil;AMENTO
                    </td>
                    <td style="width: 12.0174%; border-style: solid; text-align: center; height: 18px;"><strong>CODIGO SISTEMA ANTERIOR</strong></td>
                    <td style="width: 6.75158%; border-style: solid; text-align: center; height: 18px;"><strong>SE</strong></td>
                    <td style="width: 7.63679%; border-style: solid; text-align: center; height: 18px;"><strong>TRIBUTO</strong></td>
                    <td style="width: 10.2803%; border-style: solid; text-align: center; height: 18px;"><strong>VENCIMENTO</strong></td>
                    <td style="width: 13.528%; border-style: solid; text-align: right; height: 18px;"><strong>VALOR LAN&Ccedil;ADO</strong></td>
                    <td style="width: 12.7728%; border-style: solid; text-align: right; height: 18px;"><strong>VALOR ATUALIZADO</strong></td>
                    <td style="width: 6.37092%; border-style: solid; text-align: right; height: 18px;"><strong>MULTA/JUROS /DESC</strong></td>
                    <td style="width: 9.1111%; border-style: solid; text-align: right; height: 18px;"><strong>VALOR</strong></td>
                </tr>
                @foreach($cda_parcela as $parcela)
                    @php
                        $total += $parcela->TotalVr ;
                        $juros +=$parcela->MultaVr+$parcela->JurosVr;
                        $valorlc +=$parcela->PrincipalVr;
                        $descontos +=$parcela->DescontoVr;
                    @endphp
                <tr style="height: 18px;">
                    <td style="width: 17.5311%; text-align: center; border-style: none; height: 18px;">{{$parcela->LancamentoNr}}{{$parcela->Tributo}}{{$parcela->ParcelaNr}}{{Carbon\Carbon::parse($parcela->LancamentoDt )->format('mY')}} </td>
                    <td style="width: 12.0174%; text-align: center; border-style: none; height: 18px;"></td>
                    <td style="width: 9.75158%; text-align: center; border-style: none; height: 18px;"></td>
                    <td style="width: 7.63679%; text-align: center; border-style: none; height: 18px;">{{$parcela->Tributo}}</td>
                    <td style="width: 10.2803%; text-align: center; border-style: none; height: 18px;">{{$parcela->Vencimento}}</td>
                    <td style="width: 13.528%; text-align: right; border-style: none; height: 18px;">{{$parcela->PrincipalVr}}</td>
                    <td style="width: 12.7728%; text-align: right; border-style: none; height: 18px;">{{$parcela->PrincipalVr}}</td>
                    <td style="width: 5.37092%; text-align: right; border-style: none; height: 18px;">{{$parcela->MultaVr+$parcela->JurosVr-$parcela->DescontoVr}}</td>
                    <td style="width: 11.1111%; text-align: right; border-style: none; height: 18px;">{{$parcela->TotalVr}}</td>
                </tr>
                @endforeach
                <tr style="height: 18px;">
                    <td style="width: 17.5311%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 12.0174%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 9.75158%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 7.63679%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 10.2803%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 13.528%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 12.7728%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 5.37092%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 11.1111%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                </tr>
                <tr style="height: 18px;">
                    <td style="width: 17.5311%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 12.0174%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 9.75158%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 7.63679%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 10.2803%; text-align: center; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 13.528%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 12.7728%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 5.37092%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                    <td style="width: 11.1111%; text-align: right; border-style: none; height: 18px;"><strong>&nbsp;</strong></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">

            <strong>N&atilde;o receber apos a data de vencimento</strong>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;">
            <table style="border-collapse: collapse; width: 100%; height: 18px;font-size: 12px;" border="1">
                <tbody>
                <tr style="height: 18px;font-size: 10px">
                    <td style="width: 14.2857%; border-style: solid; text-align: center; height: 18px;"><strong>DATA VALIDADE</strong><br /><br />{{  \Carbon\Carbon::now()->endOfMonth()->format('d/m/Y')}}</td>
                    <td style="width: 14.2857%; border-style: solid; text-align: center; height: 18px;"><strong>VALOR LAN&Ccedil;ADO</strong><br /><br />{{$valorlc}}</td>
                    <td style="width: 14.2857%; border-style: solid; text-align: center; height: 18px;"><strong>VALOR ATUALIZADO</strong><br /><br />{{$valorlc}}</td>
                    <td style="width: 14.2857%; border-style: solid; text-align: center; height: 18px;"><strong>MULTA/JUROS</strong><br /><br />{{$juros}}</td>
                    <td style="width: 14.2857%; border-style: solid; text-align: center; height: 18px;"><strong>DESCONTO</strong><br /><br />{{$descontos}}</td>
                    <td style="width: 14.2857%; border-style: solid; text-align: center; height: 18px;"><strong>GRT</strong><br /><br />-</td>
                    <td style="width: 14.2857%; border-style: solid; text-align: right; height: 18px;"><strong>TOTAL</strong><br /><br />{{$total}}</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr style="height: 18px;">
        <td style="width: 100%; height: 18px;font-size: 10px"><br /><strong>LEGENDA-SE -&nbsp;</strong><strong>(A)&nbsp;</strong>- D&iacute;vida Ativa | (*) D&iacute;vida Ativa com CDA ,&nbsp;<strong>(T)&nbsp;</strong>- D&eacute;bito Protestado,&nbsp;<strong>(E)&nbsp;</strong>- D&eacute;bito Executado Manual,&nbsp;<strong>(D)&nbsp;</strong>- D&eacute;bito Executado Eletr&ocirc;nico,&nbsp;<strong>(S)&nbsp;</strong>- D&eacute;bito Suspenso,&nbsp;<strong>(P)&nbsp;</strong>- D&eacute;bito Parcelado e&nbsp;<strong>(Z)&nbsp;</strong>- D&eacute;bitoEncaminhado a Protesto</td>
    </tr>
    <tr>
        <td style="width: 100%;text-align: right"><strong>AUTENTICAÇÃO MECANICA - VIA BANCO</strong></td>
    </tr>
    <tr>
        <td style="width: 100%; text-align: center"><br><img src="data:image/png;base64,{{DNS1D::getBarcodePNG($info->barcode, 'C128',1.5,50)}}" alt="barcode" /></td>
    </tr>
    </tbody>
</table>