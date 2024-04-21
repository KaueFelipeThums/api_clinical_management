<?php

namespace App\Repositories;

use App\Models\Organization;
use App\Repositories\BaseRepository;

class OrganizationRepository extends BaseRepository
{
  /**
   * Construtor
   * 
   * @param App\Models\Organization $organization
   */
  public function __construct(Organization $organization)
  {
    parent::__construct($organization);
  }

  /**
   * Buscar organização pelo ID (Usuário logado)
   *
   * @param integer $id
   * @param integer $auth_user_id
   * @return array|null
   */
  public function getByLoggedUser(int $id, int $auth_user_id): ?array
  {
    $response = $this->model::where('id', $id)->where('id_usuarios_us', $auth_user_id)->where('status', 1)->first();
    return !empty($response) ? $response->toArray() : null;
  }


  /**
   * Buscar organizações do usuário logado
   *
   * @param integer $auth_user_id
   * @return array|null
   */
  public function getAllByLoggedUser(int $auth_user_id): ?array
  {
    $response = $this->model::where('id_usuarios_us', $auth_user_id)->where('status', 1)->get();
    return !empty($response) ? $response->toArray() : null;
  }
}
