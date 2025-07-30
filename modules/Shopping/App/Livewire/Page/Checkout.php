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
                'title' => 'Peg & Pag - App',
                'meta_description' => 'Sistema auto atendimento simplificado.',
                'meta_keywords' => 'loja, produtos, pegue e pague',
                'meta_image' => asset('logos/logo.png'),
            ]);
    }
}
