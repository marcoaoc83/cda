@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet">
    <style>
        .modal-full {
            min-width: 95%;
        }

    </style>
@endsection
@section('content')
    <!-- page content -->
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>{{$Relatorio->rel_titulo}}</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel" id="divFiltros" style="">
                        <form class="form-horizontal form-label-left" id="formFiltroParcela"    method="post" action="" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include('admin.relatorios.filtro-carteira')
                            @include('admin.relatorios.filtro-roteiro')
                            @include('admin.relatorios.filtro-contribuinte')
                            @include('admin.relatorios.filtro-parcela')

                            <div class="x_panel text-center " style="background-color: #BDBDBD" id="divBotaoFiltrar">
                                <a class="btn btn-app" id="btfiltrar" onclick="filtrar()" >
                                    <i class="fa fa-filter"></i> Filtrar
                                </a>
                            </div>
                            <button id="send" type="submit" class="btn btn-success hidden">Salvar - {{strtoupper($Relatorio->rel_saida)}}</button>
                        </form>
                    </div>
                    @include('admin.relatorios.result-contribuinte')
                    @include('admin.relatorios.result-im')
                    @include('admin.relatorios.result-parcela')
                    <div class="x_panel text-center noHigiene ">

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <a class="btn btn-app " >
                                <i class="fa fa-save"></i> SALVAR - {{strtoupper($Relatorio->rel_saida)}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>

    @include('admin.relatorios.datepicker')
    @include('admin.relatorios.geral')

    @include('admin.relatorios.tbCarteira')
    @include('admin.relatorios.tbRoteiro')


    @include('admin.relatorios.tbFxAtraso')
    @include('admin.relatorios.tbFxValor')
    @include('admin.relatorios.tbSitPag')
    @include('admin.relatorios.tbSitCob')
    @include('admin.relatorios.tbOrigTrib')
    @include('admin.relatorios.tbTributo')

    @include('admin.relatorios.tbParcela')
    @include('admin.relatorios.tbContribuinteRes')
    @include('admin.relatorios.tbIMRes')


    @include('admin.relatorios.execFila')
    <script>
        selectFila({{$Relatorio->rel_id}});
    </script>
@endpush