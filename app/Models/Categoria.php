<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','image'];

    public function producto()
    {
        return $this->hasMany(producto::class);

    }

    //ACCESOR funcion para insertar imagen en comun cuando la categoria no tenga una imagen
    public function getImagenAttribute ()
    {
        if(file_exists('storage/categorias/'.$this->image))
            return $this->image;
        else
            return 'noimagen.jpeg';

    }

}