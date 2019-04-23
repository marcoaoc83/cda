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
                    <h3>Relatório</h3>
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
                            <a class="btn btn-app" href="{{ route('relatorios.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados do Relatorio <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('relatorios.update',$Relatorio->rel_id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rel_titulo">Titulo <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $Relatorio->rel_titulo }}"  type="text" id="rel_titulo" name="rel_titulo" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rel_saida">Saída - Modelo</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" id="rel_saida" name="rel_saida">
                                            @foreach($Tipo as $var)
                                                <option value="{{$var->ModComId}}">{{($var->ModComNm)}}</option>             
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 "  >
                                    <div class="x_panel" id="filExecucao">
                                        <div class="x_title">
                                            <h2>Execução de Fila<small></small></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li>
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <div class="item form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_carteira">Carteira
                                                </label>
                                                <div class="col-md-7" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_carteira" name="filtro_carteira"  @if ($Relatorio->filtro_carteira ==1) checked @endif  value="1" class="js-switch" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_roteiro">Roteiro
                                                </label>
                                                <div class="col-md-7" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_roteiro" name="filtro_roteiro" @if ($Relatorio->filtro_roteiro ==1) checked @endif value="1" class="js-switch" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_contribuinte">Contribuinte
                                                </label>
                                                <div class="col-md-7" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_contribuinte" name="filtro_contribuinte" @if($Relatorio->filtro_contribuinte ==1)checked @endif value="1" class="js-switch" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-5 col-sm-5 col-xs-12" for="filtro_parcelas">Parcela
                                                </label>
                                                <div class="col-md-7" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_parcelas" name="filtro_parcelas" @if($Relatorio->filtro_parcelas ==1)checked @endif value="1" class="js-switch" >
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 "  >
                                    <div class="x_panel" id="filHigiene">
                                        <div class="x_title">
                                            <h2>Filtros de Cadastro<small></small></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li>
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="item form-group">
                                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="filtro_canal">Canal
                                                </label>
                                                <div class="col-md-4" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_canal" name="filtro_canal"  value="1" class="js-switch" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="filtro_validacao">Validação de Envio
                                                </label>
                                                <div class="col-md-4" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_validacao" name="filtro_validacao"  value="1" class="js-switch" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="filtro_eventos">Eventos Possíveis
                                                </label>
                                                <div class="col-md-4" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_eventos" name="filtro_eventos"  value="1" class="js-switch"  >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="filtro_tratamento">Tratamento de Retorno
                                                </label>
                                                <div class="col-md-4" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_tratamento" name="filtro_tratamento"  value="1" class="js-switch"   >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-8 col-sm-8 col-xs-12" for="filtro_notificacao">Notificação
                                                </label>
                                                <div class="col-md-4" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="filtro_notificacao" name="filtro_notificacao"  value="1" class="js-switch"   >
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12 "  >
                                    <div class="x_panel" id="filResultado">
                                        <div class="x_title">
                                            <h2>Resultado<small></small></h2>
                                            <ul class="nav navbar-right panel_toolbox">
                                                <li>
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">

                                            <div class="item form-group">
                                                <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_contribuinte">Contribuinte
                                                </label>
                                                <div class="col-md-3" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="resultado_contribuinte" name="resultado_contribuinte" @if($Relatorio->resultado_contribuinte ==1)checked @endif value="1" class=" unic" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_im">Insc. Municipal
                                                </label>
                                                <div class="col-md-3" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="resultado_im" name="resultado_im" @if($Relatorio->resultado_im ==1)checked @endif value="1" class=" unic" >
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-9 col-sm-9 col-xs-12" for="resultado_parcelas">Parcelas
                                                </label>
                                                <div class="col-md-3" style="margin-top: 5px">
                                                    <label style="">
                                                        <input type="checkbox" id="resultado_parcelas" name="resultado_parcelas" @if($Relatorio->resultado_parcelas ==1)checked @endif value="1" class=" unic" >
                                                    </label>
                                                </div>
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
        var $switchers = [];
        //var elems = Array.prototype.slice.call();
        $.each(document.querySelectorAll('.unic'),function(i,html) {
            $switchers[html.name] = new Switchery(html);
        });

        $('input.unic').on('change', function () {
            if (this.checked) {
                $.each(document.querySelectorAll('input.unic:not([name="' + this.name + '"])'),
                    function (i, e) {
                        switcherySetChecked($switchers[e.name], false)
                    });
            }
        });
        function switcherySetChecked(switcher, check) {
            var curr = $(switcher.element).prop('checked');
            var disabled = $(switcher.element).prop('disabled');
            if (disabled) {
                switcher.enable();
            }
            if (check) {
                if (curr) {
                    $(switcher.element).prop('checked',false);
                }
                $(switcher.element).trigger('click');
            } else {
                if (!curr) {
                    $(switcher.element).prop('checked', true);
                }
                $(switcher.element).trigger('click');
            }
            if (disabled) {
                switcher.disable();
            }
        }
    </script>
@endpush