<!-- Modal -->
<div id="myModalCredPort" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formCredPort"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="PessoaId" value="{{$Pessoa->PESSOAID}}">
                    <input type="hidden" id="InscrMunId" name="InscrMunId" >
                    <input type="hidden" id="CredPortId" name="CredPortId">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PessoaIdCP">Nome <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="PessoaIdCP" name="PessoaIdCP" required="required">
                                <option value=""></option>
                                @foreach($PessoaIdCP as $var)
                                    <option value="{{$var->PESSOAID}}" >{{$var->PESSOANMRS}} - {{$var->CPF_CNPJNR}}</option>             
                                @endforeach
                            </select>
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
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Senha">Senha <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value=""  type="password" id="Senha"  data-minlength="6"  name="Senha" required="required" class="form-control col-md-7 col-xs-12">
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
