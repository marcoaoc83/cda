<!DOCTYPE html>
<html lang="en">
@include('partials._head')

<body class="nav-md" >
<div class="container body">

    <div class="main_container">

        @if(auth()->user()->funcao==1)
            {{--top nav--}}
            @include('partials._sidenav')
            {{--/topnav--}}
        @else
            {{--top nav--}}
            @include('partials._sidenav2')
            {{--/topnav--}}
        @endif

    <!-- top navigation -->
    @include('partials._topnav')
    <!-- /top navigation -->

        <!-- page content  -->
        @yield('content')

        <!-- /page content -->

        <!-- footer content -->
    @include('partials._footer')
    <!-- /footer content -->
    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
@include('partials._notification')
@stack('scripts')

</body>
</html>