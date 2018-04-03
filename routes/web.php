<?php




Route::get('/', 'Portal\PortalController@index')->name('portal.home');


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

});
