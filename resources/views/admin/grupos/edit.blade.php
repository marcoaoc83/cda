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
                    <h3>Grupo</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <a class="btn btn-app" id="btnOut">
                                <i class="fa fa-save"></i> Salvar
                            </a>
                            <a class="btn btn-app" href="{{Request::url()}}">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                            <a class="btn btn-app" href="{{ route('grupos.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados do Grupo <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"  id="formEdit"   method="post" action="{{ route('grupos.update',$Grupos->fun_id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <input type="hidden" name="fun_menu_json" id="fun_menu_json" value="">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fun_nome">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $Grupos->fun_nome }}"  type="text" id="fun_nome" name="fun_nome" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin.grupos.menu.index');
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush