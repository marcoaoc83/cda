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
                            <a class="btn btn-app">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                        </div>
                    </div>
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

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('fila.store') }}">
                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaTrabSg">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('FilaTrabSg') }}" name="FilaTrabSg"  id="FilaTrabSg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2"  required="required" type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaTrabNm">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('FilaTrabNm') }}"  type="text" id="FilaTrabNm" name="FilaTrabNm" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Tipo Modelo  </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="TpModId" name="TpModId"  >
                                            <option value=""></option>
                                                        @foreach($TpMod as $var)
                                                <option value="{{$var->REGTABID}}">{{$var->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_carteira">Filtro - Carteira
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="filtro_carteira" name="filtro_carteira" value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_roteiro">Filtro - Roteiro
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="filtro_roteiro" name="filtro_roteiro" value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_validacao">Filtro - Validação de Envio
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="filtro_validacao" name="filtro_validacao"  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_contribuinte">Filtro - Contribuinte
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="filtro_contribuinte" name="filtro_contribuinte" value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtro_parcelas">Filtro - Parcela
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="filtro_parcelas" name="filtro_parcelas"  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_contribuinte">Resultado - Contribuinte
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="resultado_contribuinte" name="resultado_contribuinte"  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_im">Resultado - Insc. Municipal
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="resultado_im" name="resultado_im"  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_parcelas">Resultado - Parcelas
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="resultado_parcelas" name="resultado_parcelas"   value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="resultado_canais">Resultado - Canais
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="resultado_canais" name="resultado_canais"   value="1" class="js-switch" >
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