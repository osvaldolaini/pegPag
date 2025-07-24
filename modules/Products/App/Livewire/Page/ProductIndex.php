<?php

namespace Modules\Products\App\Livewire\Page;

use Livewire\Component;
use Modules\Products\App\Models\Product;

class ProductIndex extends Component
{
    public $products;
    public $cart;
    public function mount()
    {
        $this->products = Product::where('active', 1)->get();
        $this->cart = session()->get('cart', []);
    }
    public function render()
    {
        return view('products::page.product-index')
            ->layout('components.layouts.shopping', [
                'title' => 'Página pública de Product',
                'meta_description' => 'Descrição detalhada da página Product.',
                'meta_keywords' => 'product, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
    public function addToCartRedirect($productId)
    {
        $this->closeAlert();
        $product = collect($this->products)->firstWhere('id', $productId);

        if (!$product) return;

        // Verifica se já existe no carrinho
        $index = collect($this->cart)->search(fn($item) => $item['product_id'] === $productId);

        if ($index !== false) {
            $this->cart[$index]['quantity'] += 1;
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'title' => $product->title,
                'price' => $product->value,
                'image' => url('storage/products/' . $product->id . '/' . $product->code_image . '_list.png'),
                'quantity' => 1,
            ];
        }


        session(['cart' => $this->cart]);
        redirect()->route('cart')->with('success', 'Produto adicionado com sucesso.');
    }

    public function addToCart($productId)
    {
        $this->closeAlert();
        $product = collect($this->products)->firstWhere('id', $productId);

        if (!$product) return;

        // Verifica se já existe no carrinho
        $index = collect($this->cart)->search(fn($item) => $item['product_id'] === $productId);

        if ($index !== false) {
            $this->cart[$index]['quantity'] += 1;
        } else {
            $this->cart[] = [
                'product_id' => $product->id,
                'title' => $product->title,
                'price' => $product->value,
                'image' => url('storage/products/' . $product->id . '/' . $product->code_image . '_list.png'),
                'quantity' => 1,
            ];
        }


        session(['cart' => $this->cart]);

        $this->openAlert('success', 'Produto adicionado com sucesso.');
    }

    public function removeFromCart($productId)
    {
        $this->closeAlert();
        $this->cart = collect($this->cart)
            ->reject(fn($item) => $item['product_id'] === $productId)
            ->values()
            ->toArray();

        session(['cart' => $this->cart]);
        $this->openAlert('success', 'Produto removido com sucesso.');
    }

    public function isInCart($productId): bool
    {
        return collect($this->cart)->contains(fn($item) => $item['product_id'] === $productId);
    }

    public function closeAlert()
    {
        $this->dispatch('closeAlert');
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
