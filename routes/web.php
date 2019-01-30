<?php


use Illuminate\Support\Facades\Auth;


//CRONTAB
Route::get('criarjobdistribuicao', 'DistribuicaoController@index')->name('criarjobdistribuicao');
Route::get('distribuicao/truncate', 'DistribuicaoController@truncate')->name('truncate');
Route::get('crontab/importacao', 'CronController@importacao');
Route::get('crontab/distribuicao/{x}', 'CronController@distribuicao');
Route::get('crontab/teste', 'CronController@teste');
Route::get('crontab/execfilaparcela', 'CronController@execfilaparcela');
Route::get('crontab/execfila', 'CronController@execfila');
Route::get('teste-execfila', 'Admin\ExecFilaController@teste');

//Froala
Route::post('admin/uploadfroala', 'Admin\FroalaController@store');
Route::get('admin/uploadfroala', 'Admin\FroalaController@store');
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


//PORTAL FRONT
Route::get('/', 'Portal\PortalController@index')->name('portal.home');
Route::get('legislacao', 'Portal\PortalController@legislacao')->name('portal.legislacao');
Route::get('ajuda', 'Portal\PortalController@ajuda')->name('portal.ajuda');
Route::get('chatMsg', 'Portal\PortalController@chatMsg')->name('portal.chatMsg');
Route::get('chat', 'Portal\PortalController@chat')->name('portal.chat');

Route::get('acesso', 'Portal\PortalController@acesso')->name('portal.acesso');
Route::post('acesso-login', 'Portal\PortalController@acessoLogin')->name('portal.acessoLogin');

Route::get('solicitacao', 'Portal\PortalController@solicitacao')->name('portal.solicitacao');
Route::post('solicitacao-pf', 'Portal\PortalController@solicitacaoSendPF')->name('portal.solicitacaoSendPF');
Route::post('solicitacao-pJ', 'Portal\PortalController@solicitacaoSendPJ')->name('portal.solicitacaoSendPJ');
Route::post('cep', 'Portal\PortalController@cep')->name('portal.cep');
Route::post('credenciais', 'Portal\PortalController@credenciais')->name('portal.credenciais');

Route::group(['middleware'=>['cidadao']],function () {

    Route::get('debitos', 'Portal\PortalController@debitos')->name('portal.debitos');
    Route::get('parcelamento', 'Portal\PortalController@parcelamento')->name('portal.parcelamento');
    Route::get('guias', 'Portal\PortalController@guias')->name('portal.guias');
    Route::get('dados', 'Portal\PortalController@dados')->name('portal.dados');
    Route::get('sair', 'Portal\PortalController@sair')->name('portal.sair');

    Route::get('get-tributos', 'Portal\PortalController@getDataTributo')->name('portal.getDataTributo');
    Route::get('get-parcelas', 'Portal\PortalController@getDataParcela')->name('portal.getDataParcela');
    Route::get('get-simulacao', 'Portal\PortalController@getDataSimulacao')->name('portal.getDataSimulacao');

    Route::post('get-extrato', 'Portal\PortalController@exportExtrato')->name('portal.exportExtrato');
    Route::post('get-guia', 'Portal\PortalController@exportGuia')->name('portal.exportGuia');
    Route::post('get-parcelamento', 'Portal\PortalController@exportParcelamento')->name('portal.exportParcelamento');

//        Route::get('admin/debitos', 'AdminController@debitos')->name('admin.debitos');
//        Route::get('admin/debitos/getdata', 'AdminController@getDadosDataTable')->name('debitos.getdata');
//        Route::get('admin/boleto/{id}', 'BoletoController@show');
});

