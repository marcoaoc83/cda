@extends('portal.index.index')
@section('content')
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Ajuda</div>
            <p class="pf-text-muted mb-4">Nesta página reunimos as perguntas frequentes, de modo que você possa esclarecer suas dúvidas:</p>


            <div class="accordion" id="accordionExample">
                @foreach($Faq as $key => $var)
                    <div class="mb-0 mt-3" id="heading{{$key}}">
                        <h6 class="pf-text-muted font-weight-bold pf-cursor-pointer" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                            {{$var->faq_titulo}}
                        </h6>
                    </div>
                    <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordionExample">
                        <div class="card-body pf-word-wrap pf-text-secondary">
                            {!! ($var->faq_texto)!!}
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
<!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js">
    </script>

@endpush