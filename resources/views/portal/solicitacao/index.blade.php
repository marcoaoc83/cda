@extends('layouts.auth')
@section('title','Login')
@section('content')
    <div class="animate form login_form">
        <section class="login_content">
            <form role="form" method="POST" action="{{ route('portal.solicitacaoSend') }}">
                {{csrf_field()}}
                <h1>Solicitação</h1>
                <div class="form-group">
                    <input type="text" class="form-control" name="soa_nome" placeholder="Nome" required="required" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="soa_documento" placeholder="CPF/CNPJ" required="required" />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="soa_data_nasc" placeholder="Data Nascimento"  />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="soa_nome_mae" placeholder="Nome Mãe"   />
                </div>
                <div>
                    <button class="btn btn-default submit" type="submit">Enviar</button>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <p class="change_link">Já possui uma conta?
                        <a href="{{route('login')}}" class="to_register"> Login </a>
                    </p>

                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <h1><i class="fa fa-plus-circle"></i> {{config('app.name')}}</h1>
                        <p>©{{date('Y')}} </p>
                    </div>
                </div>
            </form>
        </section>
    </div>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
@endsection
