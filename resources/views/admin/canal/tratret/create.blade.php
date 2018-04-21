<!-- Modal -->
<div id="myModalTratRet" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formTratRet"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="CanalId" value="{{$canal->CANALID}}">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Descrição<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('RetornoCd') }}" id="RetornoCd" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="RetornoCd"  required="required" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Número Erro<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('RetornoCdNr') }}" id="RetornoCdNr" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="RetornoCdNr"  required="required" type="text">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Evento<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="EventoId" name="EventoId" required="required">
                                <option value=""></option>
                                    @foreach($Evento as $var)
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