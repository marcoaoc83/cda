<footer class="pf-footer  pl-3 pr-3 pt-4 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-3">
                <div class="text-center text-lg-left pb-4 pt-lg-4 pb-lg-4"><img src="{{asset('images/portal/'.$Var->port_logo_rodape)}}" alt="" /></div>
                <p class="text-center text-lg-left pb-3">Utilize o Portal de Negociação e acesse o serviço on-line para resolver tudo de um jeito fácil e rápido.</p>
            </div>
            <div class="col-12 col-lg-6 col-xl-4 offset-xl-4">
                <div><i class="fas fa-map-marker-alt fa-lg"></i> <span> </span>Endereço</div>
                <p class="ml-5">{!! nl2br($Var->port_endereco) !!}</p>
                <div><i class="far fa-clock fa-lg"></i> <span> </span>Horário de Atendimento</div>
                <p class="ml-5">{!! nl2br($Var->port_horario) !!}</p>
            </div>
        </div>
    </div>
</footer>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
{{--<script type="text/javascript" src="js/efeitos.js"></script>--}}
<script src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" data-auto-replace-svg="nest"></script>
</body>
</html>
