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

use App\Http\Controllers\CrudController;
use App\Http\Controllers\DatatablesController;
use App\Http\Select2\Select2Ajax;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect('/list/example');
});


Route::get('image/{path}/{filename}',
    function ($path, $filename) {
        $path = Str::plural($path);
        $storagePath = storage_path('images/'.$path.'/'.$filename);
        if (file_exists($storagePath)) {
            $file = File::get($storagePath);
            return response($file, 200)->header('Content-Type', 'png');
        }
        return Redirect::to(url('images/not-found.png'));
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


Route::prefix('/form/{entity}')->group(function ($entity) {

    Route::get('/create',
        function (Request $request, FormBuilder $formBuilder, $entity) {
            $class = new CrudController($entity);
            return $class->addForm($request, $formBuilder);
        });
    Route::post('/create',
        function (Request $request, $entity) {
            $class = new CrudController($entity);
            return $class->submitAdd($request);
        });
    Route::get('/edit/{id}',
        function (Request $request, FormBuilder $formBuilder, $entity, $id) {
            $class = new CrudController($entity);
            return $class->editForm($request, $formBuilder, $id);
        });
    Route::post('/edit/{id}',
        function (Request $request, $entity, $id) {
            $class = new CrudController($entity);
            return $class->submitEdit($request, $id);
        });
    Route::post('/delete',
        function (Request $request, $entity) {
            $class = new CrudController($entity);
            return $class->submitDelete($request);
        });
});
