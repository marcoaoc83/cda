<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Perfil">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" class="open" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" id="block" title="Bloquear">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Sair"  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
</div>

@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-fullscreen-plugin/1.1.4/jquery.fullscreen-min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.open').click(function() {
                $(document).fullScreen(true);
                return false;
            });
            $('.close').click(function() {
                $.fullscreen.exit();
                return false;
            });
        });
        $(document).ready(function() {
            $('#block').click(function() {
                $.blockUI({ message: '<h1>Tela bloqueada</h1>' });
                $('.blockOverlay').click($.unblockUI);
            });
        });
    </script>
@endpush
<!-- /menu footer buttons -->