<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Users;

class AuthRepository extends BaseRepository
{
	/**
	 * Construtor $users
	 * 
	 * @param App\Models\Users
	 */
	public function __construct(Users $users)
	{
		parent::__construct($users);
	}

	/**
	 * Iniciar sessão usuário
	 * 
	 * @param int $user_id
	 * @return string
	 */
	public function startSession(int $user_id): string
	{
		$user = $this->model::find($user_id);
		$user->tokens()->delete();
		$acess_token = $user->createToken('authToken');
		return $acess_token->plainTextToken;
	}

	/**
	 * Encerrar sessão usuário
	 * 
	 * @param int $user_id
	 * @return void
	 */
	public function closeSession(int $user_id): void
	{
		$user = $this->model::find($user_id);
		$user->tokens()->delete();
	}
}
