<!-- Modal -->

<div id="myModalPsCanalEdita" class="modal fade" role="dialog">
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
                    <input type="hidden" id="PessoaId"      name="PessoaId" >
                    <input type="hidden" id="PsCanalId"     name="PsCanalId">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FonteInfoId">Fonte </label><span class="required">*</span>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="FonteInfoId" name="FonteInfoId" required="required">
                                <option value=""></option>
                                @foreach($FonteInfoId as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CanalId">Canal </label><span class="required">*</span>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="CanalId" name="CanalId" required="required" onchange="selectCanalForm(this.value,'formEditar')">
                                <option value=""></option>
                                @foreach($Canal as $var)
                                    <option value="{{$var->CANALID}}" >{{$var->CANALNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TipPosId">Tip Pos </label><span class="required">*</span>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="TipPosId" name="TipPosId" required="required">
                                <option value=""></option>
                                @foreach($TipPos as $var)
                                    <option value="{{$var->REGTABID}}" >{{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TelefoneNr">Telefone
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="TelefoneNr" name="TelefoneNr"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">Email
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input  type="text" id="Email" name="Email"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CEP">CEP
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="CEP" name="CEP"  onchange="buscacep(this.value,'formEditar')"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Logradouro">Logradouro
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="Logradouro" name="Logradouro" readonly  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EnderecoNr">Nº
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="EnderecoNr" name="EnderecoNr"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Complemento">Complemento
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="Complemento" name="Complemento"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Bairro">Bairro
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="Bairro" name="Bairro" readonly class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Cidade">Cidade
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="Cidade" name="Cidade" readonly class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="UF">UF
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="UF" name="UF" readonly class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>



                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" form="formEditar" class="btn btn-success" id="btnSalvar_edt">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>