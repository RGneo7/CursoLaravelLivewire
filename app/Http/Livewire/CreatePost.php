<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
//para la carga de imagenes
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open=false;
    public $title, $content, $image, $identificador;

    public function mount(){
        //lo siguiente es para definir que le agregue un valor aleatorio cn la intencion de obligar al renderizado a cambiar el valor por defecto del conponente de carga de imagen
        $this->identificador=rand();
    }

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

        $image=$this->image->store('public/storage/posts');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image
        ]);
        // devolvemos los vlores a los que estan por defecto
        $this->reset(['open', 'title', 'content', 'image']);

        $this->identificador=rand();

        // llamamos al metodo render para que guaraddo el nuevo registro este se refleje en la vista
        // $this->emit('render');
        //en caso de especificar cual componente en especifico es el que se desea renderizar
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se creo satisfactoriamente.');
    }

    public function updatingOpen(){
        if($this->open==false){
            $this->reset(['title', 'content', 'image']);
            $this->identificador=rand();
            $this->emit('resetCKEditor');
        } 
    }
}
