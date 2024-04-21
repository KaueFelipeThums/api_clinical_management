<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Users;

class UsersRepository extends BaseRepository
{
	/**
	 * Construtor
	 * 
	 * @param App\Models\Users $users
	 */
	public function __construct(Users $users)
	{
		parent::__construct($users);
	}

	/**
	 * Carregar osuário pelo e-mail
	 * 
	 * @param string $email
	 * @return array|null
	 */
	public function getUserByEmail(string $email): ?array
	{
		$response = $this->model::where('email', $email)->first();
		return !empty($response) ? $response->toArray() : null;
	}

	/**
	 * Carregar usuário pelo token de confirmação
	 * 
	 * @param string
	 * @return array|null
	 */
	public function getUserByConfirmationToken(string $activation_token): ?array
	{
		$response = $this->model::where('token_ativacao', $activation_token)->where('situacao_conta', 0)->first();
		return !empty($response) ? $response->toArray() : null;
	}
}
