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

    public $description;

    public function mount()
    {
        $this->description = 'TX' . uniqid();
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
            'store_id'  => session('store.id'),
            'items'     => json_encode($this->cart),
            'customer'  => json_encode([
                'name'  => $this->name,
                'cpf'   => $this->cpf,
                'phone' => $this->phone,
            ]),
            'pix_code'  => $this->description,
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
        // $this->pixQrCode = $this->generatePixPayload(
        //     session('pix.key'),  // chave Pix real aqui
        //     session('pix.title'),
        //     session('pix.city'),
        //     $this->description,
        //     $this->total
        // );

        $this->pixQrCode = $this->generateStaticPixPayload(
            session('pix.key'),  // chave Pix real aqui
            session('pix.title'),
            session('pix.city'),
            $this->total,
            $this->description
        );
    }
    function generateStaticPixPayload($pixKey, $name, $city, $amount = null, $description = null)
    {
        $payload = [
            '00' => '01', // Payload format indicator
            '26' => [ // Merchant Account Information
                '00' => 'BR.GOV.BCB.PIX',
                '01' => $pixKey,
                '02' => $description ?? '',
            ],
            '52' => '0000', // Merchant category code
            '53' => '986', // Currency (986 = BRL)
            '54' => number_format($amount, 2, '.', ''), // Amount
            '58' => 'BR', // Country code
            '59' => mb_substr($name, 0, 25), // Name (máx 25)
            '60' => mb_substr($this->sanitizePixText($city), 0, 15), // City (máx 15)
            '62' => [ // Additional data
                '05' => '***',
            ],
        ];

        $emv = '';
        foreach ($payload as $id => $value) {
            if (is_array($value)) {
                $sub = '';
                foreach ($value as $subId => $subValue) {
                    $sub .= $subId . str_pad(strlen($subValue), 2, '0', STR_PAD_LEFT) . $subValue;
                }
                $emv .= $id . str_pad(strlen($sub), 2, '0', STR_PAD_LEFT) . $sub;
            } else {
                $emv .= $id . str_pad(strlen($value), 2, '0', STR_PAD_LEFT) . $value;
            }
        }

        // Adiciona campo do CRC com placeholder
        $emv .= '6304';

        // Calcula o CRC16 do conteúdo até antes de 6304
        $crc = $this->crc16($emv);
        $crc = str_pad($crc, 4, '0', STR_PAD_LEFT);

        return $emv . $crc;
    }
    function sanitizePixText($text)
    {
        // Remove acentos e transforma para ASCII
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        // Remove qualquer caractere não alfanumérico ou espaço
        return preg_replace('/[^A-Za-z0-9 ]/', '', $text);
    }



    function crc16(string $payload): string
    {
        $polynomial = 0x1021;
        $result = 0xFFFF;

        for ($offset = 0; $offset < strlen($payload); $offset++) {
            $result ^= (ord($payload[$offset]) << 8);
            for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                if (($result & 0x8000) !== 0) {
                    $result = ($result << 1) ^ $polynomial;
                } else {
                    $result <<= 1;
                }
                $result &= 0xFFFF; // mantém o valor em 16 bits
            }
        }

        return strtoupper(str_pad(dechex((int)$result), 4, '0', STR_PAD_LEFT));
    }
}
