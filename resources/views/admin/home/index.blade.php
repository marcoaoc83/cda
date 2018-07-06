@extends('layouts.app')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row top_tiles" style="margin: 10px 0;">

                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                        <div class="count">{{$parcela_qtde}}</div>
                        <h3>Total Parcelas</h3>
                        <p></p>
                    </div>
                </div>

                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-usd" style="padding-left: 15px"></i></div>
                        <div class="count"  >{{$parcela_sum}}</div>
                        <h3>Total</h3>
                        <p></p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-caret-square-o-right"></i></div>
                        <div class="count"  >{{$parcela_qtde_aberta}}</div>
                        <h3>Total Parcelas Abertas</h3>
                        <p></p>
                    </div>
                </div>
                <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-usd" style="padding-left: 15px"></i></div>
                        <div class="count"  >{{$parcela_sum_aberta}}</div>
                        <h3>Total Abertas</h3>
                        <p></p>
                    </div>
                </div>

            </div>
            <br />

        </div>
    </div>
    <!-- /page content -->
@endsection
