<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Curso;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function postLogin(Request $request)
    { //Como voy a mandar los datos por parámetros y voy a recibir los datos por request y se la paso por parámetros a la función
        // return $request->all();
        //return $request->input("param"); //Leer parámetro en especifíco
        //return $request->param;//Leer parámetro en especifíco
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 500,
                'message' => 'Debes de ingresar tu usuario y/o contraseña',
            ], 500);
        }

        $user = User::where('email', '=', $request->input('email'))->first();

        //Ver si existe el usuario
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) { //Chequear que el password que ingreso es igual al password del usuario
                return $user;
            }
        }

        return response()->json([
            'status'  => 500,
            'message' => 'Usuario/Contraseña incorrectos',
        ], 500);
    }

    //Método para registro de usuarios

    public function postRegistro(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users', //Tiene que ser único en la tabla usuario
            'name' => 'required|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 500,
                'message' => 'Ha ocurrido un error inesperado',
                'errors' => $validator->errors()
            ], 500);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return $user;
        }

        return response()->json([
            'status'  => 500,
            'message' => 'Usuario/Contraseña incorrectos',
        ], 500);
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function getUserId($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function postEdit(Request $request)  //Recuperar toda la informacion por medio del formulario, la puedo recuperar por medio del request
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:150|', //Tiene que ser único en la tabla usuario
            'name' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 500,
                'message' => 'Ha ocurrido un error inesperado',
                'errors' => $validator->errors()
            ], 500);
        }

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->input('email');

        if ($request->has("password")) {
            $user->password = Hash::make($request->password);
        }


        /*if ($user->save()) {
            return $user;
        }*/

        return response()->json([
            'status'  => 500,
            'message' => 'Datos modificados correctamente',
        ], 500);
    }

    public function postUserCurso($user_id, $curso_id)
    {
        $user = User::find($user_id);
        if ($user) {
            if (!$user->cursos->contains($curso_id)) { //Si ese curso no esta anclado a ese usuario

                $user->cursos()->attach($curso_id); //Anclar el usuario a los cursos
                return response()->json([
                    'status'  => 200,
                    'message' => 'Curso agregado correctamente',
                ], 200);
            } else {
                return response()->json([
                    'status'  => 200, //200 por que es un mensaje de alerta al usuario
                    'message' => 'Este curso ya se encuentra en tu lista de favoritos',
                ], 200);
            }
        } else {
            return response()->json([
                'status'  => 500,
                'message' => 'Usuario no existe',
            ], 500);
        }
    }

    public function getCursosUser($id)
    {

       /*  $user = User::find($id);
        if($user){
            $cursos = $user->cursos;
            return response()->json($cursos);
        } */
         $user = User::find($id);
        if ($user) {
            $cursos         = $user->cursos;
            $cursosResponse = collect([]);
            $cursos->each(function ($item, $key) use ($cursosResponse) {
                $cursosResponse->push(Curso::where("id", $item->id)->with("categoria", "profesor")->first());  //En la posición donde vaya recorriendo el array, first() : solo se va necesitar uno
            });
            return response()->json($cursosResponse->all());
        }
        return response()->json([
            'status'  => 500,
            'message' => 'El usuario no existe',
        ], 500); 
    }
}
