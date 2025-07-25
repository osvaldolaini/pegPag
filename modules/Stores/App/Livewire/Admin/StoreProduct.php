<?php

namespace Modules\Stores\App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use App\Services\LaiGuz\TableService; // Importe o serviço refatorado
use Modules\Products\App\Models\Product;
use Modules\Stores\App\Models\ProductsStore;
use Modules\Stores\App\Models\Store;

class StoreProduct extends Component
{
    public $breadcrumb = 'Produtos';
    public $productsStore;
    public $products;
    public $store_id;
    public $stores;

    public function mount(Store $stores)
    {
        $this->stores = $stores;
        $this->store_id = $stores->id;
        $this->productsStore = $stores->products;
        $inList = $stores->products->pluck('product_id')->toArray();

        $this->products = Product::where('active', 1)
            ->whereNotIn('id', $inList)
            ->get();
    }


    public function render()
    {
        $this->breadcrumb = 'Produtos da loja: ' . $this->stores->title;
        return view('stores::livewire.admin.store-product');
    }

    //DELETE
    public function delete($id)
    {
        $data = ProductsStore::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }

    public function insert($productId)
    {
        $stores = Store::find($this->store_id);

        ProductsStore::updateOrCreate(
            [
                'store_id'   => $this->store_id,
                'product_id' => $productId,
            ],
            [
                'active'     => 1,
            ]
        );

        // Atualiza a lista para não mostrar o mesmo produto de novo
        $this->mount($stores);

        $this->openAlert('success', 'Produto inserido com sucesso');
    }


    public function remove($id)
    {
        $stores = ProductsStore::where('id', $id)->first();
        $stores->active = 0;
        $stores->save();
        $stores = Store::find($stores->store_id);
        $this->mount($stores);
        $this->openAlert('success', 'Produto removido com sucesso.');
    }

    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
