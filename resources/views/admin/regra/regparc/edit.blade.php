<!-- Modal -->
<div id="myModalRegParcEdita" class="modal fade" role="dialog">
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
                    <input type="hidden" name="RegCalcId" value="{{$RegraCalculo->RegCalcId}}">
                    <input type="hidden" name="RegParcId" id="RegParcId" value="">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ParcelaQt">PcQt <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input  type="text" id="ParcelaQt" name="ParcelaQt" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="OpRegId">TpOp<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="OpRegId" name="OpRegId"  >
                                <option value=""></option>
                                            @foreach($OpReg as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABSG}} - {{$var->REGTABNM}}</option>             
                                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FatorVr">Fator</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="FatorVr" name="FatorVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="JuroDescTx">% Desc Juros</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="JuroDescTx" name="JuroDescTx"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="MultaDescTx">% Desc Multa</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="MultaDescTx" name="MultaDescTx"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="PrincipalDescTx">% Desc Principal</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="PrincipalDescTx" name="PrincipalDescTx"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EntradaMinVr">Vr Min Entrada</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="EntradaMinVr" name="EntradaMinVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ParcelaMinVr">Vr Min Parcela</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="ParcelaMinVr" name="ParcelaMinVr"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="number">
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