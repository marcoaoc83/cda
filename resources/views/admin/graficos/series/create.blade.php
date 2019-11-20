<!-- Modal -->
<div id="myModalSeries" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formSeries"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="grse_grafico_id" value="{{$Graficos->graf_id}}">
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_tipo">Tipo</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="grse_tipo" name="grse_tipo">
                                @foreach($Tipo as $var)
                                    <option value="{{$var->grti_id}}">{{strtoupper($var->grti_nome)}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_titulo">Titulo <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('grse_titulo') }}" id="grse_titulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="grse_titulo"  required="required" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_subtitulo">Subtítulo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('grse_subtitulo') }}" id="grse_subtitulo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="grse_subtitulo"  required="required" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_sql_valor">SQL - Valor <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('grse_sql_valor') }}" id="grse_sql_valor"  name="grse_sql_valor"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" required="required" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_sql_campo">SQL - Alias  <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('grse_sql_campo') }}" id="grse_sql_campo"  name="grse_sql_campo"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" required="required" type="text">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_sql_condicao">SQL - Condição <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="grse_sql_condicao" id="grse_sql_condicao" rows="5" class="resizable_textarea form-control">{{ old('grse_sql_condicao') }}</textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_sql_agrupamento">SQL - Agrupamento <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('grse_sql_agrupamento') }}" id="grse_sql_agrupamento"  name="grse_sql_agrupamento"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">
                        </div>
                    </div>
                    {{--<div class="item form-group">--}}
                        {{--<label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_sql_ordenacao">SQL - Ordenação <span class="required">*</span>--}}
                        {{--</label>--}}
                        {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                            {{--<input value="{{ old('grse_sql_ordenacao') }}" id="grse_sql_ordenacao"  name="grse_sql_ordenacao"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" type="text">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_eixoy">SQL - Valor <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="1" id="grse_eixoy"  name="grse_eixoy"   class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" required="required" type="text">
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