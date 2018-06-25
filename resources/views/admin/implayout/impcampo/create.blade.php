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
                    <input type="hidden" id="ArquivoId" name="ArquivoId">

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="OrdTable">Ord Table<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('OrdTable') }}"  type="number" id="OrdTable" name="OrdTable" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TabelaDB">Tabela BD <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="TabelaDB" name="TabelaDB" required="required"  onchange="reloadCampo('#formImpCampo #CampoDB',this.value)">
                                <option value=""></option>
                                    @foreach($Tabelas as $var)
                                        <option value="{{$var->alias}}">{{$var->nome}}</option>             
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoDB">Campo no BD <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="CampoDB" name="CampoDB" required="required">
                                <option value=""></option>
                                    @foreach($Campos as $var)
                                        @if ($ImpLayout->LayoutTabela === $var->tabela)
                                            <option value="{{$var->coluna}}">{{$var->coluna}}</option> 
                                        @endif           
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoNm">Coluna do Arquivo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('CampoNm') }}"  type="text" id="CampoNm" name="CampoNm"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>


                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="TipoDados">Tipo Dados<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="TipoDados" name="TipoDados" required="TipoDados" >
                                <option value=""></option>
                                <option value="data">Data</option>
                                <option value="moedabr">Moeda BR</option>
                                <option value="moedaus">Moeda US</option>
                                <option value="decimal">Decimal</option>
                                <option value="hora">Hora</option>
                                <option value="int">Inteiro</option>
                                <option value="char">Texto</option>
                                <option value="text">Texto Longo</option>
                            </select>
                        </div>
                    </div>

                    <div class="item form-group ">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Campo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12"  data-toggle="buttons">
                            <label class="btn btn-default active " onclick="$('.TFixo').addClass('hidden');$('.TFK').addClass('hidden');">
                                <input type="radio" name="CampoTipo" id="TComum" value="1" checked="checked" >Comum
                            </label>
                            <label class="btn btn-default "  onclick="$('.TFixo').removeClass('hidden');$('.TFK').addClass('hidden');">
                                <input type="radio" name="CampoTipo" id="TFixo" value="2">Fixo
                            </label>
                            <label class="btn btn-default " onclick="$('.TFixo').addClass('hidden');$('.TFK').removeClass('hidden');">
                                <input type="radio" name="CampoTipo" id="TFK" value="3"   >FK
                            </label>
                        </div>
                    </div>

                    {{--<div class="item form-group">--}}
                        {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoPK">PK ?--}}
                        {{--</label>--}}
                        {{--<div class="col-md-7" style="margin-top: 5px">--}}
                            {{--<label style="">--}}
                                {{--<input type="checkbox" id="CampoPK" name="CampoPK" value="1" class="js-switch" >--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}


                    <div class="item form-group hidden TFixo">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CampoValorFixo">Valor Fixo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('CampoValorFixo') }}"  type="text" id="CampoValorFixo" name="CampoValorFixo"  class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>


                    <div class="item form-group hidden TFK">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FKTabela">Tabela</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="FKTabela" name="FKTabela" onchange="reloadCampo('#formImpCampo #FKCampo',this.value)">
                                <option value=""></option>
                                @foreach($Tabelas as $var)
                                    <option value="{{$var->alias}}">{{$var->nome}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="item form-group hidden TFK">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FKCampo">Campo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="FKCampo" name="FKCampo">
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