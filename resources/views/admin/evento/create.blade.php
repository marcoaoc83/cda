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
                    <h3>Evento</h3>
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
                            <h2>Dados do Evento <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('evento.store') }}">
                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EventoOrd">Ordem <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('EventoOrd') }}" id="EventoOrd" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="EventoOrd"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpASId">TpAS <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="TpASId" name="TpASId" required="required">
                                            <option value=""></option>
                                                        @foreach($TpAS as $TpASx)
                                                <option value="{{$TpASx->REGTABID}}">{{$TpASx->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ObjEventoId">Objetivo do evento <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="ObjEventoId" name="ObjEventoId" required="required">
                                            <option value=""></option>
                                                        @foreach($ObjEvento as $var)
                                                <option value="{{$var->REGTABID}}">{{$var->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EventoSg">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('EventoSg') }}" id="EventoSg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="EventoSg"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EventoNm">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('EventoNm') }}"  type="text" id="EventoNm" name="EventoNm" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TransfCtrId">Transfere Contribuinte? <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="TransfCtrId" name="TransfCtrId" required="required" onchange="mostraFila(this.value)">
                                            <option value=""></option>
                                                        @foreach($TrCtr as $var)
                                                <option value="{{$var->REGTABID}}">{{$var->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group" id="divFila" style="display: none">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaTrabId">Fila </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="FilaTrabId" name="FilaTrabId"  >
                                            <option value=""></option>
                                            @foreach($Fila as $var)
                                                <option value="{{$var->FilaTrabId}}" >{{$var->FilaTrabNm}}</option>             
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="AcCanal">Ação no Canal </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="AcCanal" name="AcCanal"  >
                                            <option value=""></option>
                                            @foreach($AcCanal as $AcCanalx)
                                                <option value="{{$AcCanalx->REGTABID}}">{{$AcCanalx->REGTABNM}}</option>             
                                            @endforeach
                                        </select>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script type="text/javascript">
        function mostraFila(val) {
            if(val=='81'){
                $("#divFila").show();
            }else{
                $("#divFila").hide();
            }
        }
    </script>
@endpush