<!-- Modal -->
<div id="myModalExecRotEdita" class="modal fade" role="dialog">
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
                    <input type="hidden" name="RoteiroId" id="RoteiroId" >
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ExecRotId">Variável<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ExecRotId" name="ExecRotId" required="required">
                                <option value=""></option>
                                            @foreach($ExecRot as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABSG}} - {{$var->REGTABNM}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="AtivoSN">Atv
                        </label>
                        <div class="col-md-7" style="margin-top: 5px">
                            <label style="">
                                <input type="checkbox" id="AtivoSN" name="AtivoSN" value="1" class="js-switch" >
                            </label>
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