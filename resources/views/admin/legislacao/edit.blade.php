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
                    <h3>Legislação</h3>
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
                            <a class="btn btn-app" href="{{ route('legislacao.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"  enctype="multipart/form-data"   method="post" action="{{ route('legislacao.update',$Legislacao->leg_id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leg_titulo">Titulo <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{$Legislacao->leg_titulo }}" id="leg_titulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="leg_titulo"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="leg_descricao">Descrição <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $Legislacao->leg_descricao }}" id="leg_descricao" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="leg_descricao"  required="required" type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Arquivo</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">
                                        <div class="input-group input-file" name="leg_arquivo">
                                            <input type="text" value="{{ $Legislacao->leg_arquivo }}" name="leg_arquivoTmp" id="leg_arquivoTmp" class="form-control" />
                                            <span class="input-group-btn">
                                                <button class="btn btn-default btn-choose" type="button">...</button>
                                            </span>
                                        </div>

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
    <script>
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' accept='.doc, .docx, .txt, .pdf' class='input-ghost'  style='visibility:hidden; height:0'>");
                        element.attr("name",$(this).attr("name"));
                        element.change(function(){
                            element.next(element).find('input').val((element.val()).split('\\').pop());
                            element.next(element).find('input').prop('required',true);
                        });
                        $(this).find("button.btn-choose").click(function(){
                            element.click();
                        });
                        $(this).find("button.btn-reset").click(function(){
                            element.val(null);
                            $(this).parents(".input-file").find('input').val('');
                            $(this).parents(".input-file").find('input').prop('required',false);
                        });
                        $(this).find('input').css("cursor","pointer");
                        $(this).find('input').mousedown(function() {
                            $(this).parents('.input-file').prev().click();
                            return false;
                        });
                        return element;
                    }
                }
            );
        }

        $(function() {
            bs_input_file();
        });

    </script>

@endpush