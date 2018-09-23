@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Seus Débitos</div>

            <div class="row justify-content-between pt-lg-4 pb-lg-4 card pf-border-light">
                <div class="card-body">
                    <p class="pf-text-muted mb-4">Selecione a inscrição para consultar débitos em aberto!</p>
                    <table id="tbTributo" class="table table-hover table-bordered table-striped datatable display responsive nowrap" style="width:100%; font-size: 12px">
                        <thead>
                            <tr>
                                <th>Tipo de Tributo</th>
                                <th>Inscrição Municipal</th>
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
                    <form action="{{route( 'portal.exportExtrato')}}" target="_blank" method="post">
                        {{csrf_field()}}
                        <input type="hidden" id="inscr" name="INSCRMUNID">
                        <input type="hidden" id="pess" name="PESSOAID" value="{{Session::get('acesso_cidadao')['PESSOAID'] }}">
                    <button type="submit" class="btn btn-warning btn-xs "  ><i class="fa fa-print"></i> Imprimir Extrato</button>
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
                        data: 'INSCRMUNID',
                        name: 'INSCRMUNID',
                        "visible": false,
                        "searchable": false
                    },
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
                    }
                ],
            });

            tbTributo.on( 'select', function ( e, dt, type, indexes ) {
                if (type === 'row') {
                    $('#rowParcelas').show();


                    var INSCRMUNID = tbTributo.rows(indexes).data().pluck('INSCRMUNID');
                    $('#inscr').val(INSCRMUNID[0]);
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
                    }
                ],
            });

        });
    </script>
@endpush