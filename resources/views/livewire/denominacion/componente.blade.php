

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}} </b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle= "modal" data-target="#theModal">Agregar</a>
                    </li>

                </ul>
            </div>
         
@include('common.searchbox')


            <div class="widget-content">
                    <div class="table-reponsive">
                        <table class= "table table-bordered table striped mt-1">
                            <thead class= "text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class= "table-th text-white">TIPO</th>
                                    <th class= "table-th text-white text-center">VALOR</th>
                                    <th class= "table-th text-white text-center">IMAGEN</th>
                                    <th class= "table-th text-white text-center">ACCIONES</th>
                                </tr>
                            </thead>

                           
                         
                            <tbody>
                                @foreach($data as $coin)
                                <tr >
                                    <td><h6>{{$coin->type}}</h6></td> 
                                    <td><h6>{{number_format($coin->values,2)}}</h6></td>
                                    <td class= "text-center">
                                        <span>
                                            <img src="{{asset('storage/monedas/'.$coin->image)}}" alt="monedas ejem" height="70" width="80" class="rounded">
                                        </span>
                                    </td>

                                   

                                    <td class= "text-center">
                                        <!-- boton de editar -->
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile"
                                        wire:click="Edit({{$coin->id}})" title="Edit"> <i class="fas fa-edit">e</i> </a>
                                        <!-- boton de eliminar -->
                                        <a href="javascript:void(0)" onclick="Confirm('{{$coin->id}}')" class="btn btn-dark" title="delete">  <i class="fas fa-trash">d</i> </a>
                         
                           
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- paginacion -->
                    {{$data->links()}}
                    </div>
            </div>
        </div>   
    </div>
    <!-- formulario  -->
@include('livewire.denominacion.form')

</div>                     
                    
<script>

document.addEventListener('DOMContetLoaded', function(){

    window. livewire.on('modal-show', msg =>{
        $('#theModal').modal('show')
    });


    window.livewire.on('denominacion-added', msg =>{
        $('#theModal').modal ('hide')
    });
    // window.livewire.on('denominacion-updated', msg =>{
    //     $('#theModal').modal ('hide')
    // }); 
   
    // window.livewire.on('denominacion-deleted', msg =>{
       
});
 

//CORRESPONDE AL DELETE DE LOS REGISTROS
function Confirm(id)
{
    

swal({
    title: 'CONFIRMAR',
    text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
    type: 'warning',
    showCancelButton: true,
    cancelButtonText: 'Cerrar',
    cancelButtonColor: '#fff',
    confirmButtonColor: '#3B3F5C',
    confirmButtonText: 'Aceptar'
    }).then(function(result){
        if(result.value){
        window.livewire.emit('deleteRow', id)
        swal.close()
        }
        })
}



</script>