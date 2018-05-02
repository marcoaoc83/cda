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
                    <h3>Carteira</h3>
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
                            <a class="btn btn-app" href="{{ route('carteira.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">

                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Dados da Carteira <small></small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <form class="form-horizontal form-label-left"    method="post" action="{{ route('carteira.update',$Carteira->CARTEIRAID) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CARTEIRAORD">Ordem <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="{{ $Carteira->CARTEIRAORD }}" id="CARTEIRAORD" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="CARTEIRAORD"  required="required" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CARTEIRASG">Sigla <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="{{ $Carteira->CARTEIRASG }}" id="CARTEIRASG" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="CARTEIRASG"  required="required" type="text">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CARTEIRANM">Nome <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="{{ $Carteira->CARTEIRANM }}"  type="text" id="CARTEIRANM" name="CARTEIRANM" required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TPASID">TpAS <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" id="TPASID" name="TPASID" required="required">
                                                <option value=""></option>
                                                            @foreach($TPAS as $var)
                                                    <option value="{{$var->REGTABID}}" @if ($Carteira->TPASID === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="OBJCARTID">ObjCart<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" id="OBJCARTID" name="OBJCARTID" required="required">
                                                <option value=""></option>
                                                            @foreach($OBJCART as $var)
                                                    <option value="{{$var->REGTABID}}"  @if ($Carteira->OBJCARTID === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ORIGTRIBID">ORIGTRIB<span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="form-control" id="ORIGTRIBID" name="ORIGTRIBID" required="required">
                                                <option value=""></option>
                                                            @foreach($ORIGTRIB as $var)
                                                    <option value="{{$var->REGTABID}}"  @if ($Carteira->ORIGTRIBID === $var->REGTABID) selected @endif>{{$var->REGTABNM}}</option>             
                                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                                </form>
                            </div>
                        </div>
                </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        @include('admin.carteira.entcart.index');
                    </div>


                <div class="col-md-12 col-sm-12 col-xs-12">
                @include('admin.carteira.roteiro.index');
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12">
                    @include('admin.carteira.execrot.index');
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')

@endpush