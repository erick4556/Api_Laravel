<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['apikey.validate']], function () {


    //Rutas de usuario
    Route::post('login', 'Api\UserController@postLogin');
    Route::post('register', 'Api\UserController@postRegistro');
    Route::get("users", "Api\UserController@getUsers");
    Route::get("user/{id}", "Api\UserController@getUserId");
    Route::post('user/edit', 'Api\UserController@postEdit');
    Route::post('user/curso/{user_id}/{curso_id}', 'Api\UserController@postUserCurso');
    Route::get('curso/user/{id}', 'Api\UserController@getCursosUser');

    //Rutas de cursos
    Route::get('cursos', 'Api\CursoController@getCursos');
    Route::get("curso/{id}", "Api\CursoController@getCursoId");

    //Rutas para categoria
    Route::get('categorias', 'Api\CursoController@getCategorias');
    Route::get('categoria/cursos/{id}', 'Api\CursoController@getCategoriaDetalle');

    //Rutas para profesor
    Route::get('profesores', 'Api\ProfesorController@getProfesores');
    Route::get('profesor/cursos/{id}', 'Api\ProfesorController@getProfesorDetalle');
});
