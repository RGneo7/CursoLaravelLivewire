<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open=true;
    public $title, $content, $image;

    protected $rules= [
        'title' => 'required|max:100',
        'content' => 'required|min:10',
        'image' => 'required|image|max:2048'
    ];

    // // nos permite comprobar que se cumple la regla establecida en rules en tiempo real
    // public function updated($propertyName){
    //     $this->validateOnly($propertyName);
    // }

    public function render()
    {
        return view('livewire.create-post');
    }

    public function save(){
        $this->validate();
        Post::create([
            'title' => $this->title,
            'content' => $this->content
        ]);
        // devolvemos los vlores a los que estan por defecto
        $this->reset(['open', 'title', 'content']);
        // llamamos al metodo render para que guaraddo el nuevo registro este se refleje en la vista
        // $this->emit('render');
        //en caso de especificar cual componente en especifico es el que se desea renderizar
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se creo satisfactoriamente.');
    }
}
