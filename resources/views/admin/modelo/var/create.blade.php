<!-- Modal -->
<div id="myModalModeloVar" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form> </form>
                <form id="formModeloVar"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="ModComId" value="{{$modelo->ModComId}}">
                    <input type="hidden" id="var_id" name="var_id">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="var_codigo">Código<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="var_codigo" class="form-control col-md-7 col-xs-12" name="var_codigo"  required="required" type="text">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="var_valor">Valor<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="var_valor" class="form-control col-md-7 col-xs-12" name="var_valor"  required="required" type="text">
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
