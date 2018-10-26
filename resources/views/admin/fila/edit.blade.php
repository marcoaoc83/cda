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
                    <h3>Fila de Trabalho</h3>
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
                            <a class="btn btn-app" href="{{ route('fila.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a data-toggle="tab" href="#1a">Dados</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#2a">Configurações</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#3a">Filtros</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="row tab-pane active" id="1a">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Dados da Fila <small></small></h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <form class="form-horizontal form-label-left"  id="formFila"  method="post" action="{{ route('fila.update',$Fila->FilaTrabId) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaTrabSg">Sigla <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{ $Fila->FilaTrabSg }}" name="FilaTrabSg"  id="FilaTrabSg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2"  required="required" type="text">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaTrabNm">Nome <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="{{ $Fila->FilaTrabNm }}"  type="text" id="FilaTrabNm" name="FilaTrabNm" required="required" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Tipo Modelo <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="TpModId" name="TpModId" required="required">
                                                    <option value=""></option>
                                                                @foreach($TpMod as $var)
                                                        <option value="{{$var->REGTABID}}"  @if ($Fila->TpModId === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_carteira">Filtro - Carteira
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_carteira" name="filtro_carteira"  @if ($Fila->filtro_carteira ==1) checked @endif  value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_roteiro">Filtro - Roteiro
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_roteiro" name="filtro_roteiro" @if ($Fila->filtro_roteiro ==1) checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_contribuinte">Filtro - Contribuinte
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_contribuinte" name="filtro_contribuinte" @if($Fila->filtro_contribuinte ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_parcelas">Filtro - Parcela
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_parcelas" name="filtro_parcelas" @if($Fila->filtro_parcelas ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_contribuinte">Resultado - Contribuinte
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_contribuinte" name="resultado_contribuinte" @if($Fila->resultado_contribuinte ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_im">Resultado - Insc. Municipal
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_im" name="resultado_im" @if($Fila->resultado_im ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_parcelas">Resultado - Parcelas
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_parcelas" name="resultado_parcelas" @if($Fila->resultado_parcelas ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row tab-pane" id="2a">
                            @include('admin.fila.horaexec.index')
                            @include('admin.fila.filaconf.index')
                        </div>
                        <div class="row tab-pane" id="3a">
                            @include('admin.fila.carteira.index')
                            @include('admin.fila.roteiro.index')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')

@endpush