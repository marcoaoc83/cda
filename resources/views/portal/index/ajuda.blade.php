@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Ajuda</div>
            <p class="pf-text-muted mb-4">Nesta página reunimos as perguntas frequentes, de modo que você possa esclarecer suas dúvidas:</p>


            <div class="accordion" id="accordionExample">
                <div class="mb-0 mt-3" id="headingOne">
                    <h6 class="pf-text-muted font-weight-bold pf-cursor-pointer" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">1) Como faço para agendar atendimento na Plataforma de Atendimento?</h6>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body pf-word-wrap pf-text-secondary">
                        Para realizar o agendamento é necessário seguir os passos abaixo descritos:<br>
                        <br>
                        a. Acessar o link: http://agendamento.uberlandia.mg.gov.br/agendamento <br>
                        b. Faça seu cadastro para ter acesso aos serviços (caso já possua clique em "ENTRAR");<br>
                        c. Escolha o serviço desejado;<br>
                        d. Em seguida seleciona a unidade, data e horário disponíveis;<br>
                        e. Confira as informações e clique em "CONFIRMAR AGENDAMENTO" para concluir;<br>
                        f. Anote a senha informada e compareça ao local no dia e horário agendado.
                    </div>
                </div>
                <div class="mb-0 mt-3" id="headingTwo">
                    <h6 class="pf-text-muted font-weight-bold collapsed pf-cursor-pointer" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">2) Como faço para agendar atendimento na Plataforma de Atendimento?</h6>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body pf-word-wrap pf-text-secondary">
                        Para realizar o agendamento é necessário seguir os passos abaixo descritos:<br>
                        <br>
                        a. Acessar o link: http://agendamento.uberlandia.mg.gov.br/agendamento <br>
                        b. Faça seu cadastro para ter acesso aos serviços (caso já possua clique em "ENTRAR");<br>
                        c. Escolha o serviço desejado;<br>
                        d. Em seguida seleciona a unidade, data e horário disponíveis;<br>
                        e. Confira as informações e clique em "CONFIRMAR AGENDAMENTO" para concluir;<br>
                        f. Anote a senha informada e compareça ao local no dia e horário agendado.
                    </div>
                </div>
                <div class="mb-0 mt-3" id="headingThree">
                    <h6 class="pf-text-muted font-weight-bold collapsed pf-cursor-pointer" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">3) Como faço para agendar atendimento na Plataforma de Atendimento?</h6>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body pf-word-wrap pf-text-secondary">
                        Para realizar o agendamento é necessário seguir os passos abaixo descritos:<br>
                        <br>
                        a. Acessar o link: http://agendamento.uberlandia.mg.gov.br/agendamento <br>
                        b. Faça seu cadastro para ter acesso aos serviços (caso já possua clique em "ENTRAR");<br>
                        c. Escolha o serviço desejado;<br>
                        d. Em seguida seleciona a unidade, data e horário disponíveis;<br>
                        e. Confira as informações e clique em "CONFIRMAR AGENDAMENTO" para concluir;<br>
                        f. Anote a senha informada e compareça ao local no dia e horário agendado.
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