<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denominacion;
use Livewire\WithFileUpLoads; //para subir imagenes livewire
use Livewire\WithPagination; 
use Illuminate\Support\facades\Storage;



class CoinsController extends Component
{
   
    
    use WithFileUpLoads;
    use WithPagination;

    public $componentName ='Denominaciones', $pageTitle= 'Listado',$selected_id, $image, $search ,$type,$values;


    private $pagination = 5;

    public function mount (){
        $this->componentName='Monedas';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
    }

   
   
   
     public function render()
    {

      // $data= categoria::all();

        if(strlen($this->search)>0)

            $data = Denominacion::where('type','like', '%'.$this->search .'%')->paginate($this->pagination) ;
        else 
            $data = Denominacion::orderBy('id','desc')->paginate($this->pagination) ;

 


        return view('livewire.denominacion.componente',['data'=>$data])
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

        $record2 = denominacion::find($id,['id','type','values','image']);

        $this->type = $record2->type;
        $this->values = $record2->values;
        $this->selected_id = $record2->id;
        $this->image = null;
        $this->emit('modal-show','show modal!'); //emite un evente funciona con scipts

    }


    public function Store(){

        //  $rules = [
        // // 'nombre'=> 'required|unique:categorias|min:3'
        // 'type'=>'required|not_in:Elegir',
        // 'value' =>'required|unique:denominacions'
        //  ];

        // $messages= [
        //     'type.required'=>'El tipo es requerido',
        //     'type.not_in'=>'Elige un valor para el tipo distinto a Elegir',
        //     'value.required'=>'El valor es requerido',
        //     'value.unique'=>'Ya existe el valor!'

        // ];

        // $this->validate('$rules','$messages');

        //////////fin validacion
        
        $denominacion = Denominacion::create([
            'type' => $this->type,
            'values' => $this->values,

        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/monedas', $customFileName);

            $denominacion->image = $customFileName;

            $denominacion->save();
            //limpiar los impusts
        }
        $this->resetUI();
        $this->emit('denominacion-added','denominacion registrada');

    }

        public function resetUI(){
                $this->type='';
                $this->values='';
                $this->search='';
                $this->selected_id=0;
                $this->image=null;
        }



        public function Update(){
            
        //     $rules = [
        
        


        //     ];

        //     $messages=[


        //         'type.required' => 'El tipo es requerido',
        //         'type.not_in'=>'Elige un tipo válido',
        //         'value.required'=> 'El valor es requerido',
        //         'value.unique'=> 'El valor ya existe'


        //   ];
            //     $this->validate('$rules','$messages');

                $denominacion1 = Denominacion::find($this->selected_id);
                $denominacion1->update([
                    'type' => $this->type,
                    'values' => $this->values

                ]);


                    if($this->image)
                    {
                        $customFileName =uniqid() . '_.' . $this->image->extension();
                        $this->image->storeAs('public/monedas', $customFileName);

                        $imageName = $denominacion1->image;

                        $denominacion1->image = $customFileName;
                        $denominacion1->save();

                        if($imageName !=null)
                            if(file_exists('storage/monedas' . $imageName))
                            {unlink('storage/monedas' . $imageName);}
                            
                    }

                    $this->resetUI();
                    $this->emit('denominacion-updated', 'Denominacion Actualizada');
                    


 
                }

//////////////////////////////////////////////////////////////////////////
               
        protected $listeners = [
                    'deleteRow'=>'Destroy'
                ];
          
       

        public function Destroy($id)
        {

                    $denominacion=Denominacion::find($id);
                    $imageName=$denominacion->image;
                                // imagen temporal
                    $denominacion->delete();
                    //is para eliminar los restos imagen en el storage
                    if($imageName != null) {
                        unlink('storage/monedas/'.$imageName);
                    }

                    $this->resetUI(); //para limpiar los input
                    $this->emit('denominacion-deleted', 'Denominacion Eliminada');


        }



    
}
