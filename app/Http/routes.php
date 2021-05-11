<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\TheLoai;

Route::get('/', function () {
  return view('welcome');
});

Route::get('admin/login','UserController@getloginAdmin');
Route::post('admin/login','UserController@postloginAdmin');
Route::get('admin/logout','UserController@getlogoutAdmin');


Route::group(['prefix' => 'admin','middleware'=>'adminLogin'], function () {

  Route::group(['prefix' => 'theloai'], function () {
    Route::get('list', 'TheLoaiController@getList');

    Route::get('edit/{id}', 'TheLoaiController@getEdit');
    Route::post('edit/{id}', 'TheLoaiController@postEdit');

    Route::get('add', 'TheLoaiController@getAdd');
    Route::post('add', 'TheLoaiController@postAdd');

    Route::get('delete/{id}', 'TheLoaiController@getDelete');
  });

  Route::group(['prefix' => 'loaitin'], function () {
    Route::get('list', 'LoaiTinController@getList');

    Route::get('edit/{id}', 'LoaiTinController@getEdit');
    Route::post('edit/{id}', 'LoaiTinController@postEdit');

    Route::get('add', 'LoaiTinController@getAdd');
    Route::post('add', 'LoaiTinController@postAdd');

    Route::get('delete/{id}', 'LoaiTinController@getDelete');
  });

  Route::group(['prefix' => 'tintuc'], function () {
    Route::get('list', 'TinTucController@getList');

    Route::get('edit/{id}', 'TinTucController@getEdit');
    Route::post('edit/{id}', 'TinTucController@postEdit');

    Route::get('add', 'TinTucController@getAdd');
    Route::post('add', 'TinTucController@postAdd');

    Route::get('delete/{id}', 'TinTucController@getDelete');
  });
  /*------Comment------------*/
  Route::group(['prefix' => 'comment'], function () {

    Route::get('delete/{id}/{idTintuc}', 'CommentController@getDelete');
  });


  //------------ idTheLoai truyền sang AjaxController
  Route::group(['prefix' => 'ajax'], function () {
    Route::get('loaitin/{idTheLoai}', 'AjaxController@getAjaxLoaiTin');
  });
//---------------------------------------------------------------

  Route::group(['prefix' => 'slide'], function () {
    Route::get('list', 'SlideController@getList');

    Route::get('edit/{id}', 'SlideController@getEdit');
    Route::post('edit/{id}', 'SlideController@postEdit');

    Route::get('add', 'SlideController@getAdd');
    Route::post('add','SlideController@postAdd');

    Route::get('delete/{id}', 'SlideController@getDelete');
  });

  Route::group(['prefix' => 'user'], function () {
    Route::get('list', 'UserController@getList');

    Route::get('edit/{id}', 'UserController@getEdit');
    Route::post('edit/{id}', 'UserController@postEdit');

    Route::get('add', 'UserController@getAdd');
    Route::post('add', 'UserController@postAdd');

    Route::get('delete/{id}', 'UserController@getDelete');

  });
});


//----------------------trang chủ------------------
Route::get('trangchu','PagesController@trangchu');
Route::get('lienhe','PagesController@lienhe');
Route::get('loaitin/{id}/{TenKhongDau}.html','PagesController@loaitin');
Route::get('tintuc/{id}/{TenKhongDau}.html','PagesController@tintuc');

Route::get('dangnhap','PagesController@getdangnhap');
Route::post('dangnhap','PagesController@postdangnhap');

Route::post('dangxuat','PagesController@postdangxuat');

Route::post('comment/{id}','CommentController@postComment');

Route::get('nguoidung','PagesController@getNguoiDung');
Route::post('nguoidung','PagesController@postNguoiDung');

Route::get('dangky','PagesController@getdangky');
Route::post('dangky','PagesController@postdangky');