<script>
    function chartAcionamentos() {
        $('#area-chart').empty();
        $.ajax({
            url:"{{route('graficos.acionamentos')}}",
            type : 'POST',
            dataType: "json",
            data: {
                dados: $('#formFiltro').serialize(),
                _token: '{!! csrf_token() !!}',
            },
            success : function(response){

                config = {
                    data: response,
                    xkey: 'y',
                    ykeys: ['a'],
                    labels: ['Total'],
                    fillOpacity: 0.6,
                    hideHover: 'auto',
                    behaveLikeLine: true,
                    resize: true,
                    pointFillColors:['#ffffff'],
                    pointStrokeColors: ['black'],
                    lineColors:['#26B99A' ]
                };
                config.element = 'area-chart';
                Morris.Area(config);
            },
            error : function() {
                console.log('Error');
            }
        });
    };
    function chartOrigem() {
        $('#pie-chart-origem').empty();
        $.ajax({
            url:"{{route('graficos.origem')}}",
            type : 'POST',
            dataType: "json",
            data: {
                dados: $('#formFiltro').serialize(),
                _token: '{!! csrf_token() !!}',
            },
            success : function(response){
                config = {
                    data: response,
                    colors:["#172D44","#26B99A","#8BE1CF"]
                };
                config.element = 'pie-chart-origem';
                Morris.Donut(config);
            },
            error : function() {
                console.log('Error');
            }
        });
    };
    function chartCarteira() {
        $('#pie-chart-carteira').empty();
        $.ajax({
            url:"{{route('graficos.carteira')}}",
            type : 'POST',
            dataType: "json",
            data: {
                dados: $('#formFiltro').serialize(),
                _token: '{!! csrf_token() !!}',
            },
            success : function(response){
                config = {
                    data: response,
                    colors:["#172D44","#26B99A","#8BE1CF","RED","YELLOW","GRAY"],
                    formatter:function (y, data) { return y + '%'}
                };
                config.element = 'pie-chart-carteira';
                Morris.Donut(config);
            },
            error : function() {
                console.log('Error');
            }
        });
    };


    function chartFase() {
        $('#pie-chart-fase').empty();
        $.ajax({
            url:"{{route('graficos.fase')}}",
            type : 'POST',
            dataType: "json",
            data: {
                dados: $('#formFiltro').serialize(),
                _token: '{!! csrf_token() !!}',
            },
            success : function(response){
                config = {
                    data: response,
                    colors:["#172D44","#26B99A","#8BE1CF","RED","YELLOW","GRAY"],
                    formatter:function (y, data) { return y + '%'}
                };
                config.element = 'pie-chart-fase';
                Morris.Donut(config);
            },
            error : function() {
                console.log('Error');
            }
        });
    };
    var data = [
            { y: '0..1m', a: 400000 },
            { y: '1..3m', a: 670000 },
            { y: '3..6m', a: 450000 },
            { y: '6..12m', a: 500000 },
            { y: '1..2a', a: 650000 },
            { y: '2..3a', a: 500000 },
            { y: '3..4a', a: 750000 },
            { y: '4..5a', a: 800000 },
            { y: '5a..', a:  900000  },
        ],
        config = {
            data: data,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Total'],
            fillOpacity: 0.6,
            hideHover: 'auto',
            behaveLikeLine: true,
            resize: true,
            pointFillColors:['#ffffff'],
            pointStrokeColors: ['black'],
            barColors:['#26B99A' ]
        };
    config.element = 'bar-chart';
    Morris.Bar(config);

    $( ".filt" ).click(function() {

        $(this).button('toggle');
        $(this).button('dispose');
        $(this).trigger("blur");
        $nome=$( this ).data( "nome" );
        $valor=$( this ).val();
        if( $( this ).hasClass( "active" )){
            $('#formFiltro').append('<input type="hidden" id="'+$nome+$valor+'" name="'+$nome+'[]" value='+$valor+' />');
        }else{
            $( "#formFiltro #"+$nome+$valor ).remove();
        }

    });

</script>