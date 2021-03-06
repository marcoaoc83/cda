@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Solicitar Acesso</div>
            <p class="pf-text-muted mb-4">Preencha as informações do fomulário abaixo para efetuar seu credenciamento.</p>

            <div class="row justify-content-between pt-lg-4 pb-lg-4">
                <div class="col-12 col-lg-5 mr-lg-4 card pf-border-light">
                    <div class="card-body">
                        <div class="h6 text-center font-weight-bold pf-text-muted pt-3 pb-3">Formulário de Pessoa Física</div>

                        <form role="form" method="POST" action="{{ route('portal.solicitacaoSendPF') }}">
                            {{csrf_field()}}
                            {!! Form::hidden('soa_tipo', 'PF') !!}
                            <div class="form-group">
                                <label for="soa_documento" class="pf-text-label">CPF</label> <span class="required">*</span>
                                <input type="text" class="form-control pf-input-text cpf" name="soa_documento"  required="required"  id="soa_documento" />
                            </div>
                            <div class="form-group">
                                <label for="soa_nome" class="pf-text-label">Nome Completo</label> <span class="required">*</span>
                                <input type="text" class="form-control pf-input-text" name="soa_nome" id="soa_nome" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="soa_nome_mae" class="pf-text-label">Nome da Mãe</label> <span class="required">*</span>
                                <input type="text" class="form-control pf-input-text" name="soa_nome_mae"  required="required"  id="soa_nome_mae" />
                            </div>
                            <div class="form-group">
                                <label for="soa_data_nasc" class="pf-text-label">Data de Nascimento</label> <span class="required">*</span>
                                <input type="text" class="form-control pf-input-text data" name="soa_data_nasc"  data-validation="date" data-validation-format="dd/mm/yyyy"  required="required"  id="soa_data_nasc" />
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn pf-btn-primary text-white">Validar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-6 ml-lg-4 mt-lg-0 card pf-border-light mt-4 mb-0">
                    <div class="card-body">
                        <div class="h6 text-center font-weight-bold pf-text-muted pt-3 pb-3">Formulário de Pessoa Jurídica</div>
                        <form role="form" method="POST" action="{{ route('portal.solicitacaoSendPJ') }}">
                            {{csrf_field()}}
                            {!! Form::hidden('soa_tipo', 'PJ') !!}
                            <div class="form-group">
                                <label for="soa_documento" class="pf-text-label">CNPJ</label><span class="required">*</span>
                                <input type="text" class="form-control pf-input-text cnpj"  required="required" name="soa_documento"  id="soa_documento" />
                            </div>
                            <div class="form-group">
                                <label for="soa_nome" class="pf-text-label">Razão Social</label><span class="required">*</span>
                                <input type="text" class="form-control pf-input-text"  required="required" name="soa_nome" id="soa_nome" />
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn pf-btn-primary text-white">Validar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /page content -->
@endsection

@push('scripts')
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>
        $(".cpf").mask('999.999.999-99');
        $(".cnpj").mask('99.999.999/9999-99');
        $(".data").mask('99/99/9999');
        $.validate({
            lang: 'pt'
        });
    </script>
@endpush
