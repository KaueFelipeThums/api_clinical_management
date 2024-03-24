<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\ConfirmAccountAuthRequest;
use App\Http\Requests\CreateAuthRequest;
use App\Http\Requests\LoginAuthRequest;
use App\Http\Requests\ResendConfirmationAuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Construtor
     * 
     * @param App\Services\AuthService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Criar Usuário
     * 
     * @param App\Http\Requests\CreateAuthRequest
     * @return JsonResponse
     */
    public function create(CreateAuthRequest $createAuthRequest): JsonResponse
    {
        try {
            $reponse = $this->authService->create($createAuthRequest->validated());
            return response()->json(
                [
                    'success' => true,
                    'data' => $reponse,
                    'message' => 'Usuário criado com sucesso!'
                ]
            );
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Realizar Login
     * 
     * @param App\Http\Requests\LoginAuthRequest
     * @return JsonResponse
     */
    public function login(LoginAuthRequest $loginAuthRequest): JsonResponse
    {
        try {
            $response = $this->authService->login($loginAuthRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Login realizado com sucesso!'
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Realizar logout
     * 
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $reponse = $this->authService->logout();
            return response()->json([
                'success' => true,
                'data' => $reponse,
                'message' => 'Logout realizado com sucesso!'
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }


    /**
     * Reenviar token confirmação conta
     * 
     * @param App\Http\Requests\ResendConfirmationAuthRequest
     * @return JsonResponse
     */
    public function resendAccountConfirmation(ResendConfirmationAuthRequest $resendConfirmationAuthRequest): JsonResponse
    {
        try {
            $response = $this->authService->resendAccountConfirmation($resendConfirmationAuthRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Link de confirmação enviado para seu e-mail!'
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Confirmar Conta
     * 
     * @param App\Http\Requests\ConfirmAccountAuthRequest
     * @return JsonResponse
     */
    public function confirmAccount(ConfirmAccountAuthRequest $confirmAccountAuthRequest): JsonResponse
    {
        try {
            $response = $this->authService->confirmAccount($confirmAccountAuthRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Conta confirmada com sucesso!'
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }
}
