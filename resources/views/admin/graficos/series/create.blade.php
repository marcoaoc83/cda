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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_titulo">Titulo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('grse_titulo') }}"  type="text" id="grse_titulo" name="grse_titulo" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group sql">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">SQL - CAMPO</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" rows="3" id="grse_sql_campo" name="grse_sql_campo"></textarea>

                        </div>
                    </div>
                    <div class="form-group sql">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">SQL - CONDIÇÃO</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control" rows="3" id="grse_sql_condicao" name="grse_sql_condicao"></textarea>

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grse_grafico_ref">Link Gráfico
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="grse_grafico_ref" name="grse_grafico_ref" >
                                <option value=""></option>
                                @foreach($GraficosAll as $var)
                                    <option value="{{$var->graf_id}}" >{{$var->graf_titulo}}</option>             
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