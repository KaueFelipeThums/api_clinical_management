<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\RecoveryPasswordRecoveryRequest;
use App\Http\Requests\RequestCodePasswordRecoveryRequest;
use App\Services\PasswordRecoveryService;
use Illuminate\Http\JsonResponse;

class PasswordRecoveryController extends Controller
{

    protected $passwordRecoveryService;

    /**
     * Construtor
     * 
     * @param App\Services\PasswordRecoveryService
     */
    public function __construct(PasswordRecoveryService $passwordRecoveryService)
    {
        $this->passwordRecoveryService = $passwordRecoveryService;
    }

    /**
     * Solicitar recuperação de senha
     * 
     * @param App\Http\Requests\RequestCodePasswordRecoveryRequest
     * @return JsonResponse
     */
    public function requestCode(RequestCodePasswordRecoveryRequest $requestCodePasswordRecoveryRequest): JsonResponse
    {
        try {
            $response = $this->passwordRecoveryService->requestCode($requestCodePasswordRecoveryRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Código enviado para seu e-mail!'
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Recuperar senha
     * 
     * @param App\Http\Requests\RecoveryPasswordRecoveryRequest
     * @return JsonReponse
     */
    public function recovery(RecoveryPasswordRecoveryRequest $recoveryPasswordRecoveryRequest): JsonResponse
    {
        try {
            $response = $this->passwordRecoveryService->recovery($recoveryPasswordRecoveryRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => "Senha alterada com sucesso!"
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }
}
