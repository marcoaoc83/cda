<script type="text/javascript">
    function updateDataTableSelectAllCtrl(tbParcela){
        var $table             = tbParcela.table().node();
        var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

        // If none of the checkboxes are checked
        if($chkbox_checked.length === 0){
            chkbox_select_all.checked = false;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
            }

            // If all of the checkboxes are checked
        } else if ($chkbox_checked.length === $chkbox_all.length){
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = false;
            }

            // If some of the checkboxes are checked
        } else {
            chkbox_select_all.checked = true;
            if('indeterminate' in chkbox_select_all){
                chkbox_select_all.indeterminate = true;
            }
        }
    }
    $(document).ready(function() {
        var rows_selected = [];

var tbParcela = $('#tbParcela').DataTable({
processing: true,
serverSide: true,
responsive: true,
ajax: '{{ route('execfila.getdataParcela') }}'+"/?limit=0",
"pageLength": 100,
columns: [
{
'targets': 0,
'searchable': false,
'orderable': false,
'width': '1%',
'className': 'dt-body-center',
'render': function (data, type, full, meta){
return '<input type="checkbox">';
}
},
{data: 'Carteira', name: 'Carteira'},
{data: 'Nome', name: 'Nome'},
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
targets: 10,
className: 'text-right'
}
],
"language": {
"url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
},
'rowCallback': function(row, data, dataIndex){
// Get row ID
var rowId = data['ParcelaId'];

// If row ID is in the list of selected row IDs
if($.inArray(rowId, rows_selected) !== -1){
$(row).find('input[type="checkbox"]').prop('checked', true);
$(row).addClass('selected');
}
}
});

// Handle click on checkbox
$('#tbParcela tbody').on('click', 'input[type="checkbox"]', function(e){
var $row = $(this).closest('tr');

// Get row data
var data = tbParcela.row($row).data();

// Get row ID
var rowId = data['ParcelaId'];

// Determine whether row ID is in the list of selected row IDs
var index = $.inArray(rowId, rows_selected);

// If checkbox is checked and row ID is not in list of selected row IDs
if(this.checked && index === -1){
rows_selected.push(rowId);

// Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
} else if (!this.checked && index !== -1){
rows_selected.splice(index, 1);
}

if(this.checked){
$row.addClass('selected');
} else {
$row.removeClass('selected');
}

// Update state of "Select all" control
updateDataTableSelectAllCtrl(tbParcela);

// Prevent click event from propagating to parent
e.stopPropagation();
});

// Handle click on table cells with checkboxes
$('#tbParcela').on('click', 'tbody td, thead th:first-child', function(e){
$(this).parent().find('input[type="checkbox"]').trigger('click');
});

// Handle click on "Select all" control
$('thead input[name="select_all"]', tbParcela.table().container()).on('click', function(e){
if(this.checked){
$('#tbParcela tbody input[type="checkbox"]:not(:checked)').trigger('click');
} else {
$('#tbParcela tbody input[type="checkbox"]:checked').trigger('click');
}

// Prevent click event from propagating to parent
e.stopPropagation();
});

// Handle table draw event
tbParcela.on('draw', function(){
// Update state of "Select all" control
updateDataTableSelectAllCtrl(tbParcela);
});


    }); // document ready


</script>