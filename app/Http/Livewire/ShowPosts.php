<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class ShowPosts extends Component
{

    public $search;

    public function render()
    {
        // $posts=Post::all();
        // $posts=Post::where('title', 'like', '%' . $this->search . '%');
        $posts=Post::where('title', 'like', '%' . $this->search . '%')->orWhere('content', 'like', '%' . $this->search . '%')->get();
        return view('livewire.show-posts', compact('posts'));
    }
}
