@extends('layouts.app')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.min.css" rel="stylesheet">
@endsection
@section('content')
    <!-- page content -->
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Execução de Fila</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel" id="filaDiv">
                        <div class="x_title">
                            <h2>Fila<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-divFiltroContribuintelink"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback"  >
                                <select class="form-control" id="FilaTrabId" name="FilaTrabId" placeholder="Fila"  onchange="selectFila(this.value)" >
                                    <option value="" hidden selected disabled>Selecionar Fila</option>
                                    @foreach($FilaTrab as $var)
                                        <option value="{{$var->FilaTrabId}}" >{{$var->FilaTrabSg}} - {{$var->FilaTrabNm}}</option>             
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="x_content"  id="divFiltroCanal" style="display: none">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group has-feedback"  >
                                <select class="form-control" id="CanalId" name="CanalId" placeholder="Canal"  onchange="selectCanal(this.value)" >
                                    <option value="" hidden selected disabled>Selecionar Canal</option>
                                    @foreach($Canal as $var)
                                        <option value="{{$var->CANALID}}" >{{$var->CANALSG}} - {{$var->CANALNM}}</option>             
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="x_panel" id="divFiltros" style="display: none">
                        <form class="form-horizontal form-label-left" id="formFiltroParcela"    method="post" action="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @include('admin.execfila.filtro-carteira')
                            @include('admin.execfila.filtro-roteiro')
                            @include('admin.execfila.filtro-validacao')

                            @include('admin.execfila.filtro-eventos')
                            @include('admin.execfila.filtro-tratamento')
                            @include('admin.execfila.filtro-notificacao')

                            @include('admin.execfila.filtro-contribuinte')
                            @include('admin.execfila.filtro-parcela')

                            <div class="x_panel text-center " style="background-color: #BDBDBD" id="divBotaoFiltrar">
                                <a class="btn btn-app" id="btfiltrar" onclick="filtrar()" >
                                    <i class="fa fa-filter"></i> Filtrar
                                </a>
                            </div>
                            <button id="send" type="submit" class="btn btn-success hidden">Salvar</button>
                        </form>
                    </div>
                        @include('admin.execfila.result-contribuinte')
                        @include('admin.execfila.result-contribuinteVal')
                        @include('admin.execfila.result-contribuinteTrat')

                        @include('admin.execfila.result-contribuinteIMVal')
                        @include('admin.execfila.result-contribuinteIMTrat')
                        @include('admin.execfila.result-im')

                        @include('admin.execfila.result-canal')
                        @include('admin.execfila.result-canalexec')
                        @include('admin.execfila.result-parcela')

                        @include('admin.execfila.novo-canal')
                        @include('admin.execfila.edita-canal')



                    <form  id="formParcelas" method="post" action="{{ route('execfila.store') }}" >
                        {{ csrf_field() }}
                        <input type="hidden" id="filaId" name="filaId">
                        <input type="hidden" id="parcelas" name="parcelas">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback text-center">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="item form-group">
                                    <label for="gravar">Gravar</label>
                                    <label><input type="checkbox" id="gravar"   name="gravar"  value="1" class="js-switch" ></label>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="gCSV">CSV</label>
                                <label><input type="checkbox" id="gCSV"   name="gCSV"  value="1" class="js-switch" ></label>
                            </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="item form-group">
                                <label for="gTXT">TXT</label>
                                <label><input type="checkbox" id="gTXT"   name="gTXT"  value="1" class="js-switch" ></label>
                            </div>
                            </div>
                        </div>
                    </form>

                    <div class="x_panel text-center">

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <a class="btn btn-app "    id="execFila">
                                <i class="fa fa-save"></i> Executar
                            </a>
                            <a class="btn btn-app "    id="execValida" style="display: none">
                                <i class="fa fa-save"></i> Executar
                            </a>
                            <a class="btn btn-app "    id="execTratamento" style="display: none">
                                <i class="fa fa-save"></i> Executar
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.min.js"></script>
    <script src="http://kingkode.com/datatables.editor.lite/js/altEditor/dataTables.altEditor.free.js"></script>

    @include('admin.execfila.datepicker')
    @include('admin.execfila.geral')

    @include('admin.execfila.tbCarteira')
    @include('admin.execfila.tbRoteiro')
    @include('admin.execfila.tbValidacao')
    @include('admin.execfila.tbEventos')
    @include('admin.execfila.tbTratRet')

    @include('admin.execfila.tbFxAtraso')
    @include('admin.execfila.tbFxValor')
    @include('admin.execfila.tbSitPag')
    @include('admin.execfila.tbSitCob')
    @include('admin.execfila.tbOrigTrib')
    @include('admin.execfila.tbTributo')

    @include('admin.execfila.tbParcela')
    @include('admin.execfila.tbContribuinteRes')
    @include('admin.execfila.tbIMRes')
    @include('admin.execfila.tbContribuinteResVal')
    @include('admin.execfila.tbContribuinteResTrat')
    @include('admin.execfila.tbContribuinteResIMVal')
    @include('admin.execfila.tbContribuinteResIMTrat')
    @include('admin.execfila.tbCanalRes')
    @include('admin.execfila.tbCanalExec')

    @include('admin.execfila.execFila')
    @include('admin.execfila.execValida')
@endpush