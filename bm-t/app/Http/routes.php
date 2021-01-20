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

Use App\Task;
use Illuminate\Http\Request;

Route::options('{all}', function () {
    return response('ok', 200)
        ->header('Access-Control-Allow-Credentials', 'true')
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
        ->header('Access-Control-Allow-Origin', '*');
})->where('all', '.*');

Route::get('tasks/{id?}', function ($id=0) {
    $task = new Task();
    return $task->find($id);
})
->where('id', '[0-9]+');

Route::delete('tasks/{id}', function($id) {
    $task = new Task();
    return $task->removeTask($id);
})
->where('id', '[0-9]+');

Route::post('tasks', function(Request $request) {
    $task = new Task();
    return $task->addNewTask($request->all());
});

Route::put('tasks/{id}', function(Request $request, $id) {
    $task = new Task();
    return $task->updateTask($id, $request->all());
});

/*Route::get('/', function () {
    return view('welcome');
});*/
