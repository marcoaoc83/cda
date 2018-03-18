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
});
