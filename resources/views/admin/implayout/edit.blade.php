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
                    <h3>Layout</h3>
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
                            <a class="btn btn-app" href="{{ route('implayout.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados do Layout <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('implayout.update',$ImpLayout->LayoutId) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutSg">Sigla <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $ImpLayout->LayoutSg }}" id="LayoutSg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="LayoutSg"  required="required" type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutNm">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $ImpLayout->LayoutNm }}"  type="text" id="LayoutNm" name="LayoutNm" required="required" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="DiretorioDs">Diretório
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $ImpLayout->DiretorioDs }}"  type="text" id="DiretorioDs" name="DiretorioDs"  class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                {{--<div class="item form-group">--}}
                                    {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="LayoutTabela">Tabela BD <span class="required">*</span></label>--}}
                                    {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                                        {{--<select class="form-control" id="LayoutTabela" name="LayoutTabela" required="required">--}}
                                            {{--<option value=""></option>--}}
                                            {{--            @foreach($Tabelas as $var)--}}
                                                {{--<option value="{{$var->alias}}" @if ($ImpLayout->LayoutTabela === $var->alias) selected @endif>{{$var->nome}}</option>             --}}
                                                {{--            @endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                {{--</div>--}}


                                <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                            </form>
                        </div>
                    </div>
                    @include('admin.implayout.imparquivo.index');
                    @include('admin.implayout.impcampo.index');
                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
<script>
    function reloadCampo(element,tabela)
    {
        var FKCampo = $(element);
        FKCampo.empty();
        $.ajax({
            type: "get",
            dataType: 'json',
            url: "{{route("implayout.getcampos")}}",
            data: {
                'tabela': tabela,
                _token: '{!! csrf_token() !!}'
            },
            success: function(data){
                FKCampo.append('<option value=""></option>');
                $.each(data, function(i, d) {
                    FKCampo.append('<option value="' + d.coluna + '">' + d.coluna.toUpperCase() + '</option>');
                });
            }
        });
    }
</script>
@endpush