@extends('layouts.app')

@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

@endsection
@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="row">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(14)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-diagnoses"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Análise de Dados</h4>
                        
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer" onclick="selFila(6)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-headset"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Call Center</h4>
                       
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(9)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-ban"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Cancelamento de Parcelamento</h4>
                        
                    </div>
                </div>
            </div>


            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(3)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-file-pdf"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Emissao de Cartas</h4>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(4)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-at"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Envio de E-mail</h4>
                       
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer" onclick="selFila(8)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-gavel"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Execucao Fiscal</h4>
                       
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(10)">
                <div class="tile-stats" style="height:80px" >
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-file-invoice-dollar"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Geração de CDA</h4>

                    </div>
                </div>
            </div>

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer" onclick="selFila(12)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-broom"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Higienização de Cadastro</h4>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(7)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-money-check-alt"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Protesto de Titulos</h4>
                        
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer" onclick="selFila(5)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-comments"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Envio de SMS</h4>
                        
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer"  onclick="selFila(12)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-notes-medical"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Tratamento de Retorno</h4>
                        
                    </div>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12" style="cursor: pointer" onclick="selFila(11)">
                <div class="tile-stats" style="height:80px">
                    <div class="col-md-4">
                        <div class="icon"><i class="fa fa-check-double"></i></div>
                    </div>
                    <div class="col-md-8">
                        <h4 style="text-align: center">Validação de Envio</h4>
                        
                    </div>
                </div>
            </div>
            </div>

    </div>
    <!-- /page content -->

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script>
        function selFila(fila) {
            window.location = '{{ route('execfila.create')}}?fila='+fila;
        }
    </script>
@endpush