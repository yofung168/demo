<?php

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
Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    try {
        $abc = Collect::college_list();
        dd($abc);
    } catch (\Exception $exception) {
        dd($exception->getMessage());
    }
});
Route::match(['get', 'post'], 'demo', 'IndexController@demo');
Route::match(['get', 'post'], 'ali_demo', 'IndexController@ali_demo');

