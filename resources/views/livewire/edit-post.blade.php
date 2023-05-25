<div>
    
    <a class="btn btn-green" wire:click="$set('open', true)">
        <i class="fas fa-edit"></i>
    </a>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar el post {{ $post->title }}
        </x-slot>
        <x-slot name="content">
            <div wire:loading wire:targe="image" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Cargando imagen!</strong>
                <span class="block sm:inline">Espere un momento, procesando imagen.</span>
              </div>

            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" alt="">
            @else
              <img src="{{ Storage::url($post->image) }}" alt="">
            @endif
            <div class="mb-4">
                <x-label value="Titulo"></x-label>
                <x-input wire:model="post.title" type="text" class="w-full"></x-input>
            </div>
            <div class="mb-4">
                <x-label value="Contenido"></x-label>
                <textarea wire:model="post.content" name="" id="" rows="6" class="form-control w-full"></textarea>
            </div>
            <div class="mb-4">
                <input type="file" name="" id="{{ $identificador }}" wire:model="image">
                <x-input-error for="image"></x-input-error>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Cancelar</x-secondary-button>
            <x-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-25">Actualizar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
