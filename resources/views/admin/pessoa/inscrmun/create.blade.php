<!-- Modal -->
<div id="myModalInscrMun" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formInscrMun"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="PESSOAID" value="{{$Pessoa->PESSOAID}}">
                    <input type="hidden" id="INSCRMUNID" name="INSCRMUNID">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Inscr Mun<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="INSCRMUNNR" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="INSCRMUNNR"  required="required" type="number">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ORIGTRIBID">OrigTrib <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ORIGTRIBID" name="ORIGTRIBID" required="required">
                                <option value=""></option>
                                 @foreach($ORIGTRIB as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                 @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="INICIODT">Inicio</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left date-picker" id="INICIODT" name="INICIODT" aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TERMINODT">Termino</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left date-picker" id="TERMINODT" name="TERMINODT" aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SITUACAO">Atv
                        </label>
                        <div class="col-md-7" style="margin-top: 5px">
                            <label style="">
                                <input type="checkbox" id="SITUACAO" name="SITUACAO" value="1" class="js-switch" >
                            </label>
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
