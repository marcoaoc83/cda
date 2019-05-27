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
                    <h3>Importação</h3>
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
                            <h2>Importação<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('importacao.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="item form-group" id="divLayout">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId" >Layout <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="LayoutId" name="LayoutId" required="required" onchange="montaArquivo(this.value)">
                                            <option value=""></option>
                                                @foreach($Layout as $var)
                                                    <option value="{{$var->LayoutId}}">{{$var->LayoutNm}}</option>             
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="item form-group" id="divLayout">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ArquivoId" >Layout Arquivo<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="ArquivoId" name="ArquivoId" required="required">
                                        </select>
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Arquivo <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <div class="input-group input-file" name="imp_arquivo">
                                                <input type="text" required="required"  class="form-control" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                            </div>
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
                        var element = $("<input type='file' accept='.csv, .txt, .xml' class='input-ghost'  required=\"required\" style='visibility:hidden; height:0'>");
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
        function montaArquivo(LayoutId) {
            $('#ArquivoId').children().remove();
            $('#ArquivoId').append($('<option>', {value:'', text:'Carregando...'}));
            $.ajax({
                dataType: 'json',
                type: 'POST',
                data: {
                    _token: '{!! csrf_token() !!}',
                    LayoutId:LayoutId,
                    _method: 'POST'
                },
                url: '{{ url('admin/implayout/montaarquivo/') }}',
                success: function (retorno) {
                    $('#ArquivoId').children().remove();
                    if(retorno) {
                        var arquivos = JSON.parse(JSON.stringify(retorno));
                        $('#ArquivoId').append($('<option>', {value:'', text:''}));
                        $.each(arquivos, function( index, value ) {
                            $('#ArquivoId').append($('<option>', {value:value['ArquivoId'], text:value['ArquivoDs']}));
                        });
                    }
                },
                error: function (retorno) {
                    console.log(retorno);
                }
            });
        }
    </script>

@endpush