<?php

use App\Http\Controllers\SampleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FormController@index');

Route::get('/submit', function () {
    return view('submit');
});
Route::post('/submit', 'UserController@submit');

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', 'UserController@login');

Route::get('/logout', 'UserController@logout');

Route::post('/form', 'FormController@form');
Route::get('/form', function () {
    header('Location: /');
    exit();
});
Route::get('/formCheck', function () {
    header('Location: /');
    exit();
});

Route::post('/formCheck', 'FormController@check');
Route::post('/formReserve', 'FormController@reserve');
Route::post('/formChancel', 'FormController@chancel');
Route::get('/json', 'FormController@json');
Route::get('/info', 'FormController@info');
