<?php

namespace Modules\Products\App\Livewire\Admin;

use Modules\Products\App\Models\Product;

use Livewire\Component;

use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProductForm extends Component
{
    public $rules;

    public $back = 'products.products-list';
    public $route = 'products.product';

    public $breadcrumb = 'Produto';
    //Fields
    public $id;
    public $title;
    public $code;
    public $value;

    public function mount(Product $product)
    {
        if ($product->getAttributes()) {
            $this->id       = $product->id;
            $this->title    = $product->title;
            $this->value    = $product->value_view;
            $this->code     = $product->code;
        }
    }

    public function render()
    {
        return view('products::admin.product-form');
    }
    public function save()
    {
        $id = $this->real_save();
        if ($id) {
            redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        }
    }
    public function save_out()
    {
        $this->real_save();
        redirect()->route($this->route . '-list')->with('success', 'Registro criado com sucesso.');
    }

    public function real_save()
    {
        $this->rules = [
            'title'   => 'required',
            'value'   => 'required',
        ];
        $this->validate();
        if ($this->id) {
            Product::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title' => $this->title,
                'value' => $this->value,
                'code'  => $this->code,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $product = Product::create([
                'active'    => 1,
                'title'     => $this->title,
                'value'     => $this->value,
                'code'      => $this->code,
            ]);
            $id = $product->id;
            $msg = 'Registro criado com sucesso.';
        }

        $this->openAlert('success', $msg);
        return $id;
    }
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
