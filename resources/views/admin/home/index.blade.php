@extends('layouts.app')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row top_tiles" style="margin: 10px 0;">
                <div class="col-md-2 col-sm-2 col-xs-4 tile">
                    <span>Total Parcelas</span>
                    <h2>{{$parcela_qtde}}</h2>
                    <span class="sparkline_one" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 tile">
                    <span>Total R$</span>
                    <h2>R$ {{$parcela_sum}}</h2>
                    <span class="sparkline_one" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-6 tile">
                    <span>Total Parcelas Abertas</span>
                    <h2>{{$parcela_qtde_aberta}}</h2>
                    <span class="sparkline_three" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 tile">
                    <span>Total Abertas R$</span>
                    <h2>{{$parcela_sum_aberta}}</h2>
                    <span class="sparkline_one" style="height: 160px;">
                      <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                  </span>
                </div>
            </div>
            <br />

        </div>
    </div>
    <!-- /page content -->
@endsection
