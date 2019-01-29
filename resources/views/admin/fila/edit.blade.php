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

                    <div>
                        <form class="form-horizontal form-label-left"  id="formFila"  method="post" action="{{ route('fila.update',$Fila->FilaTrabId) }}">
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Tipo Modelo </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select class="form-control" id="TpModId" name="TpModId"  >
                                                    <option value=""></option>
                                                                @foreach($TpMod as $var)
                                                        <option value="{{$var->REGTABID}}"  @if ($Fila->TpModId === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-xs-12 "  >
                                <div class="x_panel" id="filExecucao">
                                    <div class="x_title">
                                        <h2>Execução de Fila<small></small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        
                                        <div class="item form-group">
                                            <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_carteira">Carteira
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_carteira" name="filtro_carteira"  @if ($Fila->filtro_carteira ==1) checked @endif  value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_roteiro">Roteiro
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_roteiro" name="filtro_roteiro" @if ($Fila->filtro_roteiro ==1) checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_contribuinte">Contribuinte
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_contribuinte" name="filtro_contribuinte" @if($Fila->filtro_contribuinte ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_parcelas">Parcela
                                            </label>
                                            <div class="col-md-7" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_parcelas" name="filtro_parcelas" @if($Fila->filtro_parcelas ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 "  >
                                <div class="x_panel" id="filHigiene">
                                    <div class="x_title">
                                        <h2>Higienização de Cadastro<small></small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="item form-group">
                                            <label class="control-label col-md-6 col-sm-5 col-xs-12" for="filtro_canal">Canal
                                            </label>
                                            <div class="col-md-6" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_canal" name="filtro_canal" @if ($Fila->filtro_canal ==1) checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="filtro_validacao">Validação de Envio
                                            </label>
                                            <div class="col-md-6" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_validacao" name="filtro_validacao" @if ($Fila->filtro_validacao ==1) checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="filtro_eventos">Eventos Possíveis
                                            </label>
                                            <div class="col-md-6" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_eventos" name="filtro_eventos"  value="1" class="js-switch" @if($Fila->filtro_eventos ==1)checked @endif  >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="filtro_tratamento">Tratamento de Retorno
                                            </label>
                                            <div class="col-md-6" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_tratamento" name="filtro_tratamento"  value="1" class="js-switch" @if($Fila->filtro_tratamento ==1)checked @endif  >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="filtro_notificacao">Notificação
                                            </label>
                                            <div class="col-md-6" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="filtro_notificacao" name="filtro_notificacao"  value="1" class="js-switch" @if($Fila->filtro_notificacao ==1)checked @endif  >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 "  >
                                <div class="x_panel" id="filResultado">
                                    <div class="x_title">
                                        <h2>Resultado<small></small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li>
                                                <a class="collapse-link">
                                                    <i class="fa fa-chevron-up"></i>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div class="item form-group">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_contribuinte">Contribuinte
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_contribuinte" name="resultado_contribuinte" @if($Fila->resultado_contribuinte ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_im">Insc. Municipal
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_im" name="resultado_im" @if($Fila->resultado_im ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_parcelas">Parcelas
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_parcelas" name="resultado_parcelas" @if($Fila->resultado_parcelas ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_canais">Canais
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="resultado_canais" name="resultado_canais" @if($Fila->resultado_canais ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group canalgroup">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="canal_crud">Canais - Ins/Update
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="canal_crud" name="canal_crud" @if($Fila->canal_crud ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group canalgroup">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="canal_eventos">Canais - Eventos
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="canal_eventos" name="canal_eventos" @if($Fila->canal_eventos ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                        <div class="item form-group canalgroup">
                                            <label class="control-label col-md-9 col-sm-9 col-xs-12" for="canal_acoes">Canais - Ações do Canal
                                            </label>
                                            <div class="col-md-3" style="margin-top: 5px">
                                                <label style="">
                                                    <input type="checkbox" id="canal_acoes" name="canal_acoes" @if($Fila->canal_acoes ==1)checked @endif value="1" class="js-switch" >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