Route::group(['middleware'=>['auth','cors'],'namespace' =>'Admin'],function (){

    Route::get('admin', 'AdminController@index')->name('admin.home');

    Route::post('admin/perfil', 'PerfilController@editar')->name('perfil.update');
    Route::get('admin/perfil', 'PerfilController@index')->name('perfil.ver');

    Route::get('admin/users',               'UserController@index')->name('admin.users');
    Route::get('admin/users/getdata',       'UserController@getPosts')->name('users.getdata');
    Route::get('admin/users/inserir',       'UserController@getInserir')->name('users.inserirGet');
    Route::post('admin/users/inserir',      'UserController@postInserir')->name('users.inserirPost');
    Route::get('admin/users/editar/{id}',   'UserController@getEditar')->name('users.editarGet');
    Route::post('admin/users/editar/{id}',  'UserController@postEditar')->name('users.editarPost');
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
    Route::post('admin/modelo/pdf/', 'ModeloController@verPDF')->name('modelo.pdf');

    Route::get('admin/evento/getdata', 'EventoController@getDadosDataTable')->name('evento.getdata');
    Route::resource('admin/evento', 'EventoController');

    Route::get('admin/fila/getdata', 'FilaController@getDadosDataTable')->name('fila.getdata');
    Route::resource('admin/fila', 'FilaController');

    Route::get('admin/carteira/getdata', 'CarteiraController@getDadosDataTable')->name('carteira.getdata');
    Route::get('admin/carteira/getdataRoteiro', 'CarteiraController@getDadosDataTableRoteiro')->name('carteira.getdataRoteiro');
    Route::get('admin/carteira/getdataCarteira', 'CarteiraController@getDadosDataTableCarteira')->name('carteira.getdataCarteira');
    Route::resource('admin/carteira', 'CarteiraController');

    Route::get('admin/pessoa/getdataIM', 'PessoaController@getDadosDataTableIM')->name('pessoa.getdataIM');
    Route::get('admin/pessoa/getdata', 'PessoaController@getDadosDataTable')->name('pessoa.getdata');
    Route::get('admin/pessoa/findpessoa', 'PessoaController@findPessoa')->name('pessoa.findpessoa');
    Route::get('admin/pessoa/export', 'PessoaController@export')->name('pessoa.export');
    Route::get('admin/pessoa/canal', 'PessoaController@getDadosDataTableCanal')->name('pessoa.canal');
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
    Route::get('admin/credport/getdata2', 'CredPortController@getDadosDataTable2')->name('credport.getdata2');
    Route::resource('admin/credport', 'CredPortController');

    Route::get('admin/parcela/getdata', 'ParcelaController@getDadosDataTable')->name('parcela.getdata');
    Route::resource('admin/parcela', 'ParcelaController');

    Route::get('admin/pcrot/getdata', 'PcRotController@getDadosDataTable')->name('pcrot.getdata');
    Route::resource('admin/pcrot', 'PcRotController');

    Route::get('admin/pcevento/getdata', 'PcEventoController@getDadosDataTable')->name('pcevento.getdata');
    Route::resource('admin/pcevento', 'PcEventoController');

    Route::get('admin/pscanalevento/getdata', 'PsCanalEventoController@getDadosDataTable')->name('pscanalevento.getdata');
    Route::resource('admin/pscanalevento', 'PsCanalEventoController');

    Route::get('admin/regparc/getdata', 'RegParcController@getDadosDataTable')->name('regparc.getdata');
    Route::resource('admin/regparc', 'RegParcController');

    Route::get('admin/regtributo/getdata', 'RegraTributoController@getDadosDataTable')->name('regtributo.getdata');
    Route::resource('admin/regtributo', 'RegraTributoController');

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
    Route::get('admin/execfila/getdataSitPag', 'ExecFilaController@getDadosDataTableSitPag')->name('execfila.getdataSitPag');
    Route::get('admin/execfila/getdataSitCob', 'ExecFilaController@getDadosDataTableSitCob')->name('execfila.getdataSitCob');
    Route::get('admin/execfila/getdataOrigTrib', 'ExecFilaController@getDadosDataTableOrigTrib')->name('execfila.getdataOrigTrib');
    Route::get('admin/execfila/getdataTributo', 'ExecFilaController@getDadosDataTableTributo')->name('execfila.getdataTributo');
    Route::get('admin/execfila/getDadosEventos', 'ExecFilaController@getDadosEventos')->name('execfila.getDadosEventos');
    Route::get('admin/execfila/getDadosTratRet', 'ExecFilaController@getDadosTratRet')->name('execfila.getDadosTratRet');
    Route::get('admin/execfila/getdataParcela', 'ExecFilaController@getDadosDataTableParcela')->name('execfila.getdataParcela');
    Route::get('admin/execfila/getDadosFila', 'ExecFilaController@getDadosFila')->name('execfila.getDadosFila');
    Route::get('admin/execfila/getDadosCarteira', 'ExecFilaController@getDadosDataTableCarteira')->name('execfila.getDadosCarteira');
    Route::get('admin/execfila/getDadosRoteiro', 'ExecFilaController@getDadosDataTableRoteiro')->name('execfila.getDadosRoteiro');
    Route::get('admin/execfila/getDadosTratRetorno', 'ExecFilaController@getDadosDataTableTratRetorno')->name('execfila.getDadosTratRetorno');
    Route::get('admin/execfila/getDadosParcelasExec', 'ExecFilaController@getDadosDataTableParcelasExec')->name('execfila.getDadosParcelasExec');
    Route::get('admin/execfila/getDadosValidacao', 'ExecFilaController@getDadosDataTableValidacao')->name('execfila.getDadosValidacao');
    Route::get('admin/execfila/getDadosValidar', 'ExecFilaController@getDadosDataTableValidar')->name('execfila.getDadosValidar');
    Route::get('admin/execfila/getDadosValidarAll', 'ExecFilaController@getDadosDataTableValidarAll')->name('execfila.getDadosValidarAll');
    Route::post('admin/execfila/validar', 'ExecFilaController@validar')->name('execfila.validar');
    Route::post('admin/execfila/tratar', 'ExecFilaController@tratar')->name('execfila.tratar');
    Route::post('admin/execfila/analisar', 'ExecFilaController@analisar')->name('execfila.analisar');
    Route::get('admin/execfila/getDadosDataTableValidacoes', 'ExecFilaController@getDadosDataTableValidacoes')->name('execfila.getDadosDataTableValidacoes');
    Route::get('admin/execfila/getDadosDataTableHigiene', 'ExecFilaController@getDadosDataTableHigiene')->name('execfila.getDadosDataTableHigiene');
    Route::resource('admin/execfila', 'ExecFilaController');

    Route::get('admin/tarefas/getdata', 'TarefasController@getDadosDataTable')->name('tarefas.getdata');
    Route::resource('admin/tarefas', 'TarefasController');

    Route::get('admin/modelovar/getdata', 'ModeloVarController@getDadosDataTable')->name('modelovar.getdata');
    Route::resource('admin/modelovar', 'ModeloVarController');

    Route::resource('admin/portal', 'PortalAdmController');

    Route::get('admin/faq/getdata', 'FaqController@getDadosDataTable')->name('faq.getdata');
    Route::resource('admin/faq', 'FaqController');

    Route::get('admin/legislacao/getdata', 'LegislacaoController@getDadosDataTable')->name('legislacao.getdata');
    Route::resource('admin/legislacao', 'LegislacaoController');

    Route::resource('admin/boleto', 'BoletoController');

    Route::get('admin/relatorios/getdata', 'RelatoriosController@getDadosDataTable')->name('relatorios.getdata');
    Route::get('admin/relatorios/{id}/gerar', 'RelatoriosController@gerar')->name('relatorios.gerar');
    Route::get('admin/relatorios/filtrar', 'RelatoriosController@getdataRegistro')->name('relatorios.getdataRegistro');
    Route::get('admin/relatorios/sql', 'RelatoriosController@getdataRegistroSql')->name('relatorios.getdataRegistroSql');
    Route::post('admin/relatorios/export', 'RelatoriosController@export')->name('relatorios.export');
    Route::resource('admin/relatorios', 'RelatoriosController');

    Route::get('admin/relparametro/getdata', 'RelatorioParametroController@getDadosDataTable')->name('relparametro.getdata');
    Route::resource('admin/relparametro', 'RelatorioParametroController');

    Route::get('admin/chat/getdata', 'ChatController@getDadosDataTable')->name('chat.getdata');
    Route::resource('admin/chat', 'ChatController');
    Route::get('admin/chatperguntas/getdata', 'ChatPerguntasController@getDadosDataTable')->name('chatperguntas.getdata');
    Route::resource('admin/chatperguntas', 'ChatPerguntasController');
    Route::get('admin/chatrespostas/getdata', 'ChatRespostasController@getDadosDataTable')->name('chatrespostas.getdata');
    Route::resource('admin/chatrespostas', 'ChatRespostasController');

    Route::get('admin/canalevento/getdata', 'CanalEventoController@getDadosDataTable')->name('canalevento.getdata');
    Route::resource('admin/canalevento', 'CanalEventoController');

    Route::get('admin/menu/getdata', 'MenuController@getDadosDataTable')->name('menu.getdata');
    Route::resource('admin/menu', 'MenuController');

    Route::get('admin/grupos/getdata', 'GruposController@getDadosDataTable')->name('grupos.getdata');
    Route::resource('admin/grupos', 'GruposController');

    Route::post('admin/graficos/acionamentos', 'GraficosController@acionamentos')->name('graficos.acionamentos');
    Route::post('admin/graficos/origem', 'GraficosController@origem')->name('graficos.origem');
    Route::post('admin/graficos/carteira', 'GraficosController@carteira')->name('graficos.carteira');
    Route::post('admin/graficos/fase', 'GraficosController@fase')->name('graficos.fase');
});
