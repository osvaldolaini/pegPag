<?php

namespace Modules\Blog\App\Livewire\Page;

use Livewire\Component;

class PostIndex extends Component
{
    public function render()
    {
        return view('blog::livewire.page.post-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Post',
                'meta_description' => 'Descrição detalhada da página Post.',
                'meta_keywords' => 'post, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}