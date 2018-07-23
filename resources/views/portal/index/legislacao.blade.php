@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Legislação</div>
            <p class="pf-text-muted mb-4">Sobre as principais leis, decretos e documentos que regem a legalidade dos processos de Dívida Ativa.</p>

            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3 text-center mb-4">
                    <a href="#" class="pf-td-none">
                        <img src="{{asset('images/portal/ico-legislacao.svg')}}" class="mb-4 mt-4" alt="" />
                        <div class="h6 text-left pf-text-secondary pf-text-titulo-legislacao">Lei complementar nº 225 de 23 de dezembro de 1999</div>
                        <p class="text-left pf-text-muted">Dispõe sobre as datas de vencimento dos créditos tributários que menciona e dá Outras providências.</p>
                    </a>
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