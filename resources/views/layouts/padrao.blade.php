<!DOCTYPE html>
<html lang="en">
@include('partials._head')

<body class="nav-md" >
<div class="container body">

    <div class="main_container">

        <!-- page content  -->
    @yield('content')

    <!-- /page content -->

    </div>
</div>

<script src="{{asset('js/app.js')}}"></script>
@include('partials._notification')
@stack('scripts')

</body>
</html>