<?php

namespace Modules\Products\App\Livewire\Page;

use Livewire\Component;

class ProductIndex extends Component
{
    public function render()
    {
        return view('products::livewire.page.product-index')
            ->layout('components.layouts.page', [
                'title' => 'Página pública de Product',
                'meta_description' => 'Descrição detalhada da página Product.',
                'meta_keywords' => 'product, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}