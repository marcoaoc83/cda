<!-- Modal -->
<div id="myModalSocResp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formSocResp"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="PessoaId" value="{{$Pessoa->PESSOAID}}">
                    <input type="hidden" id="InscrMunId" name="InscrMunId" >
                    <input type="hidden" id="SocRespId" name="SocRespId">
                    <input type="hidden" id="PessoaIdSR" name="PessoaIdSR">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PessoaIdSR">Socio <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <input type="text" name="PessoaIdSRName" id="PessoaIdSRName" class="form-control col-md-10 typeahead"  data-provide="typeahead">
                        </div>
                    </div>


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="InicioDt">Inicio</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left date-picker" id="InicioDt" name="InicioDt" aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TerminoDt">Termino</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left date-picker" id="TerminoDt" name="TerminoDt" aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
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
