<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Portal de Negociação de Divida Ativa - Prefeitura</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link href="{{ url('portal/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('portal/css/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('portal/css/fontAwesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('portal/css/hero-slider.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('portal/css/owl-carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('portal/css/templatemo-style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('portal/css/lightbox.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ url('portal/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
</head>

<body>
<div class="header">
    <div class="container">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="navbar-header" style="margin-left:40px">
                <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="#" class="navbar-brand scroll-top">
                    <img src="portal/img/logo.png" height="48px" style="position: absolute;margin-left: -50px;margin-top: 15px;">
                    <em>CDA</em>-e</a>
            </div>
            <!--/.navbar-header-->
            <div id="main-nav" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#" class="scroll-top">Inicio</a></li>
                    <li><a href="#" class="scroll-link" data-id="about">Serviços</a></li>
                    <li><a href="#" class="scroll-link" data-id="portfolio">FAQ</a></li>
                    <li><a href="#" class="scroll-link" data-id="blog">Legislação</a></li>
                    <li><a href="#" class="scroll-link" data-id="contact-us">Contato</a></li>
                    <li><a href="/login" target="_blank" class="" >Entrar</a></li>
                </ul>
            </div>
            <!--/.navbar-collapse-->
        </nav>
        <!--/.navbar-->
    </div>
    <!--/.container-->
</div>
<!--/.header-->


<div class="parallax-content baner-content" id="home">
    <div class="container">
        <div class="text-content">
            <h2>Prefeitura - <span>COBRANÇA</span> DIVIDA <em>ATIVA</em></h2>
            <p>Phasellus aliquam finibus est, id tincidunt mauris fermentum a. In elementum diam et dui congue, ultrices bibendum mi lacinia. Aliquam lobortis dapibus nunc, nec tempus odio posuere quis. </p>
            <div class="primary-white-button">
                <a href="#" class="scroll-link" data-id="about">Começar</a>
            </div>
        </div>
    </div>
</div>


<section id="about" class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-item">
                    <div class="icon">
                        <img src="portal/img/service_icon_08.png" alt="">
                    </div>
                    <h4>Solicitar Acesso</h4>
                    <div class="line-dec"></div>
                    <p>Crie sua conta agora e tenha acesso a seus débitos da PREFEITURA DE "CIDADE"</p>
                    <div class="primary-blue-button">
                        <a href="{{url('/solicitacao')}}" target="_blank">Continuar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-item">
                    <div class="icon">
                        <img src="portal/img/service_icon_07.png" alt="">
                    </div>
                    <h4>Conheça seus débitos</h4>
                    <div class="line-dec"></div>
                    <p>Integer hendrerit vehicula mauris, sed pellentesque sem facilisis at. Aliquam vel arcu metus. Nam sem lectus, mattis non tellus et, tincidunt condimentum eros.</p>
                    <div class="primary-blue-button">
                        <a href="{{url('/login')}}" target="_blank">Continuar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-item">
                    <div class="icon">
                        <img src="portal/img/service_icon_05.png" alt="">
                    </div>
                    <h4>Emita Boletos</h4>
                    <div class="line-dec"></div>
                    <p>Integer hendrerit vehicula mauris, sed pellentesque sem facilisis at. Aliquam vel arcu metus. Nam sem lectus, mattis non tellus et, tincidunt condimentum eros.</p>
                    <div class="primary-blue-button">
                        <a href="{{url('/login')}}" target="_blank">Continuar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="service-item">
                    <div class="icon">
                        <img src="portal/img/service_icon_06.png" alt="">
                    </div>
                    <h4>Negocie seus débitos</h4>
                    <div class="line-dec"></div>
                    <p>Integer hendrerit vehicula mauris, sed pellentesque sem facilisis at. Aliquam vel arcu metus. Nam sem lectus, mattis non tellus et, tincidunt condimentum eros.</p>
                    <div class="primary-blue-button">
                        <a href="{{url('/login')}}" target="_blank">Continuar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h4>Tem alguma dúvida?</h4>
                    <div class="line-dec"></div>
                    <p>Donec sit amet commodo arcu. Sed sit amet iaculis mi, vel fermentum nisi. Morbi dui enim, vestibulum non accumsan ac, tempor non nisl.</p>
                    <div class="pop-button">
                        <h4>Enviar mensagem</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="pop">
                    <span>Fechar</span>
                    <form id="contact" action="#" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Seu Nome" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="Seu Email" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Mensagem..." required=""></textarea>
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="btn">Enviar Mensagem</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="logo">
                    <a href="#" class="scroll-top"><em>CDA-</em>e</a>
                    <p>Copyright &copy; 2017 - <?=date('Y')?> CDA-e
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="location">
                    <h4>Localização</h4>
                    <ul>
                        <li>Rua das flores, <br>São Paulo - SP</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <div class="contact-info">
                    <h4>Mais Informações</h4>
                    <ul>
                        <li><em>Fone</em>: 011-9999-1234</li>
                        <li><em>Email</em>: email@gmail.com</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 col-sm-12">
                <div class="connect-us">
                    <h4>Siga-nos nas redes sociais</h4>
                    <ul>
                        <li><a href="https://www.facebook.com/cdae" target="_parent"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.google.com/cdae" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


<script src="{{ url('portal/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ url('portal/js/plugins.js') }}"></script>
<script src="{{ url('portal/js/main.js') }}"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // navigation click actions 
        $('.scroll-link').on('click', function(event){
            event.preventDefault();
            var sectionID = $(this).attr("data-id");
            scrollToID('#' + sectionID, 750);
        });
        // scroll to top action
        $('.scroll-top').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 'slow');
        });
        // mobile nav toggle
        $('#nav-toggle').on('click', function (event) {
            event.preventDefault();
            $('#main-nav').toggleClass("open");
        });
    });
    // scroll function
    function scrollToID(id, speed){
        var offSet = 50;
        var targetOffset = $(id).offset().top - offSet;
        var mainNav = $('#main-nav');
        $('html,body').animate({scrollTop:targetOffset}, speed);
        if (mainNav.hasClass("open")) {
            mainNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");
        }
    }
    if (typeof console === "undefined") {
        console = {
            log: function() { }
        };
    }
</script>
</body>
</html>