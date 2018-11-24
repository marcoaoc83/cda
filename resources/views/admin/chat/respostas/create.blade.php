<!-- Modal -->
<div id="myModalRespostas" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formRespostas"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="resp_intents_slug" id="resp_intents_slug" value="{{$Chat->slug}}">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Texto<span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input value="{{ old('resp_texto') }}" id="resp_texto" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="resp_texto"  required="required" type="text">
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