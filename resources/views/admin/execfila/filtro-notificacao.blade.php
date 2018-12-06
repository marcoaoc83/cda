{{--Filtro Notificacao--}}
<div class="col-md-12 col-sm-12 col-xs-12 " id="divFiltroNotificacao" >
    <div class="x_panel col-md-5 col-sm-5 col-xs-5 " >
        <div class="x_title">
            <h2>Filtro Notificação</h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content " style="display: none;">
            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                <div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
                    <input readonly type="text" class="form-control has-feedback-left date-picker" style="padding-right: 1px !important;" placeholder="Inicio" id="notInicio" name="notInicio" aria-describedby="inputSuccess2Status">
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12 form-group has-feedback">
                    <input readonly type="text" class="form-control has-feedback-left date-picker"  style="padding-right: 1px !important;" placeholder="Final" id="notFinal" name="notFinal" aria-describedby="inputSuccess2Status">
                    <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                    <span id="inputSuccess2Status" class="sr-only">(success)</span>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-12 form-group has-feedback">
                    <div class="item form-group">
                        <label for="notUltimo">Último Evento</label>
                        <label><input type="checkbox" id="notUltimo"   name="notUltimo"  value="1" class="js-switch" ></label>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                    <div class="item form-group">
                        <input  id="notLote"  name="notLote" placeholder="Nº Lote" class="form-control col-md-7 col-xs-12" type="number">
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 form-group has-feedback">
                    <div class="item form-group">
                        <input  id="notNotificacao"  name="notNotificacao"  placeholder="Nº Notificação" class="form-control col-md-7 col-xs-12"  type="number">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>