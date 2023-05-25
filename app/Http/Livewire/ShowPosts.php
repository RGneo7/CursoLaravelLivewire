<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
//para la carga de imagenes
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search='', $post, $image, $identificador;
    public $sort="id";
    public $direction="desc";
    public $open_edit=false;
    public $cant='10';
    public $readyToLoad=false;

    protected $listeners=['render', 'delete'];

    public $queryString = [
        'cant' => ['except' => '10'],
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'search' => ['except' => '']
    ];

    public function mount(Post $post){
        $this->post=$post;
        //lo siguiente es para definir que le agregue un valor aleatorio cn la intencion de obligar al renderizado a cambiar el valor por defecto del conponente de carga de imagen
        $this->identificador=rand();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required',
    ];

    public function render()
    {//funcion encargada de renderizar la vista
        // $posts=Post::all();
        // $posts=Post::where('title', 'like', '%' . $this->search . '%');
        if ($this->readyToLoad) {
            $posts=Post::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('content', 'like', '%' . $this->search . '%')
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cant);
        } else {
            $posts=[];
        }
        
        return view('livewire.show-posts', compact('posts'));
    }

    public function loadPosts(){
        $this->readyToLoad=true;
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

    public function delete(Post $post){
        $post->delete();
    }
}
