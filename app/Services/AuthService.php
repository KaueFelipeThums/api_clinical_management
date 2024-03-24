<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Repositories\UsersRepository;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use App\Services\EmailService;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $usersRepository;
    protected $authRepository;

    /**
     * Construtor
     * 
     * @param App\Repositories\UsersRepository
     * @param App\Repositories\AuthRepository
     */
    public function __construct(UsersRepository $usersRepository, AuthRepository $authRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->authRepository = $authRepository;
    }

    /**
     * Criar Usuário
     * 
     * @param array<string> $data
     * @return void
     */
    public function create(array $data): void
    {
        $user = $this->usersRepository->getUserByEmail($data['email']);
        if (!empty($user['id'])) {
            throw new AppException("O e-mail informado já está em uso!", 409);
        }

        $token_confirmation = bin2hex(random_bytes(16));

        $this->usersRepository->create([
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => Hash::make($data['senha']),
            'token_ativacao' => $token_confirmation,
            'situacao_conta' => 0,
            'roles' => json_encode(['standard']),
            'status' => 1
        ]);

        EmailService::sendEmail(
            $data['email'],
            "Código de Ativação",
            "Seu código de ativação é: $token_confirmation"
        );
    }

    /**
     * Realizar Login
     * 
     * @param array $data
     * @return array|null
     */
    public function login(array $data): ?array
    {
        $user = $this->usersRepository->getUserByEmail($data['email']);

        if (empty($user['id']) || !Hash::check($data['senha'], $user['senha'])) {
            throw new AppException('E-mail ou senha inválidos!', 422);
        }

        $access_token = $this->authRepository->startSession($user['id']);

        unset($user['senha']);
        unset($user['token_ativacao']);
        $user['roles'] = json_decode($user['roles']);

        return ['user' => $user, 'accessToken' => $access_token];
    }

    /**
     * Realizar logout
     * 
     * @return void
     */
    public function logout(): void
    {
        $auth_user_id = Auth::id();
        $this->authRepository->closeSession($auth_user_id);
    }

    /**
     * Reenviar token confirmação conta
     * 
     * @param array
     * @return void
     */
    public function resendAccountConfirmation(array $data): void
    {
        $user = $this->usersRepository->getUserByEmail($data['email']);

        if (empty($user['id'])) {
            throw new AppException('Usuário não encontrado!', 404);
        }

        $token_confirmation = bin2hex(random_bytes(16));

        $this->usersRepository->update([
            'id' => $user['id'],
            'token_ativacao' => $token_confirmation
        ]);

        EmailService::sendEmail(
            $user['email'],
            "Código de Ativação",
            "Seu código de ativação é: $token_confirmation"
        );
    }

    /**
     * Confirmar Conta
     * 
     * @param array $data
     * @return void
     */
    public function confirmAccount(array $data): void
    {
        $user = $this->usersRepository->getUserByConfirmationToken($data['token_ativacao']);

        if (empty($user['id'])) {
            throw new AppException('Token inválido ou e-mail já confirmado!', 422);
        }

        $this->usersRepository->update([
            'id' => $user['id'],
            'data_hora_ativacao' => date('Y-m-d H:i:s'),
            'situacao_conta' => 1
        ]);
    }
}
