<?php

namespace App\Http\Livewire;
use App\Models\categoria;
use Livewire\Component;
use Livewire\WithFileUpLoads; //para subir imagenes livewire
use Livewire\WithPagination; 
use Illuminate\Support\facades\Storage;



class CategoriasController extends Component
{

    use WithFileUpLoads;
    use WithPagination;

    public $nombre,$search,$image,$selected_id,$pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {

    $this->pageTitle = 'Listado';
    $this->componentName = 'Categorias'; //ojo
  
    }

    public function render()
    {

      // $data= categoria::all();

        if(strlen($this->search)>0)

            $data = Categoria::where('nombre','like', '%'.$this->search .'%')->paginate($this->pagination) ;
        else 
            $data = Categoria::orderBy('id','desc')->paginate($this->pagination) ;

 


        return view('livewire.categoria.categorias',['categorias'=>$data])
        ->extends('layouts.theme.app')
        ->section( 'content');
    }

    // paginacion personalizada
    //php artisan livewire:publish --pagination


    public function paginationView()
    {
        return ('vendor.Livewire.bootstrap');
    }

    // metodo edit
    public function Edit ($id){

        $record = categoria::find($id,['id','nombre','image']);

        $this->nombre = $record->nombre;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal2', 'show modal!'); //emite un evente funciona con scipts

    }


    public function Store(){

        // $rules = [
        // 'nombre'=> 'required|unique:categorias|min:3'
        // ];

        // $messages=[
        // 'nombre.required' => 'Nombre de la categoria es requerido',
        // 'nombre.unique' => 'Nombre de la categoria es requerido',
        // 'nombre.min' => 'Nombre de la categoria es requerido',
        // ];

        // $this->validate('$rules','$messages');
        
        $categoria = categoria::create([
            'nombre' => $this->nombre
        ]);

      $customFileName;  
        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/categorias', $customFileName);

            $categoria->image = $customFileName;

            $categoria->save();
            //limpiar los impusts
        }
        $this->resetUI();
        $this->emit('category-added','categoria registrada');

    }

        public function resetUI(){
                $this->nombre='';
                $this->search='';
                $this->selected_id=0;
                $this->image=null;
        }



        public function Update(){
            
            // $rules = [
        
            // 'nombre'=> "required|min:3|unique: categorias ,nombre, {$this->selected_id}"
            // ];

            // $messages=[
            //     'nombre.required' => 'Nombre de la categoria es requerido',
            //     'nombre.unique' => 'Nombre de la categoria es requerido',
            //     'nombre.min' => 'Nombre de la categoria es requerido',
            //     ];
            //     $this->validate('$rules','$messages');

                $categoria = categoria::find($this->selected_id);
                $categoria->update(['nombre' => $this->nombre]);


                    if($this->image)
                    {
                        $customFileName =uniqid() . '_.' . $this->image->extension();
                        $this->image->storeAs('public/categorias', $customFileName);

                        $imageName = $categoria->image;

                        $categoria->image = $customFileName;
                        $categoria->save();

                        if($imageName !=null)
                            if(file_exists('storage/categorias' . $imageName))
                            {unlink('storage/categorias' . $imageName);}
                            
                    }

                    $this->resetUI();
                    $this->emit('category-updated', 'Categoría Actualizada');
                    


 
                }

//////////////////////////////////////////////////////////////////////////
               
        protected $listeners = [
                    'deleteRow'=>'Destroy'
                ];
          
       

        public function Destroy($id)
                    {

                    $categoria=Categoria::find($id);
                    $imageName=$categoria->image;
                                // imagen temporal
                    $categoria->delete();
                    //is para eliminar los restos imagen en el storage
                        if($imageName != null) {
                            unlink('storage/categorias/'.$imageName);
                        }

                        $this->resetUI(); //para limpiar los input
                        $this->emit('category-deleted', 'Categoría Eliminada');


                    }


}