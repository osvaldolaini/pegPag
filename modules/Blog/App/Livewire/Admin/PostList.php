<?php

namespace Modules\Blog\App\Livewire\Admin;

use Livewire\Component;

class PostList extends Component
{
    public function render()
    {
        return view('blog::livewire.admin.post-list');
    }
}