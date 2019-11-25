<script type="text/javascript">

    $(document).ready(function() {

var tbParcela = $('#tbParcela').DataTable({
    processing: true,
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
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