<?php

namespace Modules\Stores\App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

use App\Services\LaiGuz\TableService; // Importe o serviço refatorado
use Modules\Stores\App\Models\Store;

class StoreList extends Component
{
    public $modal = true;
    public $showJetModal = false;
    public $showModalView = false;
    public $showModalForm = false;
    public $alertSession = false;
    public $rules;
    public $detail;
    public $registerId;
    public $id;
    public $breadcrumb = 'Lojas';
    public $store;

    // Propriedades do Livewire, que podem ser bindadas ao front-end
    public string $model = "Modules\Stores\App\Models\Store";
    public string $modelId = "id"; // 'id' ou 'stores.id'
    public ?string $search = null; // Termo de busca
    public array $sorts = ['title' => 'asc']; // Ordenação
    public ?string $relationTables = null; // String de joins
    public ?array $customSearch = null; // Mapeamento de busca customizada
    public string $columnsInclude = 'title,logo_path,active as status';
    public string $searchableColumns = 'title'; // Colunas pesquisáveis

    public int $paginate = 15; // Itens por página
    public string $activeColumnName = 'active'; // Coluna de ativo/inativo

    public bool $showInactive = false; // Propriedade para controlar o checkbox "ver excluídos"

    // Listener para o evento 'see_excluded' do front-end
    // Ex: <input type="checkbox" wire:model.live="showInactive" />
    public function updatedShowInactive()
    {
        $this->resetPage(); // Resetar a paginação ao mudar o filtro de ativo/inativo
    }

    // Você pode ter um método para resetar a busca, etc.
    public function resetSearch()
    {
        $this->search = null;
        $this->resetPage();
    }


    public function render(TableService $queryService)
    {
        // Lógica de permissão de visualização de excluídos
        $userCanSeeInactive = false;
        if (Auth::check()) { // Sempre verifique se o usuário está autenticado
            $userGroups = Auth::user()->jsonGroups ?? [];
            if ((in_array('admin', $userGroups) || in_array('super_admin', $userGroups)) && Auth::user()->see_excluded) {
                $userCanSeeInactive = true;
            }
        }

        $dataTable = $queryService
            ->forModel($this->model)
            ->withModelId($this->modelId)
            ->select($this->columnsInclude)
            ->searchable($this->searchableColumns)
            ->orderBy($this->sorts)
            // ->where(['type' => 0]) // Exemplo de condição WHERE fixa para esta tabela
            ->paginate($this->paginate)
            ->search($this->search ?? '') // Passa o termo de busca (ou vazio se não houver)
            ->withCustomSearch($this->customSearch ?? [])
            ->usingActiveColumn($this->activeColumnName)
            ->includeInactive($userCanSeeInactive && $this->showInactive) // Passa a decisão final para o serviço
            ->get();

        return view(
            'stores::livewire.admin.store-list',
            compact('dataTable')
        );
    }

    public function addSort($field)
    {
        // dd($field);
        if (isset($this->sorts[$field])) {
            $this->sorts[$field] = $this->sorts[$field] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sorts = [];
            $this->sorts[$field] = '';
            $this->sorts[$field] = 'asc';
        }
        // dd($this->sorts);
    }

    //CREATE
    public function showCreate()
    {
        if ($this->modal) {
            $this->showModalForm = true;
            $this->store = '';
        } else {
            redirect()->route('stores.store-create');
        }
    }

    //Update
    public function showUpdate($id)
    {

        if ($this->modal) {
            $this->showModalForm = true;
            $this->store = Store::find($id);
        } else {
            redirect()->route('stores.store-edit', $id);
        }
    }

    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->id = $id;
        } else {
            $this->id = '';
        }
    }
    public function delete($id)
    {
        $data = Store::where('id', $id)->first();
        $data->active = 0;
        $data->save();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }
    //ACTIVE
    public function buttonActive($id)
    {
        $data = Store::where('id', $id)->first();
        if ($data->active == 1) {
            $data->active = 0;
            $data->save();
        } else {
            $data->active = 1;
            $data->save();
        }
        $this->openAlert('success', 'Registro atualizado com sucesso.');
    }
    //MESSAGE
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
}
