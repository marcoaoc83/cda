<?php




Route::get('/', 'Portal\PortalController@index')->name('portal.home');


Auth::routes();

Route::group(['middleware'=>['auth'],'namespace' =>'Admin'],function (){

    Route::get('admin', 'AdminController@index')->name('admin.home');


    Route::post('admin/user', 'UserController@userUpdate')->name('perfil.update');
    Route::get('admin/user', 'UserController@index')->name('perfil.ver');

    Route::get('admin/users', 'UserController@userList')->name('admin.users');
});

