@extends('layouts.auth')
@section('title','Login')
@section('content')

    <div class="animate form login_form">
        <section class="login_content">
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{csrf_field()}}
                <h1>Login</h1>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control" name="email" placeholder="Login" required="" />
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Senha" required="" />
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div>
                    <button class="btn btn-default submit" type="submit">Entrar</button>
                    <a class="reset_pass" href="{{ url('/password/reset') }}">Esqueceu sua senha?</a>
                </div>

                <div class="clearfix"></div>

                <div class="separator">
                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <h1><span class="image"><img src="/images/logo.png" alt="CDA-e" /></span></h1>
                        <p>©{{date('Y')}} </p>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
