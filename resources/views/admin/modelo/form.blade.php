@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet">
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

            <div class="row">
                <form class="form-horizontal form-label-left"    method="post" action="{{ route('modelo.editarPost',$modelo->ModComId) }}">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <a class="btn btn-app" onclick="$('#send').trigger('click')">
                                <i class="fa fa-save"></i> Salvar
                            </a>
                            <a class="btn btn-app" href="{{Request::url()}}">
                                <i class="fa fa-repeat"></i> Atualizar
                            </a>
                            <a class="btn btn-app" href="{{ route('admin.modelo') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
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
                                    <input value="{{$modelo->ModComSg}}" maxlength="10" id="ModComSG" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="ModComSg"  required="required" type="text">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ModComNM">Nome <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input value="{{$modelo->ModComNm}}"  type="text" id="ModComNM" name="ModComNm" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Tipo de Modelo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="TpModId" name="TpModId">
                                        <option value=""></option>
                                                    @foreach($tipoModelo as $tmodelo)
                                            <option value="{{$tmodelo->REGTABID}}" @if ($tmodelo->REGTABID === $modelo->TpModId) selected @endif>{{$tmodelo->REGTABNM}}</option>             
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
                                            <option value="{{$canal->CANALID}}" @if ($canal->CANALID === $modelo->CanalId) selected @endif>{{$canal->CANALNM}}</option>             
                                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpModId">Modelo Anexo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="form-control" id="ModComAnxId" name="ModComAnxId">
                                        <option value=""></option>
                                        @foreach($cda_modcom as $modeloc)
                                            <option value="{{$modeloc->ModComId}}" @if ($modeloc->ModComId === $modelo->ModComAnxId) selected @endif>{{$modeloc->ModComNm}}</option>             
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
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <textarea name="ModTexto" id="ModTexto" rows="20" class="resizable_textarea form-control">{{$modelo->ModTexto}}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('admin.modelo.var.index');
                </div>

                </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="{{url('tinymce/jquery.tinymce.min.js')}}"></script>
    <script src="{{ url('tinymce/tinymce.min.js') }}"></script>
    <script>tinymce.init({
            selector: 'textarea',
            theme: 'modern',
            plugins: 'print preview fullpage searchreplace autolink directionality  visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount   imagetools    contextmenu colorpicker textpattern help',
            toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
            image_advtab: true,
            language_url : "{{ url('tinymce/pt_BR.js') }}",
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ],
            image_title: true,
            automatic_uploads: true,
            images_upload_url: '{{url("/admin/uploadtinymce/")}}',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {

                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                };
                input.click();
            }
        });

        function reloadCampo(element,tabela)
        {
            var FKCampo = $(element);
            FKCampo.empty();
            FKCampo.append('<option value="">Carregando...</option>');
            $.ajax({
                type: "get",
                dataType: 'json',
                url: "{{route("implayout.getcampos")}}",
                data: {
                    'tabela': tabela,
                    _token: '{!! csrf_token() !!}'
                },
                success: function(data){
                    FKCampo.empty();
                    FKCampo.append('<option value=""></option>');
                    $.each(data, function(i, d) {
                        FKCampo.append('<option value="' + d.coluna + '">' + d.coluna.toUpperCase() + '</option>');
                    });
                }
            });
        }

    </script>
@endpush