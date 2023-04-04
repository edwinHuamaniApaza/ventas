

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
                                    <th class= "table-th text-white">DESCRIPCIÓN</th>
                                    <th class= "table-th text-white">IMAGEN</th>
                                    <th class= "table-th text-white">ACTIONS</th>
                                </tr>
                            </thead>

                           
                         
                            <tbody>
                                @foreach($categorias as $category)
                                <tr >
                                    <td><h6>{{$category->nombre}}</h6></td> 
                                                                    
                                    <td class= "text-center">
                                        <span>
                                            <img src="{{asset('storage/categorias/'.$category->image)}}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
                                        </span>
                                    </td>

                                   

                                    <td class= "text-center">
                                        <!-- boton de editar -->
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile"
                                        wire:click="Edit({{$category->id}})"                            
                                        title="Edit"> <i class="fas fa-edit">e</i> </a>
                                        <!-- boton de eliminar -->
                                        <a href="javascript:void(0)" onclick="Confirm('{{$category->id}}')" class="btn btn-dark" title="delete">  <i class="fas fa-trash">d</i> </a>
                               <!-- {{$category->imagen}} -->
                               <!-- ,'{{$category->producto->count()>0}}' -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- paginacion -->
                    {{$categorias->links()}}

                    </div>
            </div>
        </div>   
    </div>
    <!-- formulario  -->
@include('livewire.categoria.form')

</div>                     
                    
<script>


document.addEventListener('DOMContentLoaded', function()
{

    window. livewire.on('show-modal2', msg =>{
        $('#theModal').modal ('show')
    });
    window. livewire.on('category-added', msg =>{
        $('#theModal').modal ('hide')
    });
    window. livewire.on('category-updated', msg =>{
        $('#theModal').modal ('hide')
    });


    
    

})
//confirmacion para eliminar  categoria
function Confirm(id,producto)
        {
            if(producto>0)
            {
                swal('NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE PRODUCTOS RELACIONADOS')
                return;
            }

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