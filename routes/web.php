<?php




Route::get('/', 'Portal\PortalController@index')->name('portal.home');
Route::get('/solicitacao', 'Portal\PortalController@solicitacao')->name('portal.solicitacao');
Route::post('/solicitacao', 'Portal\PortalController@solicitacaoSend')->name('portal.solicitacaoSend');

Route::get('distribuicao', 'DistribuicaoController@index')->name('distribuicao');
Route::get('crontab', 'CronController@index')->name('crontab');

Auth::routes();

Route::group(['middleware'=>['auth'],'namespace' =>'Admin'],function (){

    Route::get('admin', 'AdminController@index')->name('admin.home');

    Route::post('admin/perfil', 'PerfilController@editar')->name('perfil.update');
    Route::get('admin/perfil', 'PerfilController@index')->name('perfil.ver');

    Route::get('admin/users', 'UserController@index')->name('admin.users');
    Route::get('admin/users/getdata', 'UserController@getPosts')->name('users.getdata');
    Route::get('admin/users/inserir', 'UserController@getInserir')->name('users.inserirGet');
    Route::post('admin/users/inserir', 'UserController@postInserir')->name('users.inserirPost');
    Route::get('admin/users/editar/{id}', 'UserController@getEditar')->name('users.editarGet');
    Route::post('admin/users/editar/{id}', 'UserController@postEditar')->name('users.editarPost');
    Route::post('admin/users/deletar/{id}', 'UserController@postDeletar')->name('users.deletar');

    //Tabela
    Route::get('admin/tabsys', 'TabelasSistemaController@index')->name('admin.tabsys');
    Route::get('admin/tabsys/getdata', 'TabelasSistemaController@getPosts')->name('tabsys.getdata');
    Route::get('admin/tabsys/inserir', 'TabelasSistemaController@getInserir')->name('tabsys.inserirGet');
    Route::post('admin/tabsys/inserir', 'TabelasSistemaController@postInserir')->name('tabsys.inserirPost');
    Route::get('admin/tabsys/editar/{id}', 'TabelasSistemaController@getEditar')->name('tabsys.editarGet');
    Route::post('admin/tabsys/editar/{id}', 'TabelasSistemaController@postEditar')->name('tabsys.editarPost');
    Route::post('admin/tabsys/deletar/{id}', 'TabelasSistemaController@postDeletar')->name('tabsys.deletar');

    Route::get('admin/regtab/getdata', 'RegTabController@getPosts')->name('regtab.getdata');
    Route::post('admin/regtab/inserir', 'RegTabController@postInserir')->name('regtab.inserirPost');
    Route::post('admin/regtab/deletar/{id}', 'RegTabController@postDeletar')->name('regtab.deletar');
    Route::get('admin/regtab/editar', 'RegTabController@getEditar')->name('regtab.editarGet');
    Route::post('admin/regtab/editar/{id}', 'RegTabController@postEditar')->name('regtab.editarPost');

    //Canal
    Route::get('admin/canal', 'CanalController@index')->name('admin.canal');
    Route::get('admin/canal/getdata', 'CanalController@getPosts')->name('canal.getdata');
    Route::get('admin/canal/inserir', 'CanalController@getInserir')->name('canal.inserirGet');
    Route::post('admin/canal/inserir', 'CanalController@postInserir')->name('canal.inserirPost');
    Route::get('admin/canal/editar/{id}', 'CanalController@getEditar')->name('canal.editarGet');
    Route::post('admin/canal/editar/{id}', 'CanalController@postEditar')->name('canal.editarPost');
    Route::post('admin/canal/deletar/{id}', 'CanalController@postDeletar')->name('canal.deletar');

    //Mod Com
    Route::get('admin/modelo', 'ModeloController@index')->name('admin.modelo');
    Route::get('admin/modelo/getdata', 'ModeloController@getPosts')->name('modelo.getdata');
    Route::get('admin/modelo/inserir', 'ModeloController@getInserir')->name('modelo.inserirGet');
    Route::post('admin/modelo/inserir', 'ModeloController@postInserir')->name('modelo.inserirPost');
    Route::get('admin/modelo/editar/{id}', 'ModeloController@getEditar')->name('modelo.editarGet');
    Route::post('admin/modelo/editar/{id}', 'ModeloController@postEditar')->name('modelo.editarPost');
    Route::post('admin/modelo/deletar/{id}', 'ModeloController@postDeletar')->name('modelo.deletar');

    Route::get('admin/evento/getdata', 'EventoController@getDadosDataTable')->name('evento.getdata');
    Route::resource('admin/evento', 'EventoController');

    Route::get('admin/fila/getdata', 'FilaController@getDadosDataTable')->name('fila.getdata');
    Route::resource('admin/fila', 'FilaController');

    Route::get('admin/carteira/getdata', 'CarteiraController@getDadosDataTable')->name('carteira.getdata');
    Route::get('admin/carteira/getdataRoteiro', 'CarteiraController@getDadosDataTableRoteiro')->name('carteira.getdataRoteiro');
    Route::resource('admin/carteira', 'CarteiraController');

    Route::get('admin/pessoa/getdata', 'PessoaController@getDadosDataTable')->name('pessoa.getdata');
    Route::get('admin/pessoa/findpessoa', 'PessoaController@findPessoa')->name('pessoa.findpessoa');
    Route::resource('admin/pessoa', 'PessoaController');

    Route::get('admin/regcalc/getdata', 'RegraCalculoController@getDadosDataTable')->name('regcalc.getdata');
    Route::resource('admin/regcalc', 'RegraCalculoController');

    Route::get('admin/valenv/getdata', 'ValEnvController@getDadosDataTable')->name('valenv.getdata');
    Route::resource('admin/valenv', 'ValEnvController');

    Route::get('admin/tratret/getdata', 'TratRetController@getDadosDataTable')->name('tratret.getdata');
    Route::resource('admin/tratret', 'TratRetController');

    Route::get('admin/tippos/getdata', 'TipPosController@getDadosDataTable')->name('tippos.getdata');
    Route::resource('admin/tippos', 'TipPosController');

    Route::get('admin/horaexec/getdata', 'HoraExecController@getDadosDataTable')->name('horaexec.getdata');
    Route::resource('admin/horaexec', 'HoraExecController');

    Route::get('admin/filaconf/getdata', 'FilaConfController@getDadosDataTable')->name('filaconf.getdata');
    Route::resource('admin/filaconf', 'FilaConfController');

    Route::get('admin/entcart/getdata', 'EntCartController@getDadosDataTable')->name('entcart.getdata');
    Route::resource('admin/entcart', 'EntCartController');

    Route::get('admin/roteiro/getdata', 'RoteiroController@getDadosDataTable')->name('roteiro.getdata');
    Route::resource('admin/roteiro', 'RoteiroController');

    Route::get('admin/execrot/getdata', 'ExecRotController@getDadosDataTable')->name('execrot.getdata');
    Route::resource('admin/execrot', 'ExecRotController');

    Route::get('admin/prrotcanal/getdata', 'PrRotCanalController@getDadosDataTable')->name('prrotcanal.getdata');
    Route::resource('admin/prrotcanal', 'PrRotCanalController');

    Route::get('admin/inscrmun/getdata', 'InscrMunController@getDadosDataTable')->name('inscrmun.getdata');
    Route::resource('admin/inscrmun', 'InscrMunController');

    Route::get('admin/pscanal/getdata', 'PsCanalController@getDadosDataTable')->name('pscanal.getdata');
    Route::resource('admin/pscanal', 'PsCanalController');

    Route::get('admin/socresp/getdata', 'SocRespController@getDadosDataTable')->name('socresp.getdata');
    Route::resource('admin/socresp', 'SocRespController');

    Route::get('admin/ativecon/getdata', 'AtiveComController@getDadosDataTable')->name('ativecon.getdata');
    Route::resource('admin/ativecon', 'AtiveComController');

    Route::get('admin/credport/getdata', 'CredPortController@getDadosDataTable')->name('credport.getdata');
    Route::resource('admin/credport', 'CredPortController');

    Route::get('admin/parcela/getdata', 'ParcelaController@getDadosDataTable')->name('parcela.getdata');
    Route::resource('admin/parcela', 'ParcelaController');

    Route::get('admin/pcrot/getdata', 'PcRotController@getDadosDataTable')->name('pcrot.getdata');
    Route::resource('admin/pcrot', 'PcRotController');

    Route::get('admin/pcevento/getdata', 'PcEventoController@getDadosDataTable')->name('pcevento.getdata');
    Route::resource('admin/pcevento', 'PcEventoController');

    Route::get('admin/regparc/getdata', 'RegParcController@getDadosDataTable')->name('regparc.getdata');
    Route::resource('admin/regparc', 'RegParcController');

    Route::get('admin/implayout/getcampos', 'ImpLayoutController@getCampos')->name('implayout.getcampos');
    Route::get('admin/implayout/getdata', 'ImpLayoutController@getDadosDataTable')->name('implayout.getdata');
    Route::post('admin/implayout/montaarquivo', 'ImpLayoutController@montaArquivo')->name('implayout.montaArquivo');
    Route::resource('admin/implayout', 'ImpLayoutController');

    Route::get('admin/impcampo/getdata', 'ImpCampoController@getDadosDataTable')->name('impcampo.getdata');
    Route::get('admin/imparquivo/getdata', 'ImpArquivoController@getDadosDataTable')->name('imparquivo.getdata');
    Route::resource('admin/impcampo', 'ImpCampoController');
    Route::resource('admin/imparquivo', 'ImpArquivoController');

    Route::resource('admin/importacao', 'ImportacaoController');

    Route::resource('admin/uploadtinymce', 'tinymceController');

    Route::get('admin/solicitar_acesso/getdata', 'SolicitarAcessoController@getDadosDataTable')->name('solicitar_acesso.getdata');
    Route::resource('admin/solicitar_acesso', 'SolicitarAcessoController');

    Route::get('admin/execfila/getdataFxAtraso', 'ExecFilaController@getDadosDataTableFxAtraso')->name('execfila.getdataFxAtraso');
    Route::get('admin/execfila/getdataFxValor', 'ExecFilaController@getDadosDataTableFxValor')->name('execfila.getdataFxValor');
    Route::get('admin/execfila/getdataParcela', 'ExecFilaController@getDadosDataTableParcela')->name('execfila.getdataParcela');
    Route::resource('admin/execfila', 'ExecFilaController');

});
