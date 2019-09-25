<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Profesor;

class CursoController extends Controller
{

  //Método para obtener todos los cursos
  public function getCursos()
  {
    // $cursos = Curso::all();
    //$cursos = Curso::find(1)->categoria; No funciona
    /* $cursos = Curso::join('categorias','categorias.id','=','cursos.categoria_id')
        ->select('cursos.id as cursid','cursos.nombre as curnomb','cursos.descripcion','cursos.icono','cursos.video','cursos.etiquetas',
            'categorias.id','categorias.nombre')->get(); */
    $cursos = Curso::with("categoria", "profesor")->get();
    return response()->json($cursos);

    /*  $categorias = Categoria::with("curso")->get();
         return response()->json($categorias);   */
  }

  // public function getCursoId($id){
  public function getCursoId(Request $request)
  {
    //$curso = Curso::find($id);
    $curso = Curso::find($request->id);
    return response()->json($curso, 200);
  }

  public function getCategorias()
  {
    $categorias = Categoria::all();
    return response()->json($categorias, 200);
  }


  public function getCategoriaDetalle($id)
  {
    $cursos = Curso::with("categoria", "profesor")->where("categoria_id", "=", $id)->get();
    return response()->json($cursos, 200);
  }
}
