<!-- Modal -->
<div id="myModalExpArquivo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formExpArquivo"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="exc_layout_id" value="{{$ExpLayout->exp_id}}">


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_tabela">Tabela<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="exc_campo" name="exc_campo" required="required">
                                <option value=""></option>

                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_campo">Campo <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="exc_campo" name="exc_campo" required="required">
                                <option value=""></option>

                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_campo_fk">Campo Ref - FK <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ext_campo_fk" name="ext_campo_fk" required="required">
                                <option value=""></option>

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