<!-- Modal -->
<div id="myModalExpCampoPrincipalEdita" class="modal fade" role="dialog">
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
                    <input type="hidden" name="exp_id" value="{{$ExpLayout->exp_id}}">

                    <input type="hidden" name="epc_id" id="epc_id" value="">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="epc_ord">Ordem<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('epc_ord') }}"  type="number" id="epc_ord" name="epc_ord" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="epc_titulo">Título <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ $ExpLayout->epc_titulo }}"  type="text" id="epc_titulo" name="epc_titulo" required="required" class="form-control col-md-7 col-xs-12">
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
                            <button type="submit" class="btn btn-success" id="btnSalvar_edt">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>