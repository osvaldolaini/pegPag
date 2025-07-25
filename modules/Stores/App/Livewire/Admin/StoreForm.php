<?php

namespace Modules\Stores\App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Modules\Stores\App\Models\Store;

class StoreForm extends Component
{
    public $rules;

    public $back = 'stores.stores-list';
    public $route = 'stores.stores';

    public $breadcrumb = 'Loja';
    public $store;

    //Fields
    public $id;
    public $title;
    public $code;
    public $key_pix;
    public $city_pix;
    public $logo_path;
    public $acronym;
    public $cpf_cnpj;
    public $postalCode;
    public $number;
    public $address;
    public $district;
    public $city;
    public $state;
    public $complement;

    use WithFileUploads;

    public $uploadimage;
    public $photo;

    public function mount(Store $store)
    {
        if ($store->getAttributes()) {
            $this->store        = $store;
            $this->id           = $store->id;
            $this->title        = $store->title;
            $this->key_pix      = $store->key_pix;
            $this->city_pix     = $store->city_pix;
            $this->code         = $store->code;
            $this->logo_path    = $store->logo_path;
            $this->acronym = $store->acronym;
            $this->id = $store->id;
            $this->cpf_cnpj = $store->cpf_cnpj;
            $this->postalCode = $store->postalCode;
            $this->number = $store->number;
            $this->address = $store->address;
            $this->district = $store->district;
            $this->city = $store->city;
            $this->state = $store->state;
            $this->complement = $store->complement;
            $this->logo_path = $store->logo_path;
            if ($this->logo_path) {
                $this->photo        = $store->id . '/' . $store->logo_path;
            }
        }
    }

    public function render()
    {
        return view('stores::livewire.admin.store-form');
    }
    public function save()
    {
        $id = $this->real_save();
        // if ($id) {
        //     redirect()->route($this->route . '-edit', $id)->with('success', 'Registro criado com sucesso.');
        // }
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
            'postalCode'   => 'required',
        ];
        $this->validate();
        if ($this->id) {
            Store::updateOrCreate([
                'id'    => $this->id,
            ], [
                'title'     => $this->title,
                'key_pix' => $this->key_pix,
                'city_pix' => $this->city_pix,
                'code'      => $this->code,
                'title' => $this->title,
                'acronym' => $this->acronym,
                'cpf_cnpj' => $this->cpf_cnpj,
                'postalCode' => $this->postalCode,
                'number' => $this->number,
                'address' => $this->address,
                'district' => $this->district,
                'city' => $this->city,
                'state' => $this->state,
                'complement' => $this->complement,
            ]);

            $id = false;
            $msg = 'Registro editado com sucesso.';
        } else {
            $store = Store::create([
                'active'    => 1,
                'title'     => $this->title,
                'key_pix' => $this->key_pix,
                'city_pix' => $this->city_pix,
                'code'      => $this->code,
                'title' => $this->title,
                'acronym' => $this->acronym,
                'cpf_cnpj' => $this->cpf_cnpj,
                'postalCode' => $this->postalCode,
                'number' => $this->number,
                'address' => $this->address,
                'district' => $this->district,
                'city' => $this->city,
                'state' => $this->state,
                'complement' => $this->complement,
            ]);
            $id = $store->id;
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
        if ($property === 'postalCode') {
            $cep = str_replace('-', '', $this->postalCode);
            // dd($cep);
            $ch = curl_init("https://viacep.com.br/ws/" . $cep . "/json/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch));
            curl_close($ch);
            if ($result) {
                $this->address = $result->logradouro;
                $this->city = $result->localidade;
                $this->district = $result->bairro;
                $this->state = $result->uf;
                $this->city_pix = $result->ibge;
            }
        }
        if ($property === 'uploadimage') {
            $this->validate([
                'uploadimage' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ]);

            $directory = 'stores/' . $this->store->id;
            $fullPath = storage_path('app/' . $directory);

            // Apaga apenas a imagem anterior, se existir
            if ($this->store->logo_path) {
                Storage::delete($directory . '/' . $this->store->logo_path);
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
                $this->store->logo_path = $new_name;
                $this->store->save();

                // Chamar a função logo
                $this->logo(
                    'stores/' . $this->store->id . '/' . $new_name,
                    $this->store->id,
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
        $this->store->logo_path = '';
        $this->store->save();
        if (Storage::directoryMissing('public/stores/' . $this->store->id)) {
            Storage::makeDirectory('public/stores/' . $this->store->id, 0755, true, true);
        }
        Storage::deleteDirectory('public/stores/' . $this->store->id);
        $this->photo = $this->store->logo_path;
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
        $savePath = storage_path('app/public/stores/' . $id . '/');

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
