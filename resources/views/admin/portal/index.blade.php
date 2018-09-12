@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/css/bootstrap-colorpicker.min.css" />
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
                        <li role="presentation"><a data-toggle="tab" href="#4a">Boleto</a></li>
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
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Logo Topo </label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Lateral </label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 1  </label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 2  </label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 3  </label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 4  </label>
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
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutId">Banner Principal 5  </label>
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
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_boleto_nr_documento">CNPJ
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="@if(isset($Var->port_boleto_nr_documento)){{ $Var->port_boleto_nr_documento }}@endif" name="port_boleto_nr_documento"  id="port_boleto_nr_documento" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_boleto_agencia">Agencia
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="@if(isset($Var->port_boleto_agencia)){{ $Var->port_boleto_agencia }}@endif" name="port_boleto_agencia"  id="port_boleto_agencia" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="port_boleto_codigo_cliente">Código Cliente
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input value="@if(isset($Var->port_boleto_codigo_cliente)){{ $Var->port_boleto_codigo_cliente }}@endif" name="port_boleto_codigo_cliente"  id="port_boleto_codigo_cliente" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">
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

@endpush