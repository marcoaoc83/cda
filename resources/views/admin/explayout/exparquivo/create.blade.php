<!-- Modal -->
<div id="myModalExpArquivo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formExpArquivo"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="ext_layout_id" id="ext_layout_id" value="{{$ExpLayout->exp_id}}">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_nome">Nome <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('ext_nome') }}"  type="text" id="ext_nome" name="ext_nome" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_tabela">Tabela<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ext_tabela" name="ext_tabela" required="required"  onchange="reloadCampo('#formExpArquivo #ext_campo',this.value);reloadCampo('#formExpArquivo #ext_campo_fk',$('#exp_tabela').val())">
                                <option value=""></option>
                                @foreach($Tabelas as $var)
                                    <option value="{{$var->alias}}">{{$var->nome}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_campo">Campo <span class="required">*</span> </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ext_campo" name="ext_campo" required="required">
                                <option value=""></option>

                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ext_campo_fk">Campo Ref - FK <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="ext_campo_fk" name="ext_campo_fk" required="required">
                                <option value=""></option>

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