<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\CreateOrganizationRequest;
use App\Http\Requests\DeleteOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{

    protected $organizationService;

    /**
     * Construtor
     * 
     * @param App\Services\OrganizationService
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Criar uma nova organização (Usuário logado)
     * 
     * @param App\Http\Requests\CreateOrganizationRequest $createOrganizationRequest
     * @return JsonResponse
     */
    public function create(CreateOrganizationRequest $createOrganizationRequest): JsonResponse
    {
        try {
            $response = $this->organizationService->create($createOrganizationRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Organização criada com sucesso!'
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Buscar organização (ID)
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        try {
            $response = $this->organizationService->getByLoggedUser($id);
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => ''
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Alterar organização
     *
     * @param UpdateOrganizationRequest $updateOrganizationRequest
     * @return JsonResponse
     */
    public function update(UpdateOrganizationRequest $updateOrganizationRequest): JsonResponse
    {
        try {
            $response = $this->organizationService->update($updateOrganizationRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Organização alterada com sucesso!',
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Buscar organizações do usuário logado
     *
     * @return JsonResponse
     */
    public function getAllByLoggedUser(): JsonResponse
    {
        try {
            $response = $this->organizationService->getAllByLoggedUser();
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => ''
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    /**
     * Deletar organização
     *
     * @param DeleteOrganizationRequest $deleteOrganizationRequest
     * @return JsonResponse
     */
    public function delete(DeleteOrganizationRequest $deleteOrganizationRequest): JsonResponse
    {
        try {
            $response = $this->organizationService->delete($deleteOrganizationRequest->validated());
            return response()->json([
                'success' => true,
                'data' => $response,
                'message' => 'Organização alterada com sucesso!',
            ]);
        } catch (AppException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }
}
