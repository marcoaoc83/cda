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
var tbParcela = $('#tbParcela').DataTable({
    processing: true,
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

    serverSide: true,
    responsive: true,
    ajax: '{{ route('relatorios.getdataParcela') }}'+"/?none=1",
    "pageLength": 100,
    columns: [

        {data: 'Carteira', name: 'Carteira'},
        {data: 'Modelo', name: 'Modelo'},
        {data: 'PESSOANMRS', name: 'PESSOANMRS'},
        {data: 'CPF_CNPJNR', name: 'CPF_CNPJNR'},
        {data: 'INSCRMUNNR', name: 'INSCRMUNNR'},
        {data: 'SitPag', name: 'SitPag'},
        {data: 'SitCob', name: 'SitCob'},
        {data: 'OrigTrib', name: 'OrigTrib'},
        {data: 'Trib', name: 'Trib'},
        {data: 'LancamentoNr', name: 'LancamentoNr'},
        {data: 'ParcelaNr', name: 'ParcelaNr'},
        {data: 'PlanoQt', name: 'PlanoQt'},
        {data: 'VencimentoDt', name: 'VencimentoDt'},
        {data: 'TotalVr', name: 'TotalVr'},
        // {data: 'FxAtraso', name: 'FxAtraso'},
        // {data: 'FxValor', name: 'FxValor'},
        {
        data: 'ParcelaId',
        name: 'ParcelaId',
        "visible": false,
        "searchable": false
        },
        ],
        columnDefs: [
            {
            targets: 13,
            className: 'text-right'
            },
            {
            targets: 14,
            className: 'text-right'
            },
        ],
        "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
        },
});

 }); // document ready


</script>