<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'barcode', 'costo','image','precio','stock','alerta','categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(categoria::class);
    }
        


    // public function getImagenAttribute(){

    //     if($this->image!=null)
    //         return (file_exists('storage/productos/' . $this->image) ? $this->image :'no.jpeg');
    //     else
    //     return 'no.jpeg';


    // }
   






    
}





