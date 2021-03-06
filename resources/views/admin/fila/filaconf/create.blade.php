<!-- Modal -->
<div id="myModalFilaConf" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Inserir</h4>
            </div>
            <div class="modal-body">
                <form id="formFilaConf"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="FilaTrabId" value="{{$Fila->FilaTrabId}}">



                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaConfId">Variáveis<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="FilaConfId" name="FilaConfId" required="required">
                                <option value=""></option>
                                @foreach($RegTab as $var)
                                    @if($var->TABSYSID != 35) @continue @endif;
                                    <option value="{{$var->REGTABID}}" data-tabtab="{{$var->TABSYSID}}"  >{{$var->REGTABSG}} - {{$var->REGTABNM}}</option>             
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="FilaConfDs">Descrição <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input value="{{ old('FilaConfDs') }}"  type="text" id="FilaConfDs" name="FilaConfDs" required="required" class="form-control col-md-7 col-xs-12">
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