@extends('portal.index.index')
@section('content')
<div class="pf-main">
    <div id="carouselDesktop" class="carousel slide d-none d-md-block" data-ride="carousel">
        <div class="carousel-inner">
            @if($Var->port_banner1)
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner1)}}" alt="1">
            </div>
            @endif
            @if($Var->port_banner2)
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner2)}}" alt="Second slide">
            </div>
            @endif
            @if($Var->port_banner3)
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner3)}}" alt="Third slide">
            </div>
            @endif
            @if($Var->port_banner4)
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner4)}}" alt="Third slide">
            </div>
            @endif
            @if($Var->port_banner5)
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner5)}}" alt="Third slide">
            </div>
            @endif
        </div>
        <a class="carousel-control-prev" href="#carouselDesktop" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon pf-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselDesktop" role="button" data-slide="next">
            <span class="carousel-control-next-icon pf-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


    <div id="carouselMobile" class="carousel slide d-block d-md-none" data-ride="carousel">
        <div class="carousel-inner">
            @if($Var->port_banner1)
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner1)}}" alt="1">
                </div>
            @endif
            @if($Var->port_banner2)
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner2)}}" alt="Second slide">
                </div>
            @endif
            @if($Var->port_banner3)
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner3)}}" alt="Third slide">
                </div>
            @endif
            @if($Var->port_banner4)
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner4)}}" alt="Third slide">
                </div>
            @endif
            @if($Var->port_banner5)
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{asset('images/portal/'.$Var->port_banner5)}}" alt="Third slide">
                </div>
            @endif
        </div>
        <a class="carousel-control-prev" href="#carouselMobile" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon pf-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselMobile" role="button" data-slide="next">
            <span class="carousel-control-next-icon pf-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>



    <div class="container">
        <div class="pb-4 position-relative">
            <div class="d-none d-lg-block position-absolute pf-informacao"><img src="{{asset('images/portal/'.$Var->port_banner_lateral)}}" alt=""></div>
            <div class="h2 text-center pt-5 pb-2 pf-text-primary d-lg-none"><strong>Serviços Disponíveis</strong></div>
            <div class="container p-4 pt-0 text-center">
                <div class="row justify-content-start">
                    <div class="col-lg-6 h3 text-center pt-4 pb-4 pf-text-primary d-none d-lg-block"><strong>Serviços Disponíveis</strong></div>
                </div>
                <div class="row justify-content-start">
                    <a href="{{route('portal.acesso')}}" class="col-6 col-lg-3 border-right border-left border-top pf-td-none m-lg-2 lg-border pf-acesso-rapido">
                        <img src="{{asset('images/portal/'.$Var->port_icone_1)}}" class="pb-4 pt-4" alt="Consultar Débitos" />
                        <h6 class="text-body">Consultar Débitos</h6>
                        <p class="text-secondary">Consulte os débitos de sua inscrição e gere o extrato.</p>
                    </a>
                    <a href="{{route('portal.acesso')}}" class="col-6 col-lg-3 border-right border-top pf-td-none m-lg-2 lg-border pf-acesso-rapido">
                        <img src="{{asset('images/portal/'.$Var->port_icone_2)}}" class="pb-4 pt-4" alt="Emitir Guia" />
                        <h6 class="text-body">Emitir Guia</h6>
                        <p class="text-secondary">Emitir guia dos débitos em aberto.</p>
                    </a>
                </div>
                <div class="row">
                    <a href="{{route('portal.acesso')}}" class="col-6 col-lg-3 border-right border-left border-top border-bottom pf-td-none m-lg-2 lg-border pf-acesso-rapido">
                        <img src="{{asset('images/portal/'.$Var->port_icone_3)}}" class="pb-4 pt-4" alt="Parcelamento" />
                        <h6 class="text-body">Parcelamento</h6>
                        <p class="text-secondary">Simule e realize parcelamentos</p>
                    </a>
                    <a href="{{route('portal.ajuda')}}" class="col-6 col-lg-3 border-right border-top border-bottom pf-td-none m-lg-2 lg-border pf-acesso-rapido">
                        <img src="{{asset('images/portal/'.$Var->port_icone_4)}}" class="pb-4 pt-4" alt="Dúvidas Frequentes" />
                        <h6 class="text-body">Dúvidas Frequentes</h6>
                        <p class="text-secondary">Obtenha respostas para as perguntas mais frequentes.</p>
                    </a>
                    <div class="d-none d-lg-block col-lg-4 align-self-end pb-5 pl-2 text-white"> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pf-bg-como-funciona ">
        <div class="container">
            <div class="h4 pt-5 pb-4 text-center">Como Funciona</div>
            {!! nl2br($Var->port_como_funciona)!!}
        </div>
    </div>

</div>
<!-- /page content -->
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
</script>

@endpush
