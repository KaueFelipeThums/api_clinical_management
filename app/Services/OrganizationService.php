<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Repositories\OrganizationRepository;
use Illuminate\Support\Facades\Auth;

class OrganizationService
{

  protected $organizationRepository;

  /**
   * Construtor
   * 
   * @param App\Repositories\OrganizationRepository
   */
  public function __construct(OrganizationRepository $organizationRepository)
  {
    $this->organizationRepository = $organizationRepository;
  }

  /**
   * Criar uma nova organização (Usuário logado)
   * 
   * @param array<string> $data
   * @return array|null
   */
  public function create(array $data): ?array
  {
    $auth_user_id = Auth::id();
    $response = $this->organizationRepository->create([
      'id_usuarios_us' => $auth_user_id,
      'descricao' => $data['descricao'],
      'id_usuarios_us_lancamento' => $auth_user_id,
      'status' => 1
    ]);

    return $response;
  }

  /**
   * Buscar organização pelo ID (Usuário logado)
   * 
   * @param array<string> $data
   * @return array|null
   */
  public function getByLoggedUser(int $id): ?array
  {
    $auth_user_id = Auth::id();
    $response = $this->organizationRepository->getByLoggedUser($id, $auth_user_id);
    return $response;
  }

  /**
   * Alterar organização
   *
   * @param array $data
   * @return array|null
   */
  public function update(array $data): ?array
  {
    $auth_user_id = Auth::id();
    $organization = $this->organizationRepository->getByLoggedUser($data['id'], $auth_user_id);

    if (empty($organization['id'])) {
      throw new AppException('Registro não encontrado ou usuário sem permissão!', 422);
    }
    $data['id_usuarios_us_lancamento'] = $auth_user_id;

    $response = $this->organizationRepository->update($data);
    return $response;
  }

  /**
   * Buscar organizações do usuário logado
   *
   * @return array|null
   */
  public function getAllByLoggedUser(): ?array
  {
    $auth_user_id = Auth::id();
    $response = $this->organizationRepository->getAllByLoggedUser($auth_user_id);
    return $response;
  }

  /**
   * Deletar organização
   *
   * @param array $data
   * @return void
   */
  public function delete(array $data): void
  {
    $auth_user_id = Auth::id();
    $organization = $this->organizationRepository->getByLoggedUser($data['id'], $auth_user_id);

    if (empty($organization['id'])) {
      throw new AppException('Registro não encontrado ou usuário sem permissão!', 422);
    }

    $this->organizationRepository->update([
      'id' => $data['id'],
      'id_usuarios_us_lancamento' => $auth_user_id,
      'status' => 0
    ]);
  }
}
