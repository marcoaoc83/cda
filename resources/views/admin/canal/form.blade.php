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
                    <h3>Canal</h3>
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
                            <a class="btn btn-app" href="{{ route('admin.canal') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados do Canal <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('canal.editarPost',$canal->CANALID) }}">
                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$canal->CANALSG}}" id="CANALSG" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="CANALSG"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CANALNM">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$canal->CANALNM}}"  type="text" id="CANALNM" name="CANALNM" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oTELEFONE">Telefone
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oTELEFONE" name="oTELEFONE" @if ($canal->oTELEFONE ==1) checked @endif   value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oEMAIL">E-mail
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oEMAIL" name="oEMAIL" @if ($canal->oEMAIL ==1) checked @endif    value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oCEP">CEP
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oCEP" name="oCEP" @if ($canal->oCEP ==1) checked @endif   value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oNUMERO">NUMERO
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oNUMERO" name="oNUMERO"  @if ($canal->oNUMERO ==1) checked @endif  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oLOGRADOURO">LOGRADOURO
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oLOGRADOURO" name="oLOGRADOURO" @if ($canal->oLOGRADOURO ==1) checked @endif   value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oCOMPLEMENTO"> COMPLEMENTO
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oCOMPLEMENTO" name="oCOMPLEMENTO"  @if ($canal->oCOMPLEMENTO ==1) checked @endif  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oBAIRRO"> BAIRRO
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oBAIRRO" name="oBAIRRO" @if ($canal->oBAIRRO ==1) checked @endif   value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oCIDADE"> CIDADE
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oCIDADE" name="oCIDADE"  @if ($canal->oCIDADE ==1) checked @endif  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="oUF"> UF
                                    </label>
                                    <div class="col-md-7" style="margin-top: 5px">
                                        <label style="">
                                            <input type="checkbox" id="oUF" name="oUF"  @if ($canal->oUF ==1) checked @endif  value="1" class="js-switch" >
                                        </label>
                                    </div>
                                </div>
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>

                    @include('admin.canal.valenv.index')

                    @include('admin.canal.eventos.index')

                    @include('admin.canal.tratret.index')

                    @include('admin.canal.tippos.index')
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

