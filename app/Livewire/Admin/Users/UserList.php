<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserGroups as EnumsUserGroups;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

use App\Services\LaiGuz\TableService; // Importe o serviço refatorado

class UserList extends Component
{
    use WithPagination;
    public $showJetModal = false;
    public $showModalView = false;
    public $alertSession = false;
    public $rules;
    public $detail;

    public $id;
    public $registerId;

    protected $listeners =
    [
        'showModalRead',
        'showModalDelete'
    ];

    // Propriedades do Livewire, que podem ser bindadas ao front-end
    public string $model = "App\Models\User";
    public string $modelId = "id"; // 'id' ou 'peoples.id'
    public ?string $search = null; // Termo de busca
    public array $sorts = ['name' => 'asc']; // Ordenação
    public ?string $relationTables = null; // String de joins
    public ?array $customSearch = null; // Mapeamento de busca customizada
    public string $columnsInclude = 'name,active as status';
    public string $searchableColumns = 'name'; // Colunas pesquisáveis

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
            'livewire.admin.users.user-list',
            compact('dataTable')
        );
    }


    //CREATE
    public function showModal($id = false)
    {
        if ($id) {
            redirect()->route('user-edit', $id);
        } else {
            redirect()->route('user-create');
        }
    }

    //DELETE
    public function showModalDelete($id)
    {
        $this->showJetModal = true;
        if (isset($id)) {
            $this->registerId = $id;
        } else {
            $this->registerId = '';
        }
    }
    public function delete($id)
    {
        $data = User::find($id);
        $data->delete();

        $this->openAlert('success', 'Registro excluido com sucesso.');

        $this->showJetModal = false;
    }

    //OPEN MESSAGE
    //pega o status do registro
    public function openAlert($status, $msg)
    {
        $this->dispatch('openAlert', $status, $msg);
    }
    #END FUNCTIONS BUTTONS AND MESSAGE
}
