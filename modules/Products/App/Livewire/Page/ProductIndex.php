<?php

namespace Modules\Products\App\Livewire\Page;

use Livewire\Component;
use Modules\Products\App\Models\Product;
use Modules\Stores\App\Models\Store;

class ProductIndex extends Component
{
    public $inStock;
    public $stores;
    public $store;
    public $cart;
    public $active;

    public function mount()
    {
        $this->store = Store::where('active', 1)->first();
        $this->active = $this->store->id;
        $this->stores = Store::where('active', 1)->get();
        $this->cart = session()->get('cart', []);

        session([
            'pix.key' => $this->store->key_pix,
            'pix.city' => $this->store->city_pix,
            'pix.name' => strtolower($this->store->title),
        ]);
    }
    public function changeStore($id)
    {
        session()->forget(['cart']);
        $this->cart = session()->get('cart', []);
        $this->store = Store::find($id);
        session([
            'store.id' => $this->store->id,
            'pix.key' => $this->store->key_pix,
            'pix.city' => mb_strtoupper($this->store->city),
            'pix.name' => strtolower($this->store->title),
        ]);
        $this->active = $this->store->id;
        $this->inStock = $this->store->products;

        $this->dispatch('update-cart');
    }

    public function render()
    {
        $this->inStock = $this->store->products;

        return view('products::page.product-index')
            ->layout('components.layouts.shopping', [
                'title' => 'Peg & Pag - App',
                'meta_description' => 'Sistema auto atendimento simplificado.',
                'meta_keywords' => 'loja, produtos, pegue e pague',
                'meta_image' => asset('logos/logo.png'),
            ]);
    }

    public function addToCartRedirect($productId)
    {
        $this->closeAlert();

        $stock = collect($this->inStock)->firstWhere('product_id', $productId);

        if (!$stock) return;

        // Verifica se já existe no carrinho
        $index = collect($this->cart)->search(fn($item) => $item['product_id'] === $productId);

        if ($index !== false) {
            $this->cart[$index]['quantity'] += 1;
        } else {
            $this->cart[] = [
                'product_id' => $stock->product->id,
                'title' => $stock->product->title,
                'price' => $stock->product->value,
                'image' => url('storage/products/' . $stock->product->id . '/' . $stock->product->code_image . '_list.png'),
                'quantity' => 1,
            ];
        }

        session(['cart' => $this->cart]);

        $this->dispatch('update-cart');
        redirect()->route('cart')->with('success', 'Produto adicionado com sucesso.');
    }

    public function addToCart($productId)
    {
        $this->closeAlert();

        $stock = collect($this->inStock)->firstWhere('product_id', $productId);

        if (!$stock) return;

        // Verifica se já existe no carrinho
        $index = collect($this->cart)->search(fn($item) => $item['product_id'] === $productId);

        if ($index !== false) {
            $this->cart[$index]['quantity'] += 1;
        } else {
            $this->cart[] = [
                'product_id' => $stock->product->id,
                'title' => $stock->product->title,
                'price' => $stock->product->value,
                'image' => url('storage/products/' . $stock->product->id . '/' . $stock->product->code_image . '_list.png'),
                'quantity' => 1,
            ];
        }


        session(['cart' => $this->cart]);

        $this->dispatch('update-cart');

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
        $this->dispatch('update-cart');
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
