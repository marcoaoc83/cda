<!-- Modal -->
<div id="modalEdita" class="modal fade" role="dialog">
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
                    <input type="hidden" name="TABSYSID" value="{{$tabsys->TABSYSID}}">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sigla<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="REGTABSG_edt" name="REGTABSG" maxlength="10"  required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nome<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="REGTABNM_edt" name="REGTABNM" maxlength="60" required="required" class="form-control col-md-7 col-xs-12 ">
                        </div>
                    </div>
                    <div class="form-group sql">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">SQL</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" rows="3" id="REGTABSQL_edt" name="REGTABSQL"></textarea>

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