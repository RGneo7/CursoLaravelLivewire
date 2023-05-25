<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
//para la carga de imagenes
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditPost extends Component
{
    use WithFileUploads;

    public $post, $open=false, $image, $identificador;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function save(){
        $this->validate();
        if ($this->image) {//si existia una imagen ya en este post
            Storage::delete([$this->post->image]);//elimino

            $this->post->image = $this->image->store('posts');//y reemplazo por la nueva
        }
        $this->post->save();
        $this->reset(['open', 'image']);
        //lo siguiente es para definir que le agregue un valor aleatorio cn la intencion de obligar al renderizado a cambiar el valor por defecto del conponente de carga de imagen
        $this->identificador=rand();
        $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se actualizo satisfactoriamente.');
    }

    public function mount(Post $post){
        $this->post=$post;
        //lo siguiente es para definir que le agregue un valor aleatorio cn la intencion de obligar al renderizado a cambiar el valor por defecto del conponente de carga de imagen
        $this->identificador=rand();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
