<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    public function categoria()
    {
        //return $this->hasOne(Categoria::class,"id","categoria_id"); //Paso cual es el id dentro de la tabla categoria y llave foranea de la tabla cursos
        //return $this->belongsTo(Categoria::class,'categoria_id','id');
        return $this->belongsTo(Categoria::class);
    }


    public function profesor()
    {
        //return $this->hasOne(Profesor::class,"id","profesor_id");
        // return $this->belongsTo(Profesor::class,'profesor_id','id');
        return $this->belongsTo(Profesor::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, "users_cursos");
    }
}
