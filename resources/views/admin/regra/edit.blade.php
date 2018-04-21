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
                    <h3>Regra de Calculo</h3>
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
                            <a class="btn btn-app" href="{{ route('regcalc.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados da Regra de Calculo <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('regcalc.update',$RegraCalculo->RegCalcId) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="RegCalcSg">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$RegraCalculo->RegCalcSg }}" id="RegCalcSg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="RegCalcSg"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="RegCalcNome">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $RegraCalculo->RegCalcNome }}"  type="text" id="RegCalcNome" name="RegCalcNome" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpRegCalcId">Tipo de Regra <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="TpRegCalcId" name="TpRegCalcId" >
                                            <option value=""></option>
                                                        @foreach($TpJuro as $var)
                                                <option value="{{$var->REGTABID}}"  @if ($RegraCalculo->TpRegCalcId === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="IndReajId">Indice de Reajuste <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="IndReajId" name="IndReajId" >
                                            <option value=""></option>
                                                        @foreach($IndReaj as $var)
                                                <option value="{{$var->REGTABID}}" @if ($RegraCalculo->IndReajId === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpJuroId">Tipo de Reajuste <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="TpJuroId" name="TpJuroId" >
                                            <option value=""></option>
                                                        @foreach($TpJuro as $var)
                                                <option value="{{$var->REGTABID}}" @if ($RegraCalculo->TpJuroId === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="InicioDt">Vigencia</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$RegraCalculo->InicioDt }}" type="text" class="form-control has-feedback-left date-picker" id="InicioDt" name="InicioDt" aria-describedby="inputSuccess2Status">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TerminoDt">Termino</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" value="{{$RegraCalculo->TerminoDt }}" class="form-control has-feedback-left date-picker" id="TerminoDt" name="TerminoDt" aria-describedby="inputSuccess2Status">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ModComId">Modelo</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="ModComId" name="ModComId">
                                            <option value=""></option>
                                                        @foreach($ModCom as $var)
                                                <option value="{{$var->ModComId}}" @if ($RegraCalculo->ModComId === $var->ModComId) selected @endif>{{$var->ModComNm}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-2 col-xs-2" for="JuroTx">% Juros
                                    </label>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <input value="{{ $RegraCalculo->JuroTx }}" id="JuroTx" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="JuroTx"  type="number" min="0" max="100">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-2 col-xs-2" for="MultaTx">% Multa
                                    </label>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <input value="{{ $RegraCalculo->MultaTx }}" id="MultaTx" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="MultaTx"   type="number" min="0" max="100">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-2 col-xs-2" for="DescontoTx">% Desconto
                                    </label>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <input value="{{$RegraCalculo->DescontoTx }}" id="DescontoTx" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="DescontoTx"    type="number" min="0" max="100">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-2 col-xs-2" for="HonorarioTx">% Honorarios
                                    </label>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <input value="{{ $RegraCalculo->HonorarioTx }}" id="HonorarioTx" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="HonorarioTx"  type="number" min="0" max="100">
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

@endpush