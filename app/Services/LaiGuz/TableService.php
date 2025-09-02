<?php

namespace App\Services\LaiGuz;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator; // Importar para o retorno do paginate
use Illuminate\Support\Collection; // Importar para o retorno do get

class TableService
{
    protected string $model;
    protected string $modelId = 'id';
    protected array $relationsToJoin = []; // Renomeado para clareza
    protected array $columnsToSelect = ['*']; // Padrão 'select *'
    protected array $searchableColumns = [];
    protected array $sortOrders = [];
    protected array $whereConditions = [];
    protected ?int $perPage = null;
    protected ?string $searchTerm = null;
    protected array $customSearchMapping = []; // Renomeado
    protected string $activeColumn = 'active';
    protected bool $includeInactive = true; // Melhor nome para 'seeExcluded'

    /**
     * Define o modelo Eloquent a ser consultado.
     */
    public function forModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Define a coluna que será usada como ID principal (ex: 'id' ou 'table.id').
     */
    public function withModelId(string $modelId): self
    {
        $this->modelId = $modelId;
        return $this;
    }

    /**
     * Adiciona tabelas para JOIN. Ex: ['table_name', 'fk_column', 'pk_column']
     * Ou no formato original: 'table,key,foreignKey'
     */
    public function joinRelations(array|string $relations): self
    {
        if (is_string($relations)) {
            $parsedRelations = explode('|', str_replace(' ', '', $relations));
            foreach ($parsedRelations as $relation) {
                $this->relationsToJoin[] = explode(',', $relation);
            }
        } else {
            $this->relationsToJoin = array_merge($this->relationsToJoin, $relations);
        }
        return $this;
    }

    /**
     * Define as colunas a serem selecionadas. Ex: 'name,email,created_at'
     */
    public function select(string $columns): self
    {
        // Garante que o ID principal esteja sempre na seleção
        $this->columnsToSelect = array_unique(
            array_merge([$this->modelId . ' as id'], explode(',', $columns))
        );
        return $this;
    }

    /**
     * Define as colunas que serão pesquisadas. Ex: 'name,description'
     */
    public function searchable(string $columns): self
    {
        $this->searchableColumns = explode(',', $columns);
        return $this;
    }

    /**
     * Define a ordenação dos resultados. Ex: ['column' => 'asc', 'other_column' => 'desc']
     */
    public function orderBy(array $sort): self
    {
        $this->sortOrders = $sort;
        return $this;
    }

    /**
     * Adiciona condições WHERE. Ex: ['type' => 0, 'status' => 'active']
     */
    public function where(array $conditions): self
    {
        $this->whereConditions = array_merge($this->whereConditions, $conditions);
        return $this;
    }

    /**
     * Define o número de itens por página para paginação.
     */
    public function paginate(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Define o termo de busca.
     */
    public function search(string $term): self
    {
        $this->searchTerm = $term;
        return $this;
    }

    /**
     * Define mapeamento para busca customizada em colunas.
     * Ex: ['column_name' => 'method_in_model']
     */
    public function withCustomSearch(array $mapping): self
    {
        $this->customSearchMapping = $mapping;
        return $this;
    }

    /**
     * Define o nome da coluna de ativação/status.
     */
    public function usingActiveColumn(string $columnName): self
    {
        $this->activeColumn = $columnName;
        return $this;
    }

    /**
     * Inclui registros inativos na consulta.
     */
    public function includeInactive(bool $include = true): self
    {
        $this->includeInactive = $include;
        return $this;
    }

    /**
     * Executa a consulta e retorna os resultados.
     */
    public function get(): LengthAwarePaginator|Collection
    {
        if (!isset($this->model)) {
            throw new \LogicException("Model must be set using forModel() before calling get().");
        }

        $query = app($this->model)->query();

        // Aplicar filtro de ativo/inativo
        if ($this->includeInactive) {
            $query->where($this->activeColumn, '<=', 1);
        } else {
            $query->where($this->activeColumn, 1);
        }

        // Aplicar condições WHERE
        foreach ($this->whereConditions as $key => $value) {
            $query->where($key, $value);
        }

        // Aplicar JOINs
        foreach ($this->relationsToJoin as $relation) {
            if (count($relation) === 3) {
                [$table, $key, $foreignKey] = $relation;
                $query->leftJoin($table, $key, '=', $foreignKey);
            } else {
                // Lidar com formato incorreto ou adicionar suporte a outros tipos de join
                throw new \InvalidArgumentException("Invalid relation format for join. Expected [table, key, foreignKey].");
            }
        }

        // Aplicar seleção de colunas
        $query->select($this->columnsToSelect);

        // Aplicar ordenação
        foreach ($this->sortOrders as $key => $value) {
            $query->orderBy($key, $value);
        }

        // Aplicar busca
        if ($this->searchTerm && !empty($this->searchableColumns)) {
            $query->where(function (Builder $innerQuery) {
                foreach ($this->searchableColumns as $column) {
                    $column = trim($column); // Limpa espaços
                    if (isset($this->customSearchMapping[$column])) {
                        // Assume que o método filterFields existe e está no modelo
                        // ou em um trait que o modelo usa.
                        $searchResult = app($this->model)::filterFields([$this->customSearchMapping[$column] => $this->searchTerm]);

                        if ($searchResult && $searchResult['converted'] !== '%0%') {
                            $innerQuery->orWhere($column, $searchResult['f'], $searchResult['converted']);
                        } else {
                            // Fallback se customSearch falhar ou retornar %0%
                            $innerQuery->orWhere($column, 'LIKE', '%' . $this->searchTerm . '%');
                        }
                    } else {
                        $innerQuery->orWhere($column, 'LIKE', '%' . $this->searchTerm . '%');
                    }
                }
            });
        }

        return $this->perPage ? $query->paginate($this->perPage) : $query->get();
    }
}
