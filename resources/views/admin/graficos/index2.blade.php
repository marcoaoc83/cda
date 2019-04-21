@extends('layouts.app')

@section('styles')
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css" rel="stylesheet">
    <style>
        /*Now the CSS*/
        * {margin: 0; padding: 0;}

        .tree ul {
            padding-top: 20px; position: relative;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left; text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*We will use ::before and ::after to draw the connectors*/

        .tree li::before, .tree li::after{
            content: '';
            position: absolute; top: 0; right: 50%;
            border-top: 1px solid #ccc;
            width: 50%; height: 20px;
        }
        .tree li::after{
            right: auto; left: 50%;
            border-left: 1px solid #ccc;
        }

        /*We need to remove left-right connectors from elements without
        any siblings*/
        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }

        /*Remove space from the top of single children*/
        .tree li:only-child{ padding-top: 0;}

        /*Remove left connector from first child and
        right connector from last child*/
        .tree li:first-child::before, .tree li:last-child::after{
            border: 0 none;
        }
        /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before{
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }
        .tree li:first-child::after{
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        /*Time to add downward connectors from parents*/
        .tree ul ul::before{
            content: '';
            position: absolute; top: 0; left: 50%;
            border-left: 1px solid #ccc;
            width: 0; height: 20px;
        }

        .tree li a{
            border: 1px solid #ccc;
            padding: 5px 10px;
            text-decoration: none;
            color: #666;
            font-family: arial, verdana, tahoma;
            font-size: 14px;
            display: inline-block;

            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*Time for some hover effects*/
        /*We will apply the hover effect the the lineage of the element also*/
        .tree li a:hover, .tree li a:hover+ul li a {
            background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
        }
        /*Connector styles on hover*/
        .tree li a:hover+ul li::after,
        .tree li a:hover+ul li::before,
        .tree li a:hover+ul::before,
        .tree li a:hover+ul ul::before{
            border-color:  #94a0b4;
        }

        /*Thats all. I hope you enjoyed it.
        Thanks :)*/
    </style>
@endsection
@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Graficos</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Organograma</h2>

                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class=" centered">
                            <div class="tree" >
                                <ul>
                                    <li>
                                        <a href="#">DASHBOARD - CDA-E</a>
                                        <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                        <ul>
                                            @foreach($graficos as $grafico)
                                                <li id="grafico{!! $grafico['graf_id'] !!}">
                                                    <a href="javascript:;" >
                                                        <p><b>{!! $grafico['graf_titulo'] !!}</b></p>
                                                        @if(count($grafico['children_rec'])==0)
                                                            <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}?pai={!! $grafico['graf_id'] !!}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                                        @endif
                                                        <button href="javascript:;" onclick="location.href='graficos/{!! $grafico['graf_id'] !!}/edit/'"  class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                                        <button  href="javascript:;" onclick="deleteGraficos({!! $grafico['graf_id'] !!})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                    </a>

                                                    @foreach($grafico['children_rec'] as $grafico1)
                                                        <ul id="grafico{!! $grafico1['graf_id'] !!}">
                                                            <a href="#" >
                                                                {!! $grafico1['graf_titulo'] !!}<br>
                                                                @if(count($grafico1['children_rec'])==0)
                                                                    <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}?pai={!! $grafico1['graf_id'] !!}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                                                @endif
                                                                <button href="javascript:;" onclick="location.href='graficos/{!! $grafico1['graf_id'] !!}/edit/'"  class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                                                <button  href="javascript:;" onclick="deleteGraficos({!! $grafico1['graf_id'] !!})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                            </a>
                                                            @foreach($grafico1['children_rec'] as $grafico2)
                                                                <ul id="grafico{!! $grafico2['graf_id'] !!}">
                                                                    <a href="#" >
                                                                        {!! $grafico2['graf_titulo'] !!}<br>
                                                                        @if(count($grafico2['children_rec'])==0)
                                                                            <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}?pai={!! $grafico2['graf_id'] !!}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                                                        @endif
                                                                        <button href="javascript:;" onclick="location.href='graficos/{!! $grafico2['graf_id'] !!}/edit/'"  class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                                                        <button  href="javascript:;" onclick="deleteGraficos({!! $grafico2['graf_id'] !!})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                                    </a>
                                                                    @foreach($grafico2['children_rec'] as $grafico3)
                                                                        <ul id="grafico{!! $grafico3['graf_id'] !!}">
                                                                            <a href="#" >
                                                                                {!! $grafico3['graf_titulo'] !!}<br>
                                                                                @if(count($grafico3['children_rec'])==0)
                                                                                    <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}?pai={!! $grafico3['graf_id'] !!}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                                                                @endif
                                                                                <button href="javascript:;" onclick="location.href='graficos/{!! $grafico3['graf_id'] !!}/edit/'"  class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                                                                <button  href="javascript:;" onclick="deleteGraficos({!! $grafico3['graf_id'] !!})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                                            </a>
                                                                            @foreach($grafico3['children_rec'] as $grafico4)
                                                                                <ul id="grafico{!! $grafico4['graf_id'] !!}">
                                                                                    <a href="#" >
                                                                                        {!! $grafico4['graf_titulo'] !!}<br>
                                                                                        @if(count($grafico4['children_rec'])==0)
                                                                                            <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}?pai={!! $grafico4['graf_id'] !!}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                                                                        @endif
                                                                                        <button href="javascript:;" onclick="location.href='graficos/{!! $grafico4['graf_id'] !!}/edit/'"  class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                                                                        <button  href="javascript:;" onclick="deleteGraficos({!! $grafico4['graf_id'] !!})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                                                    </a>
                                                                                    @foreach($grafico4['children_rec'] as $grafico5)
                                                                                        <ul id="grafico{!! $grafico5['graf_id'] !!}">
                                                                                            <a href="#" >
                                                                                                {!! $grafico5['graf_titulo'] !!}<br>
                                                                                                @if(count($grafico5['children_rec'])==0)
                                                                                                    <button href="javascript:;" onclick="location.href='{{route('graficos.create')}}?pai={!! $grafico5['graf_id'] !!}'"  class="btn btn-xs btn-success"><i class="fa fa-plus-circle"></i></button>
                                                                                                @endif
                                                                                                <button href="javascript:;" onclick="location.href='graficos/{!! $grafico5['graf_id'] !!}/edit/'"  class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                                                                                <button  href="javascript:;" onclick="deleteGraficos({!! $grafico5['graf_id'] !!})" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button>
                                                                                            </a>
                                                                                        </ul>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                        </ul>
                                                    @endforeach
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    @include('vendor.sweetalert.cdn')
    @include('vendor.sweetalert.view')
    @include('vendor.sweetalert.validator')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('graficos.getdata') }}',
                columns: [
                    {data: 'graf_id', name: 'graf_id'},
                    {data: 'graf_titulo', name: 'graf_titulo'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
            });
        });

        function deleteGraficos(dataId) {
            swal({
                title             : "Tem certeza?",
                text              : "Este Item será deletada!",
                type              : "warning",
                showCancelButton  : true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText : "Sim",
                cancelButtonText  : "Não"
            }).then((resultado) => {
                if (resultado.value) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _method: 'DELETE',
                        _token: '{!! csrf_token() !!}',
                    },
                    url: '{{ url('admin/graficos') }}' + '/' + dataId,
                    success: function( msg ) {
                        $('#grafico'+dataId).remove();
                        swal({
                            position: 'top-end',
                            type: 'success',
                            title: 'Deletado com sucesso!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function( data ) {
                        swal({
                            position: 'top-end',
                            type: 'error',
                            title: 'Erro ao deletar!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            }
        });
    };
    </script>
@endpush