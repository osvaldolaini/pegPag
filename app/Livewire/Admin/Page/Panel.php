<?php

namespace App\Livewire\Admin\Page;

use App\Models\Admin\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Shopping\App\Models\Sales;
use Modules\Stores\App\Models\Store;

class Panel extends Component
{
    public $config;

    public $totalSales;
    public $totalValue;
    public $averageTicket;
    public $lastSaleDate;

    public $recentSales = [];
    public $selectedSale;
    public $showModal = false;

    public $stores;
    public $store;


    public function mount()
    {
        $this->store = Store::where('active', 1)->first();
        $this->stores = Store::where('active', 1)->get();
        if ($this->store) {
            $this->totalSales = Sales::where('store_id', $this->store->id)->count();
            $this->totalValue = Sales::where('store_id', $this->store->id)->sum('value');
            $this->averageTicket = $this->totalSales ? $this->totalValue / $this->totalSales : 0;
            $this->lastSaleDate = Sales::where('store_id', $this->store->id)->latest()->first()?->created_at;
            $this->recentSales = Sales::where('store_id', $this->store->id)->latest()->take(5)->get();
        }

        $this->config = Settings::find(1);
        if (!Auth::user()) {
            $this->redirect('home');
        }
    }
    public function showSaleDetails($saleId)
    {
        $this->selectedSale = Sales::find($saleId);
        $this->showModal = true;
    }
    public function render()
    {
        // $this->store = Store::where('active', 1)->first();
        // $this->stores = Store::where('active', 1)->get();
        if ($this->store) {
            $this->totalSales = Sales::where('store_id', $this->store->id)->count();
            $this->totalValue = Sales::where('store_id', $this->store->id)->sum('value');
            $this->averageTicket = $this->totalSales ? $this->totalValue / $this->totalSales : 0;
            $this->lastSaleDate = Sales::where('store_id', $this->store->id)->latest()->first()?->created_at;
            $this->recentSales = Sales::where('store_id', $this->store->id)->latest()->take(5)->get();
        }
        return view('livewire.admin.page.panel');
    }
    public function changeStore($id)
    {
        $this->store = Store::where('id', $id)->first();
    }
}
