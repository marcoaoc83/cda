<!-- Modal -->
<div id="myModalImpArquivoEdita" class="modal fade" role="dialog">
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
                    <input type="hidden" name="LayoutId" value="{{$ImpLayout->LayoutId}}">
                    <input type="hidden" name="ArquivoId" id="ArquivoId" value="">


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ArquivoOrd">Ord<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('ArquivoOrd') }}"  type="text" id="ArquivoOrd" name="ArquivoOrd" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ArquivoDs">Arq Origem<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('ArquivoDs') }}"  type="text" id="ArquivoDs" name="ArquivoDs" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TpArqId">Tp Arq<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="TpArqId" name="TpArqId" required="required">
                                <option value=""></option>
                                    @foreach($TpArq as $var)
                                        <option value="{{$var->REGTABID}}">{{$var->REGTABNM}}</option>             
                                    @endforeach
                            </select>
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