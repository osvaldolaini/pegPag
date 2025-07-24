<?php

namespace App\Livewire\Admin\Page;

use App\Models\Admin\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Shopping\App\Models\Sales;

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


    public function mount()
    {
        $this->totalSales = Sales::count();
        $this->totalValue = Sales::sum('value');
        $this->averageTicket = $this->totalSales ? $this->totalValue / $this->totalSales : 0;
        $this->lastSaleDate = Sales::latest()->first()?->created_at;
        $this->recentSales = Sales::latest()->take(5)->get();


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
        return view('livewire.admin.page.panel');
    }
}
