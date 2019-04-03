@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
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
                            <a class="btn btn-app">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                        </div>
                    </div>
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados da Graficos <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('graficos.store') }}">
                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_tipo">Tipo</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="graf_tipo" name="graf_tipo">
                                            @foreach($Tipo as $var)
                                                <option value="{{$var->grti_id}}">{{strtoupper($var->grti_nome)}}</option>             
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_titulo">Titulo <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('graf_titulo') }}" id="graf_titulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="graf_titulo"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_subtitulo">Subtítulo <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('graf_subtitulo') }}" id="graf_subtitulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="graf_subtitulo"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_sql_valor">SQL - Valor <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('graf_sql_valor') }}" id="graf_sql_valor"  name="graf_sql_valor"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_sql_campo">SQL - Alias  <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('graf_sql_campo') }}" id="graf_sql_campo"  name="graf_sql_campo"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_sql_condicao">SQL - Condição <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('graf_sql_condicao') }}" id="graf_sql_condicao"  name="graf_sql_condicao"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2"  type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_sql_agrupamento">SQL - Agrupamento <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('graf_sql_agrupamento') }}" id="graf_sql_agrupamento"  name="graf_sql_agrupamento"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_grafico_ref">Gráfico - Pai
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="graf_grafico_ref" name="graf_grafico_ref" >
                                            <option value=""></option>
                                            @foreach($GraficosAll as $var)
                                                <option value="{{$var->graf_id}}" >{{$var->graf_titulo}}</option>             
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="graf_principal">Mostrar Home</label>
                                    <div class="col-md-6" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="graf_principal" name="graf_principal" @if($Graficos->graf_principal ==1)checked @endif value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
    </script>

@endpush