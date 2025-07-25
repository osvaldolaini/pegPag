<?php

namespace Modules\Stores\App\Livewire\Page;

use Livewire\Component;

class StoreIndex extends Component
{
    public function render()
    {
        return view('stores::livewire.page.store-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Store',
                'meta_description' => 'Descrição detalhada da página Store.',
                'meta_keywords' => 'store, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}