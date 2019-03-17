@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Parcelamento</div>

            <div class="row justify-content-between pt-lg-4 pb-lg-4 card pf-border-light">
                <div class="card-body">
                    <p class="pf-text-muted mb-4">Selecione a inscrição para consultar débitos em aberto!</p>
                    <table id="tbTributo" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%; font-size: 12px">
                        <thead>
                        <tr>
                            <th>Tipo de Tributo</th>
                            <th>{{App\Models\RegTab::where('REGTABSG','LbDocument')->first()->REGTABNM}}</th>
                            <th>Endereço</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <p></p>
            <div class="row justify-content-between pt-lg-4 pb-lg-4 card pf-border-light" style="display:none " id="rowParcelas">
                <div class="card-body">
                    <p class="h2 pf-text-muted mb-4">Parcelas</p>
                    <table id="tbParcela" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%; font-size: 12px">
                        <thead>
                        <tr>
                            <th>Inscrição</th>
                            <th>Tributo</th>
                            {{--<th>Exercício</th>--}}
                            <th>Lançamento</th>
                            <th>Parcela</th>
                            <th>Vencimento</th>
                            <th>Valor Principal</th>
                            {{--<th>Valor Atualizado</th>--}}
                            <th>Honorário</th>
                            <th>Valor Total</th>
                            <th>Atraso (dias)</th>
                            <th>Situação</th>
                        </tr>
                        </thead>
                    </table>
                    <p class="pf-text-muted mb-4" style="font-size: 10px"><b>LEGENDA-SE - </b>
                        <b> (A) </b>- Dívida Ativa | (*) Dívida Ativa com CDA ,
                        <b> (T) </b>- Débito Protestado,
                        <b> (E) </b>- Débito Executado Manual,
                        <b> (D) </b>- Débito Executado Eletrônico,
                        <b> (S) </b>- Débito Suspenso,
                        <b> (P) </b>- Débito Parcelado  e
                        <b> (Z) </b>- Débito Encaminhado a Protesto
                    </p>
                </div>
                <div class="col-xs-4 text-center">
                    <form   target="_blank" method="post" id="formSimulacao">
                        {{csrf_field()}}
                        <input type="hidden" id="tributo" name="tributo">
                        <input type="hidden" id="inscr" name="INSCRMUNID">
                        <input type="hidden" id="pess" name="PESSOAID" value="{{Session::get('acesso_cidadao')['PESSOAID'] }}">
                        <button type="button" class="btn btn-warning btn-xs " onclick="simular()"><i class="fa fa-print"></i> Simular Parcelamento</button>
                    </form>
                </div>
            </div>
            <p></p>
            <div class="row justify-content-between pt-lg-4 pb-lg-4 card pf-border-light" style="display:none " id="rowSimulacao">
                <div class="card-body">
                    <p class="pf-text-muted mb-4">Selecione um parcelamento</p>
                    <table id="tbSimulacao" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%; font-size: 12px">
                        <thead>
                            <tr>
                                <th>Entrada - R$</th>
                                <th>Parcela - Qtde</th>
                                <th>Parcela - R$</th>
                                <th>Total - R$</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-xs-4 text-center">
                    <form action="{{route( 'portal.exportParcelamento')}}"  target="_blank" method="post" id="formParcelamento">
                        {{csrf_field()}}

                        <input type="hidden" id="sm_dados"          name="sm_dados">
                        <input type="hidden" id="sm_entrada"        name="sm_entrada">
                        <input type="hidden" id="sm_parcela_qtde"   name="sm_parcela_qtde">
                        <input type="hidden" id="sm_parcela_vlr"    name="sm_parcela_vlr">
                        <input type="hidden" id="sm_regra_id"       name="sm_regra_id">
                        <input type="hidden" id="sm_total"          name="sm_total">

                        <button type="button" class="btn btn-warning btn-sm " onclick="parcelar()"><i class="fa fa-dollar-sign"> </i> Realizar Parcelamento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection

@push('scripts')
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>


    <script>
        function simular(){
            var tbSimulacao = $('#tbSimulacao').DataTable();
            var url = "{{ route('portal.getDataSimulacao') }}" + "/?dados=" + $('#formSimulacao').serialize();
            tbSimulacao.ajax.url(url).load();
            var the_id = $("#tbSimulacao");

            $('html, body').animate({
                scrollTop:$(the_id).offset().top
            }, 'slow');
        }
        function parcelar(){
            swal({
                title             : "Salvar Parcelamento",
                text              : "Caso confirme o parcelamento, será gerado o contrato e a primeira guia para o pagamento. " +
                "Os documentos são de sua responsabiblidade e não há necessidade de entrega na Prefeitura!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#002A5B",
                confirmButtonText : "Confirmar",
                cancelButtonText  : "Voltar"
            }).then((resultado) => {
                if (resultado.value) {
                    $('#sm_dados').val($('#formSimulacao').serialize());
                    $('#formParcelamento').submit();
                }
            });

        }
        $(document).ready(function() {
            var tbTributo = $('#tbTributo').DataTable({
                processing: true,
                responsive: true,
                searching: true,
                info: false,
                paging: false,
                "lengthChange": false,
                select: {
                    style: 'single',
                    info: false

                },
                initComplete: function () {
                    $('.dataTables_filter').css({ 'float': 'right'});
                },
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                },
                ajax: {
                    "url": "{{ route('portal.getDataTributo') }}",
                    "data": {
                        "PESSOAID": "{{Session::get('acesso_cidadao')['PESSOAID'] }}"
                    }
                },
                columns: [
                    {
                        data: 'Tributo',
                        name: 'Tributo'
                    },
                    {
                        data: 'INSCRICAO',
                        name: 'INSCRICAO'
                    },
                    {
                        data: 'Endereco',
                        name: 'Endereco'
                    },
                    {
                        data: 'INSCRMUNID',
                        name: 'INSCRMUNID',
                        "visible": false,
                        "searchable": false
                    },
                    {
                        data: 'TributoId',
                        name: 'TributoId',
                        "visible": false,
                        "searchable": false
                    }
                ],
            });

            tbTributo.on( 'select', function ( e, dt, type, indexes ) {
                if (type === 'row') {
                    $('#rowParcelas').show();
                    $('#rowSimulacao').show();


                    var INSCRMUNID = tbTributo.rows(indexes).data().pluck('INSCRMUNID');
                    $('#inscr').val(INSCRMUNID[0]);
                    var TributoId = tbTributo.rows(indexes).data().pluck('TributoId');
                    $('#tributo').val(TributoId[0]);

                    var tableParcela = $('#tbParcela').DataTable();
                    var url = "{{ route('portal.getDataParcela') }}" + "/?INSCRMUNID=" + INSCRMUNID[0];
                    tableParcela.ajax.url(url).load();
                    var the_id = $("#tbParcela");

                    $('html, body').animate({
                        scrollTop:$(the_id).offset().top
                    }, 'slow');
                }
            });
            tbTributo.on( 'deselect', function ( e, dt, type, indexes ) {
                $('#rowParcelas').hide();
                $('#rowSimulacao').hide();
            } );

            var tbParcela = $('#tbParcela').DataTable({
                processing: true,
                responsive: true,
                searching: true,
                info: false,
                paging: true,
                "lengthChange": false,
                select: {
                    style: 'multi',
                    info: false

                },
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                },
                ajax: {
                    "url": "{{ route('portal.getDataParcela') }}",
                    "data": {
                        "PESSOAID": "{{Session::get('acesso_cidadao')['PESSOAID'] }}"
                    }
                },
                columns: [

                    {
                        data: 'INSCRICAO',
                        name: 'INSCRICAO'
                    },
                    {
                        data: 'Tributo',
                        name: 'Tributo'
                    },
                    // {
                    //     data: 'LancamentoDt',
                    //     name: 'LancamentoDt'
                    // }
                    // ,
                    {
                        data: 'LancamentoDt',
                        name: 'LancamentoDt'
                    }
                    ,
                    {
                        data: 'ParcelaNr',
                        name: 'ParcelaNr'
                    }
                    ,
                    {
                        data: 'Vencimento',
                        name: 'Vencimento'
                    }
                    ,
                    {
                        data: 'PrincipalVr',
                        name: 'PrincipalVr'
                    }
                    // ,
                    // {
                    //     data: 'PrincipalVr',
                    //     name: 'PrincipalVr'
                    // }
                    ,
                    {
                        data: 'Honorarios',
                        name: 'Honorarios'
                    }
                    ,
                    {
                        data: 'TotalVr',
                        name: 'TotalVr'
                    }
                    ,
                    {
                        data: 'Atraso',
                        name: 'Atraso'
                    }
                    ,
                    {
                        data: 'SitCob',
                        name: 'SitCob'
                    },
                    {
                        data: 'ParcelaId',
                        name: 'ParcelaId',
                        "visible": false,
                        "searchable": false
                    }
                ],
            });


            tbParcela.on( 'select', function ( e, dt, type, indexes ) {
                if (type === 'row') {
                    var ParcelaId = tbParcela.rows(indexes).data().pluck('ParcelaId');
                    ParcelaId=ParcelaId[0];
                    $('<input>').attr({
                        type: 'hidden',
                        id: 'parcelas'+ParcelaId,
                        name: 'parcelas[]',
                        value: ParcelaId
                    }).appendTo('#formSimulacao');
                }
            });
            tbParcela.on( 'deselect', function ( e, dt, type, indexes ) {
                if (type === 'row') {
                    var ParcelaId = tbParcela.rows(indexes).data().pluck('ParcelaId');
                    ParcelaId=ParcelaId[0];
                    $( "#parcelas"+ParcelaId ).remove();
                }
            } );

            var tbSimulacao = $('#tbSimulacao').DataTable({
                processing: true,
                responsive: true,
                searching: false,
                info: false,
                paging: false,
                "lengthChange": false,
                select: {
                    style: 'single',
                    info: false

                },
                initComplete: function () {
                    $('.dataTables_filter').css({ 'float': 'right'});
                },
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                },
                ajax: {
                    "url": "{{ route('portal.getDataSimulacao') }}",
                    "data": {
                        "dados": $('#formSimulacao').serialize()
                    }
                },
                columns: [
                    {
                        data: 'EntradaVlr',
                        name: 'EntradaVlr'
                    },
                    {
                        data: 'ParcelaQtde',
                        name: 'ParcelaQtde'
                    },
                    {
                        data: 'ParcelaVlr',
                        name: 'ParcelaVlr'
                    },
                    {
                        data: 'Total',
                        name: 'Total'
                    },
                    {
                        data: 'Descricao',
                        name: 'Descricao'
                    },

                    {
                        data: 'RegParcId',
                        name: 'RegParcId',
                        "visible": false,
                        "searchable": false
                    }
                ],
            });

            tbSimulacao.on( 'select', function ( e, dt, type, indexes ) {
                if (type === 'row') {

                    var entrada = tbSimulacao.rows(indexes).data().pluck('EntradaVlr');
                    var parcela_qtde = tbSimulacao.rows(indexes).data().pluck('ParcelaQtde');
                    var parcela_vlr = tbSimulacao.rows(indexes).data().pluck('ParcelaVlr');
                    var regra_id = tbSimulacao.rows(indexes).data().pluck('RegParcId');
                    var total = tbSimulacao.rows(indexes).data().pluck('Total');

                    $('#sm_entrada').val(entrada[0]);
                    $('#sm_parcela_qtde').val(parcela_qtde[0]);
                    $('#sm_parcela_vlr').val(parcela_vlr[0]);
                    $('#sm_regra_id').val(regra_id[0]);
                    $('#sm_total').val(total[0]);
                }
            });

        });
    </script>
@endpush