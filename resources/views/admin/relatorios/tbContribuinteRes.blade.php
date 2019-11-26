<script type="text/javascript">

    $(document).ready(function() {
        var oldExportAction = function (self, e, dt, button, config) {
            if (button[0].className.indexOf('buttons-excel') >= 0) {
                if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                }
                else {
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                }
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
        };

        var newExportAction = function (e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;

            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;

                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    oldExportAction(self, e, dt, button, config);

                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });

                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);

                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });

            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        };
        var oldExportActionCSV = function (self, e, dt, button, config) {
            if (button[0].className.indexOf('buttons-csv') >= 0) {
                if ($.fn.dataTable.ext.buttons.csvHtml5.available(dt, config)) {
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config);
                }
                else {
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config);
                }
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
        };

        var newExportActionCSV = function (e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;

            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;

                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    oldExportActionCSV(self, e, dt, button, config);

                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });

                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);

                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });

            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        };
        var tbContribuinteRes = $('#tbContribuinteRes').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: '{{ route('relatorios.getdataParcela') }}'+"/?none=1",
            select: {
                style: 'multi',
                info:false
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    action: newExportAction
                },
                {
                    extend: 'csv',
                    action: newExportActionCSV
                }
            ],
            columns: [
                {data: 'PESSOANMRS', name: 'PESSOANMRS'},
                {data: 'CPF_CNPJNR', name: 'CPF_CNPJNR'},

                {data: 'VencimentoDt', name: 'VencimentoDt'},
                {data: 'TotalVr', name: 'TotalVr'},
                {data: 'FxAtraso', name: 'FxAtraso'},
                {data: 'FxValor', name: 'FxValor'},
                {
                    data: 'PessoaId',
                    name: 'PessoaId',
                    "visible": false,
                    "searchable": false
                },
            ],
            columnDefs: [
                {
                    targets: 3,
                    className: 'text-right'
                },
                {
                    targets: 4,
                    className: 'text-right'
                }
            ],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
            }
        });

        tbContribuinteRes.on( 'select', function ( e, dt, type, indexes ) {
            if ( type === 'row' ) {
                var ContribuinteResId = tbContribuinteRes.rows( indexes ).data().pluck( 'PessoaId' );
                $('#formFiltroParcela').append('<input type="hidden" class="filtroRes"  id="ContribuinteResId'+ContribuinteResId[0]+'" name="ContribuinteResId[]" value='+ContribuinteResId[0]+' />');

                var tbIMRes = $('#tbIMRes').DataTable();
                var url = "{{ route('relatorios.getdataParcela') }}"+"/?group=IM&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&filtro=1';
                tbIMRes.ajax.url(url).load();

                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('relatorios.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&filtro=1';
                tbParcela.ajax.url(url).load();
            }
        }).on( 'deselect', function ( e, dt, type, indexes ){
            if ( type === 'row' ) {
                var ContribuinteResId = tbContribuinteRes.rows( indexes ).data().pluck( 'PessoaId' );
                $( "#ContribuinteResId"+ContribuinteResId[0] ).remove();

                var tbIMRes = $('#tbIMRes').DataTable();
                var url = "{{ route('relatorios.getdataParcela') }}"+"/?group=IM&"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&filtro=1';
                tbIMRes.ajax.url(url).load();

                var tbParcela = $('#tbParcela').DataTable();
                var url = "{{ route('relatorios.getdataParcela') }}"+"/?"+$('#formFiltroParcela').serialize()+'&FilaTrabId='+$('#FilaTrabId').val()+'&filtro=1';
                tbParcela.ajax.url(url).load();
            }
        });

    }); // document ready


</script>