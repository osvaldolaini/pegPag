<?php

namespace Modules\Products\App\Livewire\Admin;

use Modules\Products\App\Models\Product;

use Livewire\Component;

use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductForm extends Component
{
    public $rules;

    public $back = 'products.products-list';
    public $route = 'products.products';

    public $breadcrumb = 'Produto';
    public $product;

    //Fields
    public $id;
    public $title;
    public $code;
    public $value;
    public $logo_path;

    use WithFileUploads;

    public $uploadimage;
    public $photo;

    public function mount(Product $product)
    {
        if ($product->getAttributes()) {
            $this->product      = $product;
            $this->id           = $product->id;
            $this->title        = $product->title;
            $this->value        = $product->value_view;
            $this->code         = $product->code;
            $this->logo_path    = $product->logo_path;
            if ($this->logo_path) {
                $this->photo        = $product->id . '/' . $product->logo_path;
            }
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

    //UPLOAD

    public function updated($property)
    {
        if ($property === 'uploadimage') {
            $this->validate([
                'uploadimage' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ]);

            $directory = 'products/' . $this->product->id;
            $fullPath = storage_path('app/' . $directory);

            // Apaga apenas a imagem anterior, se existir
            if ($this->product->logo_path) {
                Storage::delete($directory . '/' . $this->product->logo_path);
            }

            if ($this->uploadimage) {
                $ext = $this->uploadimage->getClientOriginalExtension();
                $code = Str::uuid();
                $new_name = $code . '.jpg';

                // Criar diretório com permissões forçadas
                if (!file_exists($fullPath)) {
                    umask(0); // Remove restrições do sistema
                    mkdir($fullPath, 0755, true);
                }
                chmod($fullPath, 0755); // Garante a permissão correta

                // Salvar a nova imagem
                $this->uploadimage->storeAs($directory, $new_name, 'public');
                // $this->uploadimage->storeAs('logos-school', $new_name, 'public');

                // Atualizar o caminho da imagem no banco
                $this->product->logo_path = $new_name;
                $this->product->save();

                // Chamar a função logo
                $this->logo(
                    'products/' . $this->product->id . '/' . $new_name,
                    $this->product->id,
                    $code
                );
            }
        }
    }


    public function excluirTemp()
    {
        $this->uploadimage = '';
    }
    public function excluirPhoto()
    {
        $this->product->logo_path = '';
        $this->product->save();
        if (Storage::directoryMissing('public/products/' . $this->product->id)) {
            Storage::makeDirectory('public/products/' . $this->product->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/products/' . $this->product->id);
        $this->photo = $this->product->logo_path;
    }

    public static function logo($path, $id, $code)
    {
        // Corrige o caminho do arquivo original
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            throw new \Exception("Imagem não encontrada: " . $fullPath);
        }

        // Criar o gerenciador de imagem
        $manager = new ImageManager(new Driver());

        // Carregar a imagem
        $image = $manager->read($fullPath);

        // Caminho de destino
        $savePath = storage_path('app/public/products/' . $id . '/');

        // Criar diretório se não existir
        if (!file_exists($savePath)) {
            umask(0022); // Garante permissões adequadas
            mkdir($savePath, 0755, true);
            chmod($savePath, 0755); // Ajusta a permissão corretamente
        }

        // Criar versões redimensionadas da imagem
        $image->scale(width: 200)
            ->toPng()
            ->save($savePath . $code . '_big.png');

        $image->scale(width: 30)
            ->toPng()
            ->save($savePath . $code . '_small.png');

        // Criar imagem para a lista
        $footer = $manager->read($fullPath);
        $footer->scale(width: 60)
            ->toPng()
            ->save($savePath . $code . '_list.png');
    }
}
