<?php

namespace Modules\Shopping\App\Livewire\Page;

use Livewire\Component;

class Cart extends Component
{
    public $items = [];
    public $modalRemove = false;
    public $idRemove;

    public function mount()
    {
        $this->items = session('cart', []);
    }

    public function increaseQuantity($productId)
    {
        if (isset($this->items[$productId])) {
            $this->items[$productId]['quantity']++;
        }

        session(['cart' => $this->items]);
    }

    public function decreaseQuantity($productId)
    {
        if (isset($this->items[$productId]) && $this->items[$productId]['quantity'] > 1) {
            $this->items[$productId]['quantity']--;
            session(['cart' => $this->items]);
        } elseif ($this->items[$productId]['quantity'] === 1) {
            $this->modalRemove = true;
            $this->idRemove = $productId;
        }
    }

    public function removeFromCart($productId)
    {
        unset($this->items[$productId]);
        $this->modalRemove = false;
        session(['cart' => $this->items]);
    }

    public function getTotalProperty()
    {
        return collect($this->items)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function render()
    {
        return view('shopping::livewire.page.cart')
            ->layout('components.layouts.shopping', [
                'title' => 'Peg & Pag - App',
                'meta_description' => 'Sistema auto atendimento simplificado.',
                'meta_keywords' => 'loja, produtos, pegue e pague',
                'meta_image' => asset('logos/logo.png'),
            ]);
    }
}
