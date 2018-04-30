<!-- Modal -->
<div id="myModalRoteiroEdita" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar</h4>
            </div>
            <div class="modal-body">
                <form id="formEditar"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="CarteiraId" value="{{$Carteira->CARTEIRAID}}">
                    <input type="hidden" name="RoteiroId" id="RoteiroId" value="">


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="RoteiroOrd">Ord <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('RoteiroOrd') }}"  type="text" id="RoteiroOrd" name="RoteiroOrd" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FaseCartId">Fase Cart<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="FaseCartId" name="FaseCartId" required="required">
                                <option value=""></option>
                                            @foreach($FaseCart as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABSG}} - {{$var->REGTABNM}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EventoId">Evento<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="EventoId" name="EventoId" required="required">
                                <option value=""></option>
                                @foreach($Evento as $var)
                                    <option value="{{$var->EventoId}}" >{{$var->EventoSg}} - {{$var->EventoNm}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ModComId">ModCom
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ModComId" name="ModComId" >
                                <option value=""></option>
                                @foreach($ModCom as $var)
                                    <option value="{{$var->ModComId}}" >{{$var->ModComSg}} - {{$var->ModComNm}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaTrabId">Fila<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="FilaTrabId" name="FilaTrabId" required="required" >
                                <option value=""></option>
                                @foreach($FilaTrab as $var)
                                    <option value="{{$var->FilaTrabId}}" >{{$var->FilaTrabSg}} - {{$var->FilaTrabNm}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CanalId">Canal</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="CanalId" name="CanalId" >
                                <option value=""></option>
                                @foreach($Canal as $var)
                                    <option value="{{$var->CANALID}}" >{{$var->CANALSG}} - {{$var->CANALNM}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="RoteiroProxId">Prox Roteiro
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="RoteiroProxId" name="RoteiroProxId"  >
                                <option value=""></option>
                                @foreach($RoteiroProx as $var)
                                    <option value="{{$var->RoteiroId}}" >{{$var->RoteiroOrd}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" id="btnSalvar_edt">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>