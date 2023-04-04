<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denominacion extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'values', 'image'];


    // public function getImagenAttribute ()
    // {
    //     if(file_exists('storage/monedas/'.$this->image))
    //         return $this->image;
    //     else
    //         return 'noimagen.jpeg';

    // }





    
}
