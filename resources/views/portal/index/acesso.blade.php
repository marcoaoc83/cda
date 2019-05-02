@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Área de Acesso</div>
            <p class="pf-text-muted mb-4">Realize o login. Visualize seus débitos. Regularize sua vida.</p>

            <div class="row justify-content-center pt-lg-4 pb-lg-4">
                <div class="col-12 col-lg-6 card pf-border-light">
                    <div class="card-body">
                        <form role="form" method="POST" action="{{ url('/acesso-login') }}">
                            {{csrf_field()}}
                            @if(session()->has('login_error'))
                                <div class="alert alert-success">
                                    {{ session()->get('login_error') }}
                                </div>
                                <span style="display: none">
                                    {{ session()->remove('login_error') }}
                                </span>
                            @endif
                            <div class="text-center mb-5 mt-4"><img src="{{asset('images/portal/ico-area-de-acesso.svg')}}" alt="" /></div>
                            <div class="form-group">
                                <label for="documento" class="pf-text-label">CPF / CNPJ</label>
                                <input type="text" class="form-control pf-input-text" name="documento" value="{{ old('documento') }}"  required="required" id="documento" />
                            </div>
                            <div class="form-group">
                                <label for="password" class="pf-text-label">Senha</label>
                                <input type="password" class="form-control pf-input-text data" name="password" id="password" required="required"  />
                            </div>
                            <div class="text-center mt-4 mb-2">
                                <button type="submit" class="btn pf-btn-primary text-white">entrar</button>
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

@endpush
