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
});
