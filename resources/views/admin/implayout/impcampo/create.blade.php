<!-- Modal -->
<div id="myModalImpCampo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formImpCampo"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="LayoutId" value="{{$ImpLayout->LayoutId}}">


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoNm">Campo - Arquivo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('CampoNm') }}"  type="text" id="CampoNm" name="CampoNm" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoDB">Campo - BD <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('CampoDB') }}"  type="text" id="CampoDB" name="CampoDB" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoPK">PK ?
                        </label>
                        <div class="col-md-7" style="margin-top: 5px">
                            <label style="">
                                <input type="checkbox" id="CampoPK" name="CampoPK" value="1" class="js-switch" >
                            </label>
                        </div>
                    </div>


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoValorFixo">Valor Fixo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('CampoValorFixo') }}"  type="text" id="CampoValorFixo" name="CampoValorFixo"  class="form-control col-md-7 col-xs-12">
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