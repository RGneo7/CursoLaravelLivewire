<div>
    <x-danger-button wire:click="$set('open', true)">
        Crear nuevo post
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            Crear nuevo post
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-label value="Titulo del post"></x-label>
                <x-input type="text" class="w-full" wire:model="title"></x-input>
                {{-- defer nos sirve pra indicarle a livewire que no es neceseario que renderize la vista --}}
                <x-input-error for="title"></x-input-error>
            </div>
            <div class="mb-4">
                <x-label value="Contenido del post"></x-label>
                <textarea name="" id="" cols="30" rows="6" class="w-full form-control" wire:modelq="content"></textarea>
                <x-input-error for="content"></x-input-error>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Cancelar</x-secondary-button>
            <x-danger-button wire:click="save">Crear Post</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>
