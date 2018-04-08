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
                    <h3>Pessoa</h3>
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
                            <a class="btn btn-app" href="{{ route('evento.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Dados da Pessoa <small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <form class="form-horizontal form-label-left"    method="post" action="{{ route('pessoa.update',$Pessoa->PESSOAID) }}">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="item form-group ">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CARTEIRASG">Tipo
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="buttons">
                                        <label class="btn btn-default  @if ($Pessoa->PESSOAFJ === 'PF') active @endif ">
                                            <input type="radio" name="PESSOAFJ" id="PESSOAFJ_F" value="PF" @if ($Pessoa->PESSOAFJ === 'PF') checked @endif  > Física
                                        </label>
                                        <label class="btn btn-default @if ($Pessoa->PESSOAFJ === 'PJ') active @endif  ">
                                            <input type="radio" name="PESSOAFJ" id="PESSOAFJ_J"  value="PJ"  @if ($Pessoa->PESSOAFJ === 'PJ') checked @endif > Jurídica
                                        </label>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CPF_CNPJNR">CPF / CNPJ <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $Pessoa->CPF_CNPJNR }}" id="CPF_CNPJNR"  class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="CPF_CNPJNR"  required="required" type="text">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PESSOANMRS">Nome <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input value="{{ $Pessoa->PESSOANMRS }}"  type="text" id="PESSOANMRS" name="PESSOANMRS" required="required" class="form-control col-md-7 col-xs-12">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>
    <script>
        $("input[id*='CPF_CNPJNR']").inputmask({
            mask: ['999.999.999-99', '99.999.999/9999-99'],
            keepStatic: true
        });
    </script>
@endpush