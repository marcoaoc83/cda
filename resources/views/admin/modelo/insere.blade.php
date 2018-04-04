@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.css"></link>
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
                    <h3>Modelo de Comunicação</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <form class="form-horizontal form-label-left"    method="post" action="{{ route('modelo.inserirPost') }}">
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
                            <h2>Dados do Modelo <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">


                                {{ csrf_field() }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('ModComSG') }}" id="ModComSG" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="ModComSg"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ModComNM">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ old('ModComNM') }}"  type="text" id="ModComNM" name="ModComNm" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Tipo de Modelo</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="TpModId" name="TpModId">
                                            <option value=""></option>
                                            @foreach($tipoModelo as $modelo)
                                                <option value="{{$modelo->REGTABID}}">{{$modelo->REGTABNM}}</option>             
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Canal</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="CanalId" name="CanalId">
                                            <option value=""></option>
                                                        @foreach($canais as $canal)
                                                <option value="{{$canal->CANALID}}">{{$canal->CANALNM}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Modelo Anexo</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="ModComAnxId" name="ModComAnxId">
                                            <option value=""></option>
                                                        @foreach($cda_modcom as $modelo)
                                                <option value="{{$modelo->ModComId}}">{{$modelo->ModComNm}}</option>             
                                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Texto</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <textarea name="ModTexto" id="ModTexto" rows="20" class="resizable_textarea form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
    </script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=isjq7cqbipdtr3ubdw2gbrebsw72dyio7qj00lnza0453uxb"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
@endpush