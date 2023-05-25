<div>
    {{-- Do your work, then step back. --}}
    <!-- component -->
    <x-table>
        <div class="px-6 py-4 flex item-center">
            <div class="flex items-center">
                <span>Mostrar</span>
                <select wire:model="cant" name="" id="" class="mx-2 form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>Entradas</span>
            </div>
            {{-- <input type="text" name="" id="" wire:model="search"> --}}
            <x-input class="flex-1 mx-4" wire:model="search" type="text" placeholder="Que quiere buscar?"></x-input>
            @livewire('create-post')
        </div>

        @if ($posts->count())
        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="w-24 cursor-pointer px-6 py-4 font-medium text-gray-900" wire:click="order('id')">ID
                        @if ($sort=="id")
                            @if ($direction=="asc")
                                <i class="fa-solid fa-arrow-down-1-9 float-right mt-1"></i>
                            @else
                                <i class="fa-solid fa-arrow-down-9-1 float-right mt-1"></i>
                            @endif
                        @else
                            <i class="fa-solid fa-sort float-right mt-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-4 font-medium text-gray-900" wire:click="order('title')">Title 
                        @if ($sort=="title")
                            @if ($direction=="asc")
                                <i class="fa-solid fa-arrow-up-z-a float-right mt-1"></i>
                            @else
                                <i class="fa-solid fa-arrow-down-z-a float-right mt-1"></i>
                            @endif
                        @else
                            <i class="fa-solid fa-sort float-right mt-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="cursor-pointer px-6 py-4 font-medium text-gray-900" wire:click="order('content')">Content
                        @if ($sort=="content")
                            @if ($direction=="asc")
                                <i class="fa-solid fa-arrow-up-z-a float-right mt-1"></i>
                            @else
                                <i class="fa-solid fa-arrow-down-z-a float-right mt-1"></i>
                            @endif
                        @else
                            <i class="fa-solid fa-sort float-right mt-1"></i>
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                @foreach ($posts as $item)
                    <tr class="hover:bg-gray-50">
                        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                            <div class="font-medium text-gray-700">{{ $item->id }}</div>
                        </th>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                {{ $item->title }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $item->content }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-4">
                                {{-- <a x-data="{ tooltip: 'Delete' }" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6" x-tooltip="tooltip">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </a> --}}
                                {{-- @livewire('edit-post', ['post' => $post], key($post->id)) --}}
                                <a class="btn btn-green" wire:click="edit({{ $item }})">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="px-4 py-4">
                No existe ningun registro que coincida con la busqueda {{ $search }}.
            </div>
        @endif

        @if ($posts->hasPages())
        {{-- si en num de paginas es mayor a 1 se muestra el siguiente div --}}
        <div class="px-6 py-3">
            {{-- este se encarga de mostrar pagindo los resultados (buscar como lo hace xq quede en ls misms jjj) --}}
            {{ $posts->links() }}
        </div>
        @endif
    </x-table>

    <x-dialog-modal wire:model="open_edit">
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
            <x-secondary-button wire:click="$set('open_edit', false)">Cancelar</x-secondary-button>
            <x-danger-button wire:click="update" wire:loading.attr="disabled" wire:target="save, image" class="disabled:opacity-25">Actualizar</x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>