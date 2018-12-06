@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/css/bootstrap-colorpicker.min.css" />
    <!-- Include Editor style. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/css/froala_style.min.css" rel="stylesheet" type="text/css" />
    <style>
        .fr-wrapper>div>a { display: none!important; }
    </style>
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
                    <h3>Portal - Configuração</h3>
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
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a data-toggle="tab" href="#1a">Dados</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#2a">Banners</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#3a">Cores</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#4a">Icones</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#5a">Como Funciona</a></li>

                    </ul>
                    <div class="x_panel">
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"  novalidate  method="post" action="{{ route('portal.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="tab-content">

                                <div class="row tab-pane active" id="1a">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_titulo">Titulo
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="@if(isset($Var->port_titulo)){{ $Var->port_titulo }}@endif" name="port_titulo"  id="port_titulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Logo Topo (400 x 100) </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                            <div class="input-group input-file" name="port_logo_topo">
                                                <input type="text" value="@if(isset($Var->port_logo_topo)){{ $Var->port_logo_topo }}@endif" name="port_logo_topoTmp" id="port_logo_topoTmp" class="form-control" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                            </div>

                                        </div>
                                        <i class="fa fa-close" onclick="$('#port_logo_topoTmp').val('')" style="cursor: pointer"></i>
                                    </div>


                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Logo Rodapé </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                            <div class="input-group input-file" name="port_logo_rodape">
                                                <input type="text" value="@if(isset($Var->port_logo_rodape)){{ $Var->port_logo_rodape }}@endif" name="port_logo_rodapeTmp" id="port_logo_rodapeTmp" class="form-control" />
                                                <span class="input-group-btn">
                                                        <button class="btn btn-default btn-choose" type="button">...</button>
                                                    </span>
                                            </div>

                                        </div>
                                        <i class="fa fa-close" onclick="$('#port_logo_rodapeTmp').val('')" style="cursor: pointer"></i>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_endereco">Endereço
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="port_endereco"  id="port_endereco"  class="resizable_textarea form-control" placeholder="">@if(isset($Var->port_endereco)){{ $Var->port_endereco }}@endif</textarea>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_horario">Horário
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="port_horario"  id="port_horario"  class="resizable_textarea form-control" placeholder="">@if(isset($Var->port_horario)){{ $Var->port_horario }}@endif</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row tab-pane" id="2a">
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Lateral (500 x 500)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                            <div class="input-group input-file" name="port_banner_lateral">
                                                <input type="text" value="@if(isset($Var->port_banner_lateral)){{ $Var->port_banner_lateral }}@endif" name="port_banner_lateralTmp" id="port_banner_lateralTmp" class="form-control" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                            </div>
                                    </div>
                                    <i class="fa fa-close" onclick="$('#port_banner_lateralTmp').val('')" style="cursor: pointer"></i>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 1 (1200 X 400) </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                        <div class="input-group input-file" name="port_banner1">
                                            <input type="text"  name="port_banner1Tmp"  id="port_banner1Tmp" value="@if(isset($Var->port_banner1)){{ $Var->port_banner1 }}@endif" class="form-control" />
                                            <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                        </div>

                                    </div>
                                    <i class="fa fa-close" onclick="$('#port_banner1Tmp').val('')" style="cursor: pointer"></i>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 2  (1200 X 400)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                        <div class="input-group input-file"   name="port_banner2">
                                            <input type="text"  name="port_banner2Tmp"  id="port_banner2Tmp"  value="@if(isset($Var->port_banner2)){{ $Var->port_banner2 }}@endif"  class="form-control" />
                                            <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                        </div>

                                    </div>
                                    <i class="fa fa-close" onclick="$('#port_banner2Tmp').val('')" style="cursor: pointer"></i>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 3  (1200 X 400)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                        <div class="input-group input-file"  name="port_banner3">
                                            <input type="text"  name="port_banner3Tmp"  id="port_banner3Tmp"  value="@if(isset($Var->port_banner3)){{ $Var->port_banner3 }}@endif"   class="form-control" />
                                            <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                        </div>

                                    </div>
                                    <i class="fa fa-close" onclick="$('#port_banner3Tmp').val('')" style="cursor: pointer"></i>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 4 (1200 X 400)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                        <div class="input-group input-file"  name="port_banner4">
                                            <input type="text"  name="port_banner4Tmp"  id="port_banner4Tmp"   value="@if(isset($Var->port_banner4)){{ $Var->port_banner4 }}@endif"  class="form-control" />
                                            <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                        </div>

                                    </div>
                                    <i class="fa fa-close" onclick="$('#port_banner4Tmp').val('')" style="cursor: pointer"></i>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 5 (1200 X 400)</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                        <div class="input-group input-file"   name="port_banner5">
                                            <input type="text"  name="port_banner5Tmp"  id="port_banner5Tmp"  value="@if(isset($Var->port_banner5)){{ $Var->port_banner5 }}@endif"  class="form-control" />
                                            <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                        </div>

                                    </div>
                                    <i class="fa fa-close" onclick="$('#port_banner5Tmp').val('')" style="cursor: pointer"></i>
                                </div>
                                </div>
                                <div class="row tab-pane" id="3a">
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor">Site - Cor Fundo
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div id="cp2" class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor" id="port_cor" class="form-control "  value="{{ $Var->port_cor }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_letra">Site - Cor Letra
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_letra" id="port_cor_letra" class="form-control "  value="{{ $Var->port_cor_letra }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_menu1">Menu - Cor Fundo
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_menu1" id="port_cor_menu1" class="form-control "  value="{{ $Var->port_cor_menu1 }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_menu2">Menu - Cor Borda
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_menu2" id="port_cor_menu2" class="form-control" value="{{ $Var->port_cor_menu2 }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_menu_letra">Menu - Cor Letra
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_menu_letra" id="port_cor_menu_letra" class="form-control"  value="{{ $Var->port_cor_menu_letra }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_rodape1">Rodapé - Cor Fundo 1
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_rodape1" id="port_cor_rodape1" class="form-control "  value="{{ $Var->port_cor_rodape1 }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_rodape2">Rodapé - Cor Fundo 2
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_rodape2" id="port_cor_rodape2" class="form-control "  value="{{ $Var->port_cor_rodape2 }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_cor_rodape_letra">Rodapé - Cor Letra
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div  class="input-group colorpicker-component colorpicker" title="">
                                                <input type="text" name="port_cor_rodape_letra" id="port_cor_rodape_letra" class="form-control "  value="{{ $Var->port_cor_rodape_letra }}"/>
                                                <span class="input-group-addon"><i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row tab-pane" id="4a">
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_icone_top">Icone Site </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                                <div class="input-group input-file" name="port_icone_top">
                                                    <input type="text" value="@if(isset($Var->port_icone_top)){{ $Var->port_icone_top }}@endif" name="port_icone_topTmp" id="port_icone_topTmp" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                                </div>

                                            </div>
                                            <i class="fa fa-close" onclick="$('#port_icone_topTmp').val('')" style="cursor: pointer"></i>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_icone_1">Icone - Debitos (56 x 56)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                                <div class="input-group input-file" name="port_icone_1">
                                                    <input type="text" value="@if(isset($Var->port_icone_1)){{ $Var->port_icone_1 }}@endif" name="port_icone_1Tmp" id="port_icone_1Tmp" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                                </div>

                                            </div>
                                            <i class="fa fa-close" onclick="$('#port_icone_1Tmp').val('')" style="cursor: pointer"></i>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_icone_2">Icone - Guia (56 x 56)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                                <div class="input-group input-file" name="port_icone_2">
                                                    <input type="text" value="@if(isset($Var->port_icone_2)){{ $Var->port_icone_2 }}@endif" name="port_icone_2Tmp" id="port_icone_2Tmp" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                                </div>

                                            </div>
                                            <i class="fa fa-close" onclick="$('#port_icone_2Tmp').val('')" style="cursor: pointer"></i>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_icone_3">Icone - Parcelamento (56 x 56)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                                <div class="input-group input-file" name="port_icone_3">
                                                    <input type="text" value="@if(isset($Var->port_icone_3)){{ $Var->port_icone_3 }}@endif" name="port_icone_3Tmp" id="port_icone_3Tmp" class="form-control" />
                                                    <span class="input-group-btn">
                                                    <button class="btn btn-default btn-choose" type="button">...</button>
                                                </span>
                                                </div>

                                            </div>
                                            <i class="fa fa-close" onclick="$('#port_icone_3Tmp').val('')" style="cursor: pointer"></i>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_icone_4">Icone - Dúvidas (56 x 56)</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12" style="height: 35px;">

                                                <div class="input-group input-file" name="port_icone_4">
                                                    <input type="text" value="@if(isset($Var->port_icone_4)){{ $Var->port_icone_4 }}@endif" name="port_icone_4Tmp" id="port_icone_4Tmp" class="form-control" />
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default btn-choose" type="button">...</button>
                                                    </span>
                                                </div>

                                            </div>
                                            <i class="fa fa-close" onclick="$('#port_icone_4Tmp').val('')" style="cursor: pointer"></i>
                                        </div>
                                    </div>
                                    <div class="row tab-pane" id="5a">
                                        <div class="item form-group">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <textarea name="port_como_funciona" id="port_como_funciona" rows="40" style="height: 300px" class="resizable_textarea form-control">{{$Var->port_como_funciona}}</textarea>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $(function () {
            $('.colorpicker').colorpicker();
        });
        function bs_input_file() {
            $(".input-file").before(
                function() {
                    if ( ! $(this).prev().hasClass('input-ghost') ) {
                        var element = $("<input type='file' accept='.png, .svg, .gif, .jpg, .jpeg' class='input-ghost'  required=\"required\" style='visibility:hidden; height:0'>");
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
    <!-- Include Editor JS files. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>
    <script>

        (function (global, factory) {
            typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('FroalaEditor')) :
                typeof define === 'function' && define.amd ? define(['FroalaEditor'], factory) :
                    (factory(global.$.FroalaEditor));
        }(this, (function (FE) { 'use strict';

            FE = FE && FE.hasOwnProperty('default') ? FE['default'] : FE;

            /**
             * Portuguese spoken in Brazil
             */

            FE.LANGUAGE['pt_br'] = {
                translation: {
                    // Place holder
                    "Type something": "Digite algo",

                    // Basic formatting
                    "Bold": "Negrito",
                    "Italic": 'It\xE1lico',
                    "Underline": "Sublinhar",
                    "Strikethrough": "Riscar",

                    // Main buttons
                    "Insert": "Inserir",
                    "Delete": "Apagar",
                    "Cancel": "Cancelar",
                    "OK": "Ok",
                    "Back": "Voltar",
                    "Remove": "Remover",
                    "More": "Mais",
                    "Update": "Atualizar",
                    "Style": "Estilo",

                    // Font
                    "Font Family": "Fonte",
                    "Font Size": "Tamanho",

                    // Colors
                    "Colors": "Cores",
                    "Background": "Fundo",
                    "Text": "Texto",
                    "HEX Color": "Cor hexadecimal",

                    // Paragraphs
                    "Paragraph Format": "Formatos",
                    "Normal": "Normal",
                    "Code": 'C\xF3digo',
                    "Heading 1": 'Cabe\xE7alho 1',
                    "Heading 2": 'Cabe\xE7alho 2',
                    "Heading 3": 'Cabe\xE7alho 3',
                    "Heading 4": 'Cabe\xE7alho 4',

                    // Style
                    "Paragraph Style": 'Estilo de par\xE1grafo',
                    "Inline Style": "Estilo embutido",

                    // Alignment
                    "Align": "Alinhar",
                    "Align Left": 'Alinhar \xE0 esquerda',
                    "Align Center": "Centralizar",
                    "Align Right": 'Alinhar \xE0 direita',
                    "Align Justify": "Justificar",
                    "None": "Nenhum",

                    // Lists
                    "Ordered List": "Lista ordenada",
                    "Unordered List": 'Lista n\xE3o ordenada',

                    // Indent
                    "Decrease Indent": "Diminuir recuo",
                    "Increase Indent": "Aumentar recuo",

                    // Links
                    "Insert Link": "Inserir link",
                    "Open in new tab": "Abrir em uma nova aba",
                    "Open Link": "Abrir link",
                    "Edit Link": "Editar link",
                    "Unlink": "Remover link",
                    "Choose Link": "Escolha o link",

                    // Images
                    "Insert Image": "Inserir imagem",
                    "Upload Image": "Carregar imagem",
                    "By URL": "Por URL",
                    "Browse": "Procurar",
                    "Drop image": "Arraste sua imagem aqui",
                    "or click": "ou clique aqui",
                    "Manage Images": "Gerenciar imagens",
                    "Loading": "Carregando",
                    "Deleting": "Excluindo",
                    "Tags": "Etiquetas",
                    "Are you sure? Image will be deleted.": 'Voc\xEA tem certeza? Imagem ser\xE1 apagada.',
                    "Replace": "Substituir",
                    "Uploading": "Carregando imagem",
                    "Loading image": "Carregando imagem",
                    "Display": "Exibir",
                    "Inline": "Em linha",
                    "Break Text": "Texto de quebra",
                    "Alternate Text": "Texto alternativo",
                    "Change Size": "Alterar tamanho",
                    "Width": "Largura",
                    "Height": "Altura",
                    "Something went wrong. Please try again.": "Algo deu errado. Por favor, tente novamente.",
                    "Image Caption": "Legenda da imagem",
                    "Advanced Edit": "Edição avançada",

                    // Video
                    "Insert Video": 'Inserir v\xEDdeo',
                    "Embedded Code": 'C\xF3digo embutido',
                    "Paste in a video URL": "Colar em um URL de vídeo",
                    "Drop video": "Solte o video",
                    "Your browser does not support HTML5 video.": "Seu navegador não suporta o vídeo html5.",
                    "Upload Video": "Envio vídeo",

                    // Tables
                    "Insert Table": "Inserir tabela",
                    "Table Header": 'Cabe\xE7alho da tabela',
                    "Remove Table": "Remover tabela",
                    "Table Style": "estilo de tabela",
                    "Horizontal Align": "Alinhamento horizontal",
                    "Row": "Linha",
                    "Insert row above": "Inserir linha antes",
                    "Insert row below": "Inserir linha depois",
                    "Delete row": "Excluir linha",
                    "Column": "Coluna",
                    "Insert column before": "Inserir coluna antes",
                    "Insert column after": "Inserir coluna depois",
                    "Delete column": "Excluir coluna",
                    "Cell": 'C\xE9lula',
                    "Merge cells": 'Agrupar c\xE9lulas',
                    "Horizontal split": 'Divis\xE3o horizontal',
                    "Vertical split": 'Divis\xE3o vertical',
                    "Cell Background": 'Fundo da c\xE9lula',
                    "Vertical Align": "Alinhamento vertical",
                    "Top": "Topo",
                    "Middle": "Meio",
                    "Bottom": "Fundo",
                    "Align Top": "Alinhar topo",
                    "Align Middle": "Alinhar meio",
                    "Align Bottom": "Alinhar fundo",
                    "Cell Style": 'Estilo de c\xE9lula',

                    // Files
                    "Upload File": "Upload de arquivo",
                    "Drop file": "Arraste seu arquivo aqui",

                    // Emoticons
                    "Emoticons": "Emoticons",
                    "Grinning face": "Sorrindo a cara",
                    "Grinning face with smiling eyes": "Sorrindo rosto com olhos sorridentes",
                    "Face with tears of joy": 'Rosto com l\xE1grimas de alegria',
                    "Smiling face with open mouth": "Rosto de sorriso com a boca aberta",
                    "Smiling face with open mouth and smiling eyes": "Rosto de sorriso com a boca aberta e olhos sorridentes",
                    "Smiling face with open mouth and cold sweat": "Rosto de sorriso com a boca aberta e suor frio",
                    "Smiling face with open mouth and tightly-closed eyes": "Rosto de sorriso com a boca aberta e os olhos bem fechados",
                    "Smiling face with halo": "Rosto de sorriso com halo",
                    "Smiling face with horns": "Rosto de sorriso com chifres",
                    "Winking face": "Pisc a rosto",
                    "Smiling face with smiling eyes": "Rosto de sorriso com olhos sorridentes",
                    "Face savoring delicious food": "Rosto saboreando uma deliciosa comida",
                    "Relieved face": "Rosto aliviado",
                    "Smiling face with heart-shaped eyes": 'Rosto de sorriso com os olhos em forma de cora\xE7\xE3o',
                    "Smiling face with sunglasses": 'Rosto de sorriso com \xF3culos de sol',
                    "Smirking face": "Rosto sorridente",
                    "Neutral face": "Rosto neutra",
                    "Expressionless face": "Rosto inexpressivo",
                    "Unamused face": 'O rosto n\xE3o divertido',
                    "Face with cold sweat": "Rosto com suor frio",
                    "Pensive face": "O rosto pensativo",
                    "Confused face": "Cara confusa",
                    "Confounded face": 'Rosto at\xF4nito',
                    "Kissing face": "Beijar Rosto",
                    "Face throwing a kiss": "Rosto jogando um beijo",
                    "Kissing face with smiling eyes": "Beijar rosto com olhos sorridentes",
                    "Kissing face with closed eyes": "Beijando a cara com os olhos fechados",
                    "Face with stuck out tongue": 'Preso de cara com a l\xEDngua para fora',
                    "Face with stuck out tongue and winking eye": 'Rosto com estendeu a l\xEDngua e olho piscando',
                    "Face with stuck out tongue and tightly-closed eyes": "Rosto com estendeu a língua e os olhos bem fechados",
                    "Disappointed face": "Rosto decepcionado",
                    "Worried face": "O rosto preocupado",
                    "Angry face": "Rosto irritado",
                    "Pouting face": "Beicinho Rosto",
                    "Crying face": "Cara de choro",
                    "Persevering face": "Perseverar Rosto",
                    "Face with look of triumph": "Rosto com olhar de triunfo",
                    "Disappointed but relieved face": "Fiquei Desapontado mas aliviado Rosto",
                    "Frowning face with open mouth": "Sobrancelhas franzidas rosto com a boca aberta",
                    "Anguished face": "O rosto angustiado",
                    "Fearful face": "Cara com medo",
                    "Weary face": "Rosto cansado",
                    "Sleepy face": "Cara de sono",
                    "Tired face": "Rosto cansado",
                    "Grimacing face": "Fazendo caretas face",
                    "Loudly crying face": "Alto chorando rosto",
                    "Face with open mouth": "Enfrentar com a boca aberta",
                    "Hushed face": "Flagrantes de rosto",
                    "Face with open mouth and cold sweat": "Enfrentar com a boca aberta e suor frio",
                    "Face screaming in fear": "Cara gritando de medo",
                    "Astonished face": "Cara de surpresa",
                    "Flushed face": "Rosto vermelho",
                    "Sleeping face": "O rosto de sono",
                    "Dizzy face": "Cara tonto",
                    "Face without mouth": "Rosto sem boca",
                    "Face with medical mask": 'Rosto com m\xE1scara m\xE9dica',

                    // Line breaker
                    "Break": "Quebrar",

                    // Math
                    "Subscript": "Subscrito",
                    "Superscript": "Sobrescrito",

                    // Full screen
                    "Fullscreen": "Tela cheia",

                    // Horizontal line
                    "Insert Horizontal Line": "Inserir linha horizontal",

                    // Clear formatting
                    "Clear Formatting": 'Remover formata\xE7\xE3o',

                    // Undo, redo
                    "Undo": "Desfazer",
                    "Redo": "Refazer",

                    // Select all
                    "Select All": "Selecionar tudo",

                    // Code view
                    "Code View": 'Exibi\xE7\xE3o de c\xF3digo',

                    // Quote
                    "Quote": 'Cita\xE7\xE3o',
                    "Increase": "Aumentar",
                    "Decrease": "Diminuir",

                    // Quick Insert
                    "Quick Insert": 'Inser\xE7\xE3o r\xE1pida',

                    // Spcial Characters
                    "Special Characters": "Caracteres especiais",
                    "Latin": "Latino",
                    "Greek": "Grego",
                    "Cyrillic": "Cirílico",
                    "Punctuation": "Pontuação",
                    "Currency": "Moeda",
                    "Arrows": "Setas; flechas",
                    "Math": "Matemática",
                    "Misc": "Misc",

                    // Print.
                    "Print": "Impressão",

                    // Spell Checker.
                    "Spell Checker": "Verificador ortográfico",

                    // Help
                    "Help": "Socorro",
                    "Shortcuts": "Atalhos",
                    "Inline Editor": "Editor em linha",
                    "Show the editor": "Mostre o editor",
                    "Common actions": "Ações comuns",
                    "Copy": "Cópia de",
                    "Cut": "Cortar",
                    "Paste": "Colar",
                    "Basic Formatting": "Formatação básica",
                    "Increase quote level": "Aumentar o nível de cotação",
                    "Decrease quote level": "Diminuir o nível de cotação",
                    "Image / Video": "Imagem / video",
                    "Resize larger": "Redimensionar maior",
                    "Resize smaller": "Redimensionar menor",
                    "Table": "Tabela",
                    "Select table cell": "Selecione a célula da tabela",
                    "Extend selection one cell": "Ampliar a seleção de uma célula",
                    "Extend selection one row": "Ampliar a seleção uma linha",
                    "Navigation": "Navegação",
                    "Focus popup / toolbar": "Foco popup / barra de ferramentas",
                    "Return focus to previous position": "Retornar o foco para a posição anterior",

                    // Embed.ly
                    "Embed URL": "URL de inserção",
                    "Paste in a URL to embed": "Colar em url para incorporar",

                    // Word Paste.
                    "The pasted content is coming from a Microsoft Word document. Do you want to keep the format or clean it up?": "O conteúdo colado vem de um documento Microsoft Word. Você quer manter o formato ou limpá-lo?",
                    "Keep": "Guarda",
                    "Clean": "Limpar \ limpo",
                    "Word Paste Detected": "Pasta de palavras detectada"
                },
                direction: "ltr"
            };

        })));
        $('#port_como_funciona').froalaEditor({
            language: 'pt_br',
            height: 300,
            imageUploadURL: '{{url("/admin/uploadfroala/")}}'
        });
        </script>
@endpush