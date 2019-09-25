<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profesor;
use App\Models\Curso;

class ProfesorController extends Controller
{
    public function getProfesores()
    {
        $profesores = Profesor::all();
        return response()->json($profesores);
    }


    public function getProfesorDetalle(Request $request)
    {
        $cursos = Curso::with("categoria", "profesor")->where("profesor_id", "=", $request->id)->get();
        return response()->json($cursos, 200);
    }
}
