<!-- formaulario para agregar a las productos -->
@include('common.modalHead')
<div class="row">

    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label >Nombre</label>
            <input type= "text" wire:model.lazy="nombre" class="form-control" placeholder="ej: Curso Laravel" >
            @error('nombre') <span class= "text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Código</label>
            <input type= "text" wire:model.lazy= "barcode" class="form-control" placeholder="ej: 025974" >
            @error('barcode') <span class= "text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class= "form-group">
            <label >Costo</label>
            <input type= "text" data-type='currency'
    wire:model.lazya="costo" class="form-control" placeholder="ej: 0.00" >
            @error('costo') <span class= "text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Precio</label>
            <input type= "text" data-type='currency'
    wire:model.lazy= "precio" class="form-control" placeholder="ej: 025974" >
            @error('precio') <span class= "text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class= "form-group">
            <label >Stock</label>
            <input type= "number" wire:model.lazy="stock" class= "form-control" placeholder="ej: 0" >
            @error('stock') <span class= "text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class= "form-group">
            <label >Alerta/inv_min</label>
            <input type= "number" wire:model.lazy="alerta" class= "form-control" placeholder="ej: 0" >
            @error('alerta') <span class= "text-danger er">{{ $message}}</span>@enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
    <div class="form-group">
        <label>Categoria</label>
        <select wire:model='categoriaid' class="form-control">
            <option value="Elegir" disabled>Elegir</option>

            @foreach($categorias as $category)
            <option value="{{$category->id}}" >{{$category->nombre}}</option>
            @endforeach

        </select>
        @error('categoriaid') <span class= "text-danger er">{{ $message}}</span>@enderror
    </div>
    </div>

    <div class="col-sm-12 col-md-8">
    <div class= "form-group custom-file">
        <input type="file" class="custom-file-input form-control" wire:model="image"
        accept="image/x-png, image/gif, image/jpeg">
        <label class="custom-file-label">Imagen {{$image}}</label>
        @error('image') <span class= "text-danger er">{{$message}}</span>@enderror
    </div>
    </div>

</div>



@include('common.modalFooter')





