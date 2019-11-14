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
use App\Http\Select2\Select2Ajax;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('dashboard.baselayout');
});

Route::get('/list/{entity}',
    function ($entity) {
        $class = new DatatablesController($entity);
        return $class->index();
    });

Route::get('/list/{entity}/datatables',
    function (Request $request, $entity) {
        $class = new DatatablesController($entity);
        return $class->ajax($request);
    });

Route::post('/modal/{entity}/{id}',
    function ($entity, $id) {
        $class = new DatatablesController($entity);
        return $class->modal($id);
    });

Route::get('/select2/{key}',
    function (Request $request, $key) {
        $page = 1;
        if (isset($request->page)) {
            $page = $request->page;
        }
        $search = "";
        if (isset($request->search)) {
            $search = $request->search;
        }
        $params = [];
        if (isset($request->params)) {
            $params = $request->params;
        }
        return response()->json(Select2Ajax::getAjaxDataByKey($key,
            $page, $search, $params));
    });

Route::get('/select2/{key}/{id}',
    function (Request $request, $key, $id) {
        return Select2Ajax::getTextByKey($key, $id);
    });
