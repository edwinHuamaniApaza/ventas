<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Categoria;
use App\Models\Producto;

class ProductosController extends Component

{
    use WithPagination;
    use WithFiLeUpLoads;
    
   
   
    public $nombre, $barcode, $costo, $precio,$stock,$alerta,$categoriaid, $search, $image,$selected_id,$pageTitle,$componentName;
    private $pagination=4;

   
    public function paginationView(){

        return'vendor.livewire.bootstrap';
    }
   

    public function mount()
    {
        $this->pageTitle='Listado';
        $this->componentName= 'Productos';
        $this->categoriaid = 'Elegir';

    }

   
    public function render()
    {

        // if(strlen($this->search)>0)
        $producto = Producto::join('categorias as c', 'c.id', 'productos.categoria_id')
                    ->select('productos.*','c.nombre as categorias')
                    ->where('productos.nombre', 'like','%' .$this->search.'%')
                    ->orWhere('productos.barcode','like','%'. $this->search.'%')
                    ->orWhere('c.nombre','like','%'.$this->search.'%')
                    ->orderBy('productos.nombre','asc')
                    ->paginate ($this->pagination);
        // // else
        // // $productos = Productos::join('categorias as c','c.id','productos.categoria_id')
        // //             ->select('productos.*','c.nombre as categoria')
        // //             ->orderBy('productos.nombre', 'asc')
        // //             ->paginate($this->pagination);
     

        return view('livewire.producto.componente',[
            'data'=>$producto,
            'categorias'=>Categoria::orderBy('nombre','asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');

        
    }

    public function Store()
    {
        $rules=[
            'nombre'=>'required|unique:productos|min:3',
            'costo'=>'required',
            'precio'=>'required',
            'stock'=>'required',
            'alerta'=>'required',
            'categoriaid' =>'required|not_in:Elegir'
        ];

        $messages = [
            'nombre.required' =>'Nombre del producto requerido',
            'nombre.unique' => 'Ya existe el nombre del producto',
            'nombre.min'=> 'El nombre del producto debe tener al menos 3 caracteres',
            'costo.required'=>'El costo es requerido',
            'precio.required'=>'El precio es requerido',
            'stock.required'=>'El stock es requerido',
            'alerta.required' =>'Ingresa el valor mínimo en existencias',
            'categoriaid.not_in'=> 'Elige un nombre de categoría diferente de Elegir'
        ];
       
        $this->validate ($rules, $messages);

        $producto=Producto::create([
            'nombre' => $this->nombre,
            'costo'=> $this->costo,
            'precio'=> $this->precio,
            'barcode'=> $this->barcode,
            'stock'=> $this->stock,
            'alerta' => $this->alerta,
            'categoria_id' => $this->categoriaid
            ]);

            if($this->image)
            {
                $customFileName = uniqid(). '._' .$this->image->extension();
                $this->image->storeAs('public/productos/', $customFileName);
                $producto->image=$customFileName;
                $producto->save();   
                
                
            }

                $this->resetUI();
                $this->emit('product-added','Producto Registrado');


        

    }
    
    public function resetUI()
            {
                    $this->nombre='';
                    $this->barcode='';
                    $this->costo='';
                    $this->precio='';
                    $this->alerta='';
                    $this->search='';
                    $this->selected_id=0;
                    $this->image=null;

                    ///////colocar
                    //$this->categoriaid ='Elegir';

            }

    
        public function Edit ($id){

            $producto = Producto::find($id,['id','nombre','barcode','costo','precio','stock','alerta','categoria_id','image']);

            $this->selected_id=$producto->id;
            $this->nombre =$producto->nombre;
            $this->barcode = $producto->barcode;
            $this->costo =$producto->costo;
            $this->precio=$producto->precio;
            $this->stock = $producto->stock;
            $this->alerta = $producto->alerta;
            $this->categoriaid =$producto->categoria_id;
            $this->image = null;

            $this->emit('modal-show','modal-show');

    }

    public function Update(){

        // $rules=[
        //     'nombre'=>"required|min:3|unique:productos, name ,{$this->selected_id}",
        //     'costo'=>'required',
        //     'precio'=>'required',
        //     'stock'=>'required',
        //     'alerta'=>'required',
        //     'categoriaid' =>'required|not_in:Elegir'
        // ];

        // $messages = [
        //     'nombre.required' =>'Nombre del producto requerido',
        //     'nombre.unique' => 'Ya existe el nombre del producto',
        //     'nombre.min'=> 'El nombre del producto debe tener al menos 3 caracteres',
        //     'costo.required'=>'El costo es requerido',
        //     'precio.required'=>'El precio es requerido',
        //     'stock.required'=>'El stock es requerido',
        //     'alerta.required' =>'Ingresa el valor mínimo en existencias',
        //     'categoriaid.not_in'=> 'Elige un nombre de categoría diferente de Elegir'
        // ];
       
        // $this->validate ($rules, $messages);
        //////////////////////////////////////

        $producto = Producto::find($this->selected_id);
        $producto->update([
            'nombre'=> $this->nombre,
            'costo' => $this->costo,
            'precio' => $this->precio,
            'barcode'=> $this->barcode,
            'stock'=> $this->stock,
            'alerta' => $this->alerta,
            'categoria_id' => $this->categoriaid
        ]);

        if ($this->image){
            $customFileName=uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/productos/', $customFileName);
          
            $imageTemp=$producto->image; // imagen temporal
            $producto->image=$customFileName; 
            $producto->save();

            if($imageTemp!=null)
            { if(file_exists('storage/productos/' . $imageTemp ))
                {
                    unlink('storage/productos/' . $imageTemp);
                }
            }

        }
           
        $this->resetUI();
        $this->emit('product-updated', 'Producto actualizado');
       




    }
   
//para que el backend escuche los eventos del frontend de los javascripts
    protected $listeners =['deleteRow'=>'Destroy'];

    public function Destroy (Producto $producto)
    {
        $imageTemp = $producto->image;
        $producto->delete();
        
        if($imageTemp !=null){
            if(file_exists('storage/productos/' .$imageTemp )) 
            {
                unlink('storage/productos/' .  $imageTemp);
            }                             

        }

        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');

    }





}
