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

use App\Http\Controllers\DatatablesController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('dashboard.baselayout');
});

Route::get('/list/{entity}',
    function ($entity) {
        $class = new App\Http\Controllers\DatatablesController($entity);
        return $class->index();
    });

Route::get('/list/{entity}/datatables',
    function (Request $request, $entity) {
        $class = new App\Http\Controllers\DatatablesController($entity);
        return $class->ajax($request);
    });

Route::post('/modal/{entity}/{id}',
    function ($entity, $id) {
        $class = new App\Http\Controllers\DatatablesController($entity);
        return $class->modal($id);
    });