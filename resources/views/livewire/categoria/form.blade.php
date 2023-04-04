<!-- formaulario para agregar a las categorias -->
@include('common.modalHead')

<div class="col-sm-12">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <span class="fas fa-edit">
                </span>
            </span>
        </div>
        <input type="text" wire:model.lazil="nombre" class="form-control" placeholder="ejemplo">
    </div>
    @error('nombre') <span class="text-danger er">{{ $message }}</span>@enderror

    <div class="col-sm-12 mt-3">
        <div class="input-group custom-file">
            <input type="file" class="custom-file-input" wire:model="image" class="form-control" acept="image/x-png, image/gif, image/jpeg" >
            
            <label class="custom-file-label">Imagen {{$image}}</label>
            @error('image') <span class="text-danger er">{{ $message }}</span>@enderror
        </div>
    </div>

</div>

@include('common.modalFooter')





