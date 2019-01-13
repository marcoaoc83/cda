<!-- Modal -->

<div id="myModalRetorno" class="modal fade" role="dialog">
    <div class="modal-dialog modal-full">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Retorno</h4>
            </div>
            <div class="modal-body">
                <form id="formRetorno"  class="form-horizontal form-label-left" >
                    {{ csrf_field() }}
                    <input type="hidden" name="PessoaId"    id="PessoaId">
                    <input type="hidden" name="PsCanalId"   id="PsCanalId">
                    <input type="hidden" name="CanalId"     id="CanalId">
                    @foreach($Trat as $var)
                        <div class="col-md-3 col-sm-3 col-xs-12 TratCanal{!! $var->CanalId !!}"  style="height: 50px;display: none">

                                <label class="control-label col-md-9 col-sm-9 col-xs-12" for="TratRetId{!! $var->TratRetId !!}">{!! $var->RetornoCd !!}
                                </label>
                                <div class="col-md-3" style="margin-top: 5px">
                                    <label style="">
                                        <input type="checkbox" id="TratRetId{!! $var->TratRetId !!}" name="TratRetId[]" value="{!! $var->EventoId !!}"   >
                                    </label>
                                </div>
                        </div>
                    @endforeach
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-6">
                            <button type="submit" class="btn btn-success" id="btnSalvar">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
