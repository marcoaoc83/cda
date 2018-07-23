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

                        <form role="form" method="POST" action="{{ route('portal.solicitacaoSend') }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="campo_cpf" class="pf-text-label">CPF</label>
                                <input type="text" class="form-control pf-input-text cpf" name="soa_documento" id="soa_documento" />
                            </div>
                            <div class="form-group">
                                <label for="campo_nome_completo" class="pf-text-label">Nome Completo</label>
                                <input type="text" class="form-control pf-input-text" name="soa_nome" id="soa_nome" />
                            </div>
                            <div class="form-group">
                                <label for="campo_nome_mae" class="pf-text-label">Nome da Mãe</label>
                                <input type="text" class="form-control pf-input-text" name="soa_nome_mae"  id="soa_nome_mae" />
                            </div>
                            <div class="form-group">
                                <label for="campo_data_nascimento" class="pf-text-label">Data de Nascimento</label>
                                <input type="text" class="form-control pf-input-text data" name="soa_data_nasc"  id="soa_data_nasc" />
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn pf-btn-primary text-white">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-6 ml-lg-4 mt-lg-0 card pf-border-light mt-4 mb-0">
                    <div class="card-body">
                        <div class="h6 text-center font-weight-bold pf-text-muted pt-3 pb-3">Formulário de Pessoa Jurídica</div>
                        <form>
                            <div class="form-group">
                                <label for="campo_cnpj" class="pf-text-label">CNPJ</label>
                                <input type="text" class="form-control pf-input-text cnpj" id="campo_cnpj" />
                            </div>
                            <div class="form-group">
                                <label for="campo_razao_social" class="pf-text-label">Razão Social</label>
                                <input type="text" class="form-control pf-input-text" id="campo_razao_social" />
                            </div>
                            <div class="form-group">
                                <label for="campo_senha" class="pf-text-label">I.M.</label>
                                <input type="password" class="form-control pf-input-text" id="campo_senha" />
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn pf-btn-primary text-white">Enviar</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
    </script>

@endpush