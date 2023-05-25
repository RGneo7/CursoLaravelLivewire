<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
//para la carga de imagenes
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ShowPosts extends Component
{
    use WithFileUploads;

    public $search, $post, $image, $identificador;
    public $sort="id";
    public $direction="desc";
    public $open_edit=false;

    protected $listeners=['render' => 'render'];

    public function mount(Post $post){
        $this->post=$post;
        //lo siguiente es para definir que le agregue un valor aleatorio cn la intencion de obligar al renderizado a cambiar el valor por defecto del conponente de carga de imagen
        $this->identificador=rand();
    }

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function render()
    {
        // $posts=Post::all();
        // $posts=Post::where('title', 'like', '%' . $this->search . '%');
        $posts=Post::where('title', 'like', '%' . $this->search . '%')
        ->orWhere('content', 'like', '%' . $this->search . '%')
        ->orderBy($this->sort, $this->direction)
        ->get();
        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort){
        if ($this->sort == $sort) {
            if ($this->direction == "desc") {
                $this->direction="asc";
            } else {
                $this->direction="desc";
            }
        } else {
            $this->sort=$sort;
            $this->direction="asc";
        }
        
    }

    public function edit(Post $post){
        $this->post=$post;
        $this->open_edit=true;
    }

    public function update(){
        $this->validate();
        if ($this->image) {//si existia una imagen ya en este post
            Storage::delete([$this->post->image]);//elimino

            $this->post->image = $this->image->store('posts');//y reemplazo por la nueva
        }
        $this->post->save();
        $this->reset(['open_edit', 'image']);
        //lo siguiente es para definir que le agregue un valor aleatorio cn la intencion de obligar al renderizado a cambiar el valor por defecto del conponente de carga de imagen
        $this->identificador=rand();
        // $this->emitTo('show-posts', 'render');
        $this->emit('alert', 'El post se actualizo satisfactoriamente.');
    }
}
