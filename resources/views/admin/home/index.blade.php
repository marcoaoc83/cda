@extends('layouts.app')
@section('styles')
    <link href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    <form id="formFiltro">
        {{ csrf_field() }}
        <div class="right_col" role="main">
            <div class="row top_tiles" style="margin: 10px 0;">
                @include('admin.home.dash-acionamentos')
                @include('admin.home.dash-parcelas')
                @include('admin.home.filtro')
            </div>
        </div>
    </form>
    <!-- /page content -->
@endsection
@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    @include('admin.home.dash-acionamentos-js')
    @include('admin.home.dash-parcelas-js')
    <script>
        $(document).ready(function() {
            chartAcionamentos();
            chartOrigem();
            chartCarteira();
            chartFase();
            $('#graficoAcionamento').show();
            $('#graficoParcelas').hide();
            $('#filtrarGrafico').click(function () {
                if($("#selDash").val()==1){
                    chartAcionamentos();
                    chartOrigem();
                    chartCarteira();
                    chartFase();
                    $('#graficoAcionamento').show();
                    $('#graficoParcelas').hide();
                }else{
                    chartParcelas();
                    chartOrigemParcelas();
                    chartCarteiraParcelas();
                    chartFaseParcelas();
                    $('#graficoAcionamento').hide();
                    $('#graficoParcelas').show();
                }

            })
        });
    </script>
@endpush