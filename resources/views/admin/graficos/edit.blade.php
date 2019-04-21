@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet">
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
                    <h3>Graficos</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <a class="btn btn-app" onclick="$('#send').trigger('click')">
                                <i class="fa fa-save"></i> Salvar
                            </a>
                            <a class="btn btn-app" href="{{Request::url()}}">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                            <a class="btn btn-app" href="{{ route('graficos.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados do Grafico <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('graficos.update',$Graficos->graf_id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="graf_grafico_ref" id="graf_grafico_ref" value="{!! $Graficos->graf_grafico_ref !!}">

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_tabela">Tabela</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="graf_tabela" name="graf_tabela">
                                            @foreach($Tabelas as $keys=>$var)
                                                <option value="{{$keys}}" @if($Graficos->graf_tabela ==$keys)selected @endif >{{$var}}</option>             
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_titulo">Descrição <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$Graficos->graf_titulo }}" id="graf_titulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="graf_titulo"  required="required" type="text">
                                    </div>
                                </div>


                                @if(empty($Graficos->graf_grafico_ref))
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_status">Status</label>
                                    <div class="col-md-6" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="graf_status" name="graf_status" @if($Graficos->graf_status ==1)checked @endif value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin.graficos.series.index');
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
@endpush