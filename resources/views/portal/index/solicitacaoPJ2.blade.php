@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Solicitar Acesso</div>
            <p class="pf-text-muted mb-4">Preencha as informações do fomulário abaixo para efetuar seu credenciamento.</p>

            <div class="row justify-content-between pt-lg-4 pb-lg-4 ">
                <div class="col-12 col-lg-8 mr-lg-4 card pf-border-light ">
                    <div class="card-body">
                        <div class="h6 text-center font-weight-bold pf-text-muted pt-3 pb-3">Informações de Contato</div>

                        <form role="form" method="POST" action="{{ route('portal.credenciais') }}" data-toggle="validator">
                            {{csrf_field()}}
                            {!! Form::hidden('pessoa_id', $pessoa->PESSOAID) !!}
                            <div class="form-group">
                                <label for="campo_cpf" class="pf-text-label">Tipo Endereço</label>
                                <select class="form-control" id="tipoend" name="tipoend" required="required">
                                    <option value="Residencial">Residencial</option>           
                                    <option value="Comercial">Comercial</option>                                                             
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cep" class="pf-text-label">CEP</label>
                                <input type="text" class="form-control pf-input-text cep" name="cep" id="cep" onchange="buscacep(this.value)"  required="required"  />
                            </div>
                            <div class="row form-group">
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <label for="logradouro" class="pf-text-label">Logradouro</label>
                                    <input type="text" class="form-control pf-input-text" name="logradouro"  readonly="true"   id="logradouro" />
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label for="numero" class="pf-text-label">Numero *</label>
                                    <input type="text" class="form-control pf-input-text" name="numero"  required="required"    id="numero" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="complemento" class="pf-text-label">Complemento</label>
                                    <input type="text" class="form-control pf-input-text" name="complemento"    id="complemento" />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="bairro" class="pf-text-label">Bairro</label>
                                    <input type="text" class="form-control pf-input-text" name="bairro" readonly="true"    id="bairro" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <label for="cidade" class="pf-text-label">Cidade</label>
                                    <input type="text" class="form-control pf-input-text" name="cidade"  readonly="true"   id="cidade" />
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <label for="uf" class="pf-text-label">Estado</label>
                                    <input type="text" class="form-control pf-input-text" name="uf"  readonly="true"   id="uf" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label for="uf" class="pf-text-label">Celular *</label>
                                    <input type="text" class="form-control pf-input-text" name="celular" id="celular"  required="required"  />
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label for="uf" class="pf-text-label">Residencial</label>
                                    <input type="text" class="form-control pf-input-text" name="residencial"   id="residencial" />
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <label for="uf" class="pf-text-label">Comercial</label>
                                    <input type="text" class="form-control pf-input-text" name="comercial" id="comercial" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="email" class="pf-text-label">E-mail *</label>
                                    <input type="email" class="form-control pf-input-text" name="email" id="email" required="required"   />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="cemail" class="pf-text-label">Confirmação E-mail *</label>
                                    <input type="email" class="form-control pf-input-text" name="cemail"  id="cemail" required="required" data-match="#email" data-match-error="E-mail diferente!"  />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="senha" class="pf-text-label">Senha *</label>
                                    <input type="password" class="form-control pf-input-text" name="senha" id="senha" required="required"  />
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label for="csenha" class="pf-text-label">Confirmação Senha *</label>
                                    <input type="password" class="form-control pf-input-text" name="csenha"  id="csenha" required="required" data-match="#senha" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label for="cidade" class="pf-text-label">Lembrete *</label>
                                    <input type="text" class="form-control pf-input-text" name="lembrete" id="lembrete" required="required"  />
                                </div>
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn pf-btn-primary text-white">Finalizar</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.js"></script>
    <script>

        $(".cep").inputmask({
            mask: ['99999-999'],
            keepStatic: true
        });
        $("#celular").inputmask({
            mask: ['(99)9 9999-9999'],
            keepStatic: true
        });
        $("#residencial").inputmask({
            mask: ['(99)9999-9999'],
            keepStatic: true
        });
        $("#comercial").inputmask({
            mask: ['(99)9999-9999'],
            keepStatic: true
        });
        function buscacep(cep) {
            $.ajax({
                method: "POST",
                url: "{{route('portal.cep')}}",
                data: { cep: cep, _token: '{!! csrf_token() !!}'}
            })
            .done(function( msg ) {
                var obj = $.parseJSON( msg);
                $('#logradouro').val(obj.logradouro);
                $('#bairro').val(obj.bairro);
                $('#cidade').val(obj.localidade);
                $('#uf').val(obj.uf);
            });
        }


        var email = document.getElementById("email")
            , confirm_email = document.getElementById("cemail");

        function validateEmail(){
            if( email.value != confirm_email.value) {
                confirm_email.setCustomValidity("E-mail não confere");
            } else {
                confirm_email.setCustomValidity('');
            }
        }

        email.onchange = validateEmail;
        confirm_email.onkeyup = validateEmail;


        var password = document.getElementById("senha")
            , confirm_password = document.getElementById("csenha");

        function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Senha não confere");
            } else {
                confirm_password.setCustomValidity('');
            }
        }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>
@endpush