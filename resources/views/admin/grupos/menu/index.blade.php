@section('styles')
    <link href="{{asset('menutree/bs-iconpicker/css/bootstrap-iconpicker.min.css')}}" rel="stylesheet">
@endsection
<div class="x_panel" id="pnRoteiro">


        <div class="page-title">
            <div class="title_left">
                <h3>Menus</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body" id="cont">
                        <ul id="myEditor" class="sortableLists list-group">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</div>


@push('scripts')
    <script src="{{ url('menutree/bs-iconpicker/js/iconset/iconset-fontawesome-4.7.0.min.js')}}"></script>
    <script src="{{ url('menutree/bs-iconpicker/js/bootstrap-iconpicker.js')}}"></script>
    <script src="{{ url('menutree/jquery-menu-editor.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            //icon picker options
            var iconPickerOptions = '';

            //sortable list options
            var sortableListOptions = {
                placeholderCss: {'background-color': '#34495E'}
            };

            var editor = new MenuEditor(
                'myEditor',
                {
                    listOptions:    sortableListOptions,
                    iconPicker:     iconPickerOptions,
                    labelEdit:      'Edit'
                });
            editor.setData({!! $Menu !!});

            $('#btnOut').on('click', function () {
                var str = editor.getString();
                $("#fun_menu_json").val((str));
                $('#send').trigger('click');
            });
        });
    </script>
@endpush