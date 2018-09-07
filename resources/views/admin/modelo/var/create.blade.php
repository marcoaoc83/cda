<!-- Modal -->
<div id="myModalModeloVar" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formModeloVar"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="ModComId" value="{{$modelo->ModComId}}">
                    <input type="hidden" id="var_id" name="var_id">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Título<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="var_titulo" class="form-control col-md-7 col-xs-12" name="var_titulo"  required="required" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Código<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="var_codigo" class="form-control col-md-7 col-xs-12" name="var_codigo"  required="required" type="text">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="var_tabela">Tabela BD <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="var_tabela" name="var_tabela" required="required"  onchange="reloadCampo('#formModeloVar #var_campo',this.value)">
                                <option value=""></option>
                                    @foreach($Tabelas as $var)
                                    <option value="{{$var->alias}}">{{$var->nome}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="var_campo">Campo no BD <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="var_campo" name="var_campo" required="required">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="var_tipo">Tipo<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="var_tipo" name="var_tipo" required="required">
                                <option value="array">Arvore (Array)</option>
                                <option value="cep">CEP</option>
                                <option value="cnpj">CNPJ</option>
                                <option value="cod_barras">Código de Barras</option>
                                <option value="contador">Contador</option>
                                <option value="cpf">CPF</option>
                                <option value="data">Data</option>
                                <option value="datahora">Data - Hora</option>
                                <option value="hora">Hora</option>
                                <option value="inteiro">Inteiro</option>
                                <option value="moeda">Moeda</option>
                                <option value="sum">Soma</option>
                                <option value="text" selected>Texto</option>
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
