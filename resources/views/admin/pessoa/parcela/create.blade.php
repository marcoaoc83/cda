<!-- Modal -->
<div id="myModalParcela" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formParcela"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="PessoaId" value="{{$Pessoa->PESSOAID}}">
                    <input type="hidden" id="InscrMunId" name="InscrMunId" >
                    <input type="hidden" id="ParcelaId" name="ParcelaId">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SitPagId">Sit Pagamento <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="SitPagId" name="SitPagId"  required="required">
                                <option value=""></option>
                                @foreach($StPag as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="SitCobId">Sit Cobrança<span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="SitCobId" name="SitCobId"  required="required">
                                <option value=""></option>
                                @foreach($SitCob as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="OrigTribId">Orig Trib<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="OrigTribId" name="OrigTribId"  required="required">
                                <option value=""></option>
                                @foreach($ORIGTRIB as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TributoId">Tributo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="TributoId" name="TributoId">
                                <option value=""></option>
                                @foreach($Tributo as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LancamentoDt">Lançamento<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left date-picker" id="LancamentoDt"  required="required" name="LancamentoDt" aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="LancamentoNr">Lançamento Nº</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="LancamentoNr" name="LancamentoNr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="VencimentoDt">Vencimento </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control has-feedback-left date-picker" id="VencimentoDt" name="VencimentoDt" aria-describedby="inputSuccess2Status">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status" class="sr-only">(success)</span>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ParcelaNr">Parcela Nº</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="ParcelaNr" name="ParcelaNr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PlanoQt">Plano </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="PlanoQt" name="PlanoQt"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PrincipalVr">Valor Principal </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="PrincipalVr" name="PrincipalVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="MultaVr">Valor Multa </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="MultaVr" name="MultaVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JurosVr">Valor Juros </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="JurosVr" name="JurosVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TaxaVr">Valor Taxa </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="TaxaVr" name="TaxaVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="AcrescimoVr">Valor Acrescimo </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="AcrescimoVr" name="AcrescimoVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="DescontoVr">Valor Desconto </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="DescontoVr" name="DescontoVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Honorarios">Valor Honorarios </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="Honorarios" name="Honorarios"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TotalVr">Valor Total </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="TotalVr" name="TotalVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
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
