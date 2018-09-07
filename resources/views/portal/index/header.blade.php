<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/css.css">
<link href="imgs/brasao.gif" rel="shortcut icon" type="image/x-icon" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<title>{{$Var->port_titulo}}</title>

<style>
    :root {

        --bg-color:{{$Var->port_cor}};
        --text-color: {{$Var->port_cor_letra}};

        --text-grey-primary: #EBEBEB;
        --text-grey-secondary: #DEE2E6;
        --text-grey-tertiary: #999999;
        --text-grey-quaternary: #666666;
        --text-grey-quinary: #333333;


        --text-blue-primary: #014A9E;
        --text-blue-secundary: #002F66;
        --text-blue-tertiary: #002A5B;


        --text-orange-primary: {{$Var->port_cor_menu2}};
        --text-orange-secundary: {{$Var->port_cor_menu1}};

        --menu-text: {{$Var->port_cor_menu_letra}};
        --rodape1: {{$Var->port_cor_rodape1}};
        --rodape2: {{$Var->port_cor_rodape2}};
        --rodape-letras: {{$Var->port_cor_rodape_letra}};

        --img-slide-arrow: url({{asset('images/portal/slide-arrow.svg')}});
    }

    * { font-family: 'Open Sans', sans-serif !important; }
    body { background-color: var(--bg-color)}
    #PF .pf-nav { padding: 1.2rem 1rem; }
    #PF .pf-nav ul { padding-top: 10px; }
    #PF .pf-logo { position:absolute;top: 0;left: 0;z-index: 100;margin: 15px 0 0 15px; }
    #PF .pf-logo > img{ height:50px; }
    #PF .pf-prev-icon { height:55px;width:55px;background-image: var(--img-slide-arrow);background-size:54px;margin-top:10px; }
    #PF .pf-cursor-pointer { cursor:pointer; }
    #PF .pf-next-icon { height:55px;width:55px;background-image: var(--img-slide-arrow);background-size:54px;margin-top:10px;-moz-transform: scaleX(-1);-o-transform: scaleX(-1);-webkit-transform: scaleX(-1);transform: scaleX(-1); }
    #PF .pf-td-none { text-decoration:none; }
    #PF .pf-word-wrap { word-wrap: break-word; }
    #PF .pf-bg-como-funciona { background-color:var(--rodape1); color: var(--rodape-letras) }
    #PF .pf-footer { background-color:var(--rodape2); color: var(--rodape-letras) }
    #PF .pf-text-padding-10-0 { padding:10px 0; }
    #PF .pf-text-primary { color:var(--text-color); }
    #PF .pf-text-muted { color:var(--text-grey-quinary); }
    #PF .pf-text-secondary { color:var(--text-grey-quaternary); }
    #PF .pf-text-label { color:var(--text-grey-tertiary);margin-bottom: 0.2rem; }
    #PF .pf-border-light { border-color: var(--text-grey-primary); }
    #PF .pf-btn-primary { background-color:var(--text-blue-tertiary);width:120px;height:40px;-webkit-border-radius: 30px;-moz-border-radius: 30px;border-radius: 30px; }
    #PF .pf-btn-primary:hover { background-color:var(--text-blue-primary);-webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.45);-moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.45);box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.45); }
    #PF .pf-input-text { height:50px;border-color:var(--text-grey-primary); }
    #PF .pf-topo-site { min-height:68px;position:relative; }
    #PF .pf-informacao > img { -webkit-border-top-left-radius: 15px;-webkit-border-bottom-left-radius: 15px;-moz-border-radius-topleft: 15px;-moz-border-radius-bottomleft: 15px;border-top-left-radius: 15px;border-bottom-left-radius: 15px; }

    @media (min-width: 992px) {
        #PF .pf-topo-site { min-height:115px; }
        #PF .pf-nav { min-height:115px;border-bottom: 5px solid var(--text-orange-primary) !important;padding:0;position:relative; }
        #PF .pf-nav::after { width: 529px;height: 10px;background-color: var(--text-orange-secundary);content: '';position: absolute;bottom: -5px;right: 0;clip-path: polygon(0 0, 100% 0%, 100% 100%, 6px 100%); }
        #PF .pf-nav.without-after-element::after { content: none; }
        #PF .pf-logo { margin: 35px 0 0 35px; }
        #PF .pf-menu { color: var(--menu-text); position: relative;flex-grow: 0 !important;height:115px !important;background-color:var(--text-orange-secundary) !important;padding:0 40px 0 100px;-webkit-clip-path: polygon(0 0, 100% 0%, 100% 100%, 80px 100%);clip-path: polygon(0 0, 100% 0%, 100% 100%, 80px 100%); }
        #PF .pf-menu::before { width:12px;height:115px;background-color: var(--text-orange-primary);content: '';position:absolute;transform: skew(35deg);left: 35px; }
        #PF .pf-menu.without-before-element::before { content: none; }
        #PF .pf-menu > ul { padding-bottom:3px !important; }
        #PF .pf-text-titulo { font-size:2.0em !important;font-weight: 100 !important;margin-top:30px; }
        #PF .pf-text-titulo-legislacao { -o-transition:all .3s ease !important;-ms-transition:all .3s ease !important;-moz-transition:all .3s ease !important;-webkit-transition:all .3s ease !important;transition:all .3s ease !important; }
        #PF a:hover > .pf-text-titulo-legislacao { color: var(--text-blue-secundary) !important;font-weight:bold !important; }
        #PF .pf-acesso-rapido { border: 1px solid var(--text-grey-secondary)!important;transition: all 0.2s ease-in-out; }
        #PF .pf-acesso-rapido:hover { border-color:var(--text-orange-secundary) !important;background-color:var(--text-orange-secundary) !important;-webkit-box-shadow: 0px 8px 15px rgba(0,0,0,0.15);-moz-box-shadow: 0px 8px 15px rgba(0,0,0,0.15);box-shadow: 0px 8px 15px rgba(0,0,0,0.15); }
        #PF .pf-acesso-rapido:hover > p { color:var(--text-grey-quinary) !important; }
        #PF .pf-informacao { right:-30px;bottom:56px;overflow: hidden; }
        #PF .pf-informacao > img { max-height:460px; }
    }

    @media (min-width: 1200px) {
        #PF .pf-informacao { right:30px;bottom:56px; }
    }
</style>