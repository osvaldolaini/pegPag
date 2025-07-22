<?php

namespace App\Livewire\Admin\Page;

use App\Models\Admin\Settings;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Panel extends Component
{
    public $config;

    public function mount()
    {
        $this->config = Settings::find(1);
        if (!Auth::user()) {
            $this->redirect('home');
        }
    }
    public function render()
    {
        return view('livewire.admin.page.panel');
    }
}
