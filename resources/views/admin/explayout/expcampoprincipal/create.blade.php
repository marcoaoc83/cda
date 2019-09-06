<!-- Modal -->
<div id="myModalExpCampoPrincipal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formExpCampoPrincipal"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="epc_layout_id" value="{{$ExpLayout->exp_id}}">


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="epc_ord">Ordem<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('epc_ord') }}"  type="number" id="epc_ord" name="epc_ord" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="epc_titulo">Título <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value=" "  type="text" id="epc_titulo" name="epc_titulo" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="epc_campo">Campo no BD <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="epc_campo" name="epc_campo" required="required">
                                <option value=""></option>
                                    @foreach($Campos as $var)
                                        @if ($ExpLayout->exp_tabela === $var->tabela)
                                            <option value="{{$var->coluna}}">{{$var->coluna}}</option> 
                                        @endif           
                                    @endforeach
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