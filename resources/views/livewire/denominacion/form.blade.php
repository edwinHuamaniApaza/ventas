<!-- formaulario para agregar a las DENOMINACIONES -->


@include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label >Tipo</label>
            <select wire:model="type" class="form-control">
                <option value="Elegir">Elegir</option>
                <option value= "billetes">BILLETE</option>
                <option value= "monedas" >MONEDA</option>
                <option value= "otros" >OTRO</option>
            </select>
            @error('type') <span class="text-danger er">{{ $message }}</span>@enderror

        </div>
    </div>

    <!-- //////////////////////////// -->
    <div class="col-sm-12 col-md-6">
        <label >Valor</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <span class="fas fa-edit">
                    </span>
                </span>
            </div>

            <input type="number" wire:model.lazil="values" class="form-control" placeholder="ejemplo" maxlength="25">
        </div>
        @error('values') <span class="text-danger er">{{ $message }}</span>@enderror
<
    </div>
    <div class="col-sm-12 mt-3">
            <div class="input-group custom-file">
                <input type="file" class="custom-file-input" wire:model="image" class="form-control" acept="image/x-png, image/gif, image/jpeg" >
                
                <label class="custom-file-label">Imagen {{$image}}</label>
                @error('image') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>



</div>
<br>
@include('common.modalFooter')





