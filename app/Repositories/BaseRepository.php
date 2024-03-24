<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Criar Registro
     * 
     * @param array $data
     * @return array|null
     */
    public function create(array $data): ?array
    {
        $response =  $this->model::create($data);
        return !empty($response) ? $response->toArray() : null;
    }

    /**
     * Carregar Registro
     * 
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        $response = $this->model::find($id);
        return !empty($response) ? $response->toArray() : null;
    }

    /**
     * Listar Registros
     * 
     * @return array|null
     */
    public function getAll(): ?array
    {
        $response = $this->model::all();
        return !empty($response) ? $response->toArray() : null;
    }

    /**
     * Alterar Registro
     * 
     * @param array $data
     * @return array|null
     */
    public function update(array $data): ?array
    {
        $item = $this->model::find((int)$data['id']);
        if (!$item) {
            return null;
        }
        $item->fill($data);
        $item->save();

        return $item->toArray();
    }

    /**
     * Deletar Registro
     * 
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        $item = $this->model::find($id);
        if (!$item) {
            return null;
        }
        return $item->delete();
    }
}
