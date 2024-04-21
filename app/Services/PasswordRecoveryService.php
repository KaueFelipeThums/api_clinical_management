<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Repositories\PasswordRecoveryRepository;
use App\Repositories\UsersRepository;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;

class PasswordRecoveryService
{
    protected $usersRepository;
    protected $passwordRecoveryRepository;

    /**
     * Construtor
     * 
     * @param App\Repositories\UsersRepository
     * @param App\Repositories\PasswordRecoveryRepository
     */
    public function __construct(UsersRepository $usersRepository, PasswordRecoveryRepository $passwordRecoveryRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->passwordRecoveryRepository = $passwordRecoveryRepository;
    }

    /**
     * Solicitar recuperação de senha
     * 
     * @param array $data
     * @return void
     */
    public function requestCode(array $data): void
    {
        $user = $this->usersRepository->getUserByEmail($data['email']);

        if (empty($user['id'])) {
            throw new AppException('Usuário não encontrado!', 404);
        }

        $recoveryRequests = $this->passwordRecoveryRepository->getCountRequestsLastTwoHoursByUserId($user['id']);
        if ($recoveryRequests >= 10) {
            throw new AppException('Limite de solicitações atingido, tente novamente mais tarde!', 429);
        }

        $this->passwordRecoveryRepository->cancelAllRequestsByUserId($user['id']);

        $token = rand(100000, 999999);

        $this->passwordRecoveryRepository->create([
            'id_usuarios_us' => $user['id'],
            'email' => $user['email'],
            'token' => $token,
            'situacao' => 2,
            'data_hora_envio' => date('Y-m-d H:i:s'),
            'data_hora_validade' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
        ]);

        EmailService::sendEmail(
            $user['email'],
            'Código de Recuperação de Senha',
            "Seu código de recuperação de senha é: $token"
        );
    }

    /**
     * Recuperar senha
     * 
     * @param array
     * @return void
     */
    public function recovery(array $data): void
    {
        $recoveryRequest = $this->passwordRecoveryRepository->getRequestByTokenAndEmail($data['token'], $data['email']);

        if (empty($recoveryRequest['id']) || strtotime($recoveryRequest['data_hora_validade']) < strtotime(date('Y-m-d H:i:s'))) {
            throw new AppException('Token inválido ou expirado!', 422);
        }

        $user = $this->usersRepository->getUserByEmail($data['email']);

        if (empty($user['id'])) {
            throw new AppException('Usuário não encontrado!', 404);
        }

        $this->usersRepository->update([
            'id' => $user['id'],
            'senha' => Hash::make($data['senha'])
        ]);

        $this->passwordRecoveryRepository->update([
            'id' => $recoveryRequest['id'],
            'situacao' => 1,
            'data_hora_recuperacao' => date('Y-m-d H:i:s')
        ]);
    }
}
