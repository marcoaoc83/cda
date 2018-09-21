<!DOCTYPE html>
<html lang="en">
@include('portal.index.header')

<body>
    <div id="PF">

        <!-- top navigation -->
        @include('portal.index.menu')
        <!-- /top navigation -->

            <!-- page content  -->
        @yield('content')

        <!-- /page content -->

            <!-- footer content -->
        @include('portal.index.footer')
        <!-- /footer content -->
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/efeitos.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.1.0/js/all.js" data-auto-replace-svg="nest"></script>
@stack('scripts')

</body>
</html>