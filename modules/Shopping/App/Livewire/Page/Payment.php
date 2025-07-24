<?php

namespace Modules\Shopping\App\Livewire\Page;

use App\Models\Admin\Settings;
use App\Traits\PixQqrCode;
use Livewire\Component;

use AssisDev\PixQrCode\Payload;

use Illuminate\Support\Str;
use Modules\Shopping\App\Models\Sales;

class Payment extends Component
{
    use PixQqrCode;

    public $cart = [];
    public $name;
    public $cpf;
    public $phone;
    public $total = 0;

    public $paid = false;
    public string $pixQrCode = '';

    public function mount()
    {
        $this->cart = session('cart', []);

        $this->name = session('checkout.name');
        $this->cpf = session('checkout.cpf');
        $this->phone = session('checkout.phone');

        $this->total = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $this->generatePixQrCode();
    }
    public function simulatePayment()
    {
        $this->paid = true;
        $sale = Sales::create([
            'active'    => 1,
            'items'     => json_encode($this->cart),
            'customer'  => json_encode([
                'name' => $this->name,
                'cpf' => $this->cpf,
                'phone' => $this->phone,
            ]),
            'pix_code'  => 'TX' . uniqid(),
            'value'     => $this->total
        ]);
        session()->forget(['cart', 'checkout.name', 'checkout.cpf', 'checkout.phone']);
        // dd($sale);
        // Redirecionar após um pequeno delay para visualização da animação
        $this->dispatch('redirect-to-list');
    }

    public function render()
    {
        return view('shopping::livewire.page.payment')
            ->layout('components.layouts.shopping', [
                'title' => 'Página pública de Shopping',
                'meta_description' => 'Descrição detalhada da página Shopping.',
                'meta_keywords' => 'shopping, blog, laravel',
                'meta_image' => asset('images/home-banner.jpg'),
            ]);
    }

    protected function generatePixQrCode()
    {
        $config = Settings::find(1);
        $this->pixQrCode = $this->generatePixPayload(
            'osvaldolaini@hotmail.com',  // chave Pix real aqui
            $config->title,
            $config->city,
            'TX' . uniqid(),
            $this->total
        );
    }
}
