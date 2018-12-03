<!-- Modal -->
<div id="myModalEvento" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formEvento"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="CanalId" value="{{$canal->CANALID}}">
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Evento<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="EventoId" name="EventoId" required="required">
                                <option value=""></option>
                                    @foreach($Evento as $var)
                                        @if($var->ObjEventoId != 30) @continue @endif;
                                        <option value="{{$var->EventoId}}" >({{$var->EventoSg}}) - {{$var->EventoNm}}</option>             
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success" id="btnSalvar">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>