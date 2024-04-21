<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\PasswordRecovery;

class PasswordRecoveryRepository extends BaseRepository
{
    /**
     * Construtor
     * 
     * @param App\Models\PasswordRecovery $passwordRecovery
     */
    public function __construct(PasswordRecovery $passwordRecovery)
    {
        parent::__construct($passwordRecovery);
    }

    /**
     * Cancelar todas as requisições usuário
     * 
     * @param int $user_id
     * @return void
     */
    public function cancelAllRequestsByUserId(int $user_id): void
    {
        $this->model::where('id_usuarios_us', $user_id)
            ->where('situacao', 2)
            ->update(['situacao' => 0]);
    }

    /**
     * Buscar solicitação de recuperação pelo token e e-mail
     * 
     * @param int $token
     * @param string $email
     * @return array|null
     */
    public function getRequestByTokenAndEmail(int $token, string $email): ?array
    {
        $recoveryRequest = $this->model::where('token', $token)
            ->where('email', $email)
            ->where('situacao', 2)
            ->first();
        return !empty($recoveryRequest) ? $recoveryRequest->toArray() : null;
    }

    /**
     * Buscar solicitações ultimas duas horas
     * 
     * @param int $user_id
     * @return array|null
     */
    public function getCountRequestsLastTwoHoursByUserId(int $user_id): int
    {
        $recoveryRequests = $this->model::where('id_usuarios_us', $user_id)
            ->whereBetween('data_hora_envio', [
                date('Y-m-d H:i:s', strtotime('-2 hours')),
                date('Y-m-d H:i:s'),
            ])
            ->count();

        return !empty($recoveryRequests) ? $recoveryRequests : 0;
    }
}
