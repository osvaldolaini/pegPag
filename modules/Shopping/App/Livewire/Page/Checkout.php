<?php

namespace Modules\Shopping\App\Livewire\Page;

use Livewire\Component;

class Checkout extends Component
{

    public $name;
    public $cpf;
    public $phone;

    public function mount()
    {
        $this->name = session('checkout.name');
        $this->cpf = session('checkout.cpf');
        $this->phone = session('checkout.phone');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            // 'cpf' => 'required|digits:11',
            'phone' => 'required|min:10|max:15',
        ]);

        session([
            'checkout.name' => $this->name,
            'checkout.cpf' => $this->cpf,
            'checkout.phone' => $this->phone,
        ]);

        return redirect()->route('payment');
    }

    public function render()
    {
        return view('shopping::livewire.page.checkout')
            ->layout('components.layouts.shopping', [
                'title' => 'Página pública de Shopping',
                'meta_description' => 'Descrição detalhada da página Shopping.',
                'meta_keywords' => 'shopping, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }
}
