@php
    $total = 0;
@endphp
<table  style="width: 100%;  border-collapse:collapse;">
    <tbody>
    <tr style="height: 18px; background-color: #e1e1e1">
        <td style="  height: 18px; text-align: center;" colspan="2">
            <a class="pf-logo"  href="#"><img height="60px" src="{{asset('images/portal/'.$Var->port_logo_topo)}}" alt="{{$Var->port_titulo}}" /></a>
        </td>
        <td style="  height: 18px; text-align: center;" colspan="5">
            <h2>EXTRATO DO CONTRIBUINTE</h2>
        </td>
        <td style="  height: 18px; text-align: center; font-size: 11px;" colspan="3"><?=date("d/m/Y")?><br /><?=date("H:i")?></td>
    </tr>
    {{--<tr style="height: 18px;">--}}
        {{--<td style="  height: 18px;"></td>--}}
        {{--<td style="  height: 18px;"></td>--}}
        {{--<td style="  height: 18px;"></td>--}}
        {{--<td style=" height: 18px;"></td>--}}
        {{--<td style=" height: 18px;"></td>--}}
        {{--<td style="  height: 18px;"></td>--}}
        {{--<td style="  height: 18px;"></td>--}}
        {{--<td style=" height: 18px;"></td>--}}
        {{--<td style=" height: 18px;"></td>--}}
        {{--<td style=" height: 18px;"></td>--}}
        {{--<td style="  height: 18px;"></td>--}}
        {{--<td style="  height: 18px;"></td>--}}
    {{--</tr>--}}
    <tr style="height: 41px; font-size: 11px; border:#0f0f0f">
        <th style="height: 41px; text-align: left; ">Inscri&ccedil;&atilde;o</th>
        <th style="height: 41px; text-align: left; ">Tipo de Cadastro</th>
        <th style="height: 41px;  text-align: left;">Lan&ccedil;amento</th>
        <th style="height: 41px;  text-align: left;">Parcela</th>
        <th style="height: 41px; text-align: left;">Vencimento</th>
        <th style="height: 41px;   text-align: right;">Valor Principal</th>
        <th style="height: 41px;  text-align: right;">Honor&aacute;rio</th>
        <th style="height: 41px;  text-align: right;">Valor Total</th>
        <th style="height: 41px; text-align: center; ">Atraso (dias)</th>
        <th style="height: 41px; text-align: left;">Situa&ccedil;&atilde;o</th>
    </tr>
    @foreach($cda_parcela as $parcela)
        @php
            $total += $parcela->TotalVr ;
        @endphp
    <tr style="height: 18px;font-size: 12px">
        <td style="  height: 18px;">{{ $parcela->INSCRICAO }}</td>
        <td style="  height: 18px;">{{ $parcela->Tributo }}</td>
        <td style="  height: 18px;">{{Carbon\Carbon::parse($parcela->LancamentoDt )->format('d/m/Y')   }}</td>
        <td style="  height: 18px;">{{ $parcela->ParcelaNr }}</td>
        <td style="  height: 18px;">{{ $parcela->Vencimento }}</td>
        <td style="  height: 18px;text-align: right;">{{ number_format($parcela->PrincipalVr,2,",",".") }}</td>
        <td style="  height: 18px;text-align: right;">{{ number_format($parcela->Honorarios,2,",",".") }}</td>
        <td style="  height: 18px;text-align: right;">{{ number_format($parcela->TotalVr,2,",",".") }}</td>
        <td style="  height: 18px;text-align: center;">{{ $parcela->Atraso }}</td>
        <td style="  height: 18px;">{{ $parcela->SitCob }}</td>
    </tr>
    @endforeach
    <tr style="height: 22px;">
        <td style="  height: 18px;text-align: right;font-weight: bold" colspan="10" >
            <br>Total: R$ {{ number_format($total,2,",",".") }}
        </td>
    </tr>
    <tr style="height: 24px;">
        <td style=" height: 18px; font-size: 11px; text-align: center" colspan="10"><br><b>LEGENDA-SE -<span>&nbsp;</span></b><span></span><b>(A)<span>&nbsp;</span></b><span>- D&iacute;vida Ativa | (*) D&iacute;vida Ativa com CDA ,&nbsp;</span><b>(T)<span>&nbsp;</span></b><span>- D&eacute;bito Protestado,&nbsp;</span><b>(E)<span>&nbsp;</span></b><span>- D&eacute;bito Executado Manual,&nbsp;</span><b>(D)<span>&nbsp;</span></b><span>- D&eacute;bito Executado Eletr&ocirc;nico,&nbsp;</span><b>(S)<span>&nbsp;</span></b><span>- D&eacute;bito Suspenso,&nbsp;</span><b>(P)<span>&nbsp;</span></b><span>- D&eacute;bito Parcelado e&nbsp;</span><b>(Z)<span>&nbsp;</span></b><span>- D&eacute;bito Encaminhado a Protesto</span></td>
    </tr>
    </tbody>
</table>
