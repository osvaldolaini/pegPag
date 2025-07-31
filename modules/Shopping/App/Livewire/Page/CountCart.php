<?php

namespace Modules\Shopping\App\Livewire\Page;

use Livewire\Attributes\On;
use Livewire\Component;

class CountCart extends Component
{

    public $items;

    public function mount()
    {
        $this->items = session('cart', []);
    }
    #[On('update-cart')]
    public function render()
    {
        $this->items = session('cart', []);
        return view('shopping::livewire.page.count-cart')
            ->layout('components.layouts.shopping');
    }
}
