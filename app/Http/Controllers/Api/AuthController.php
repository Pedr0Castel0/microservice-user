<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Traits\ResponseTrait;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ResponseTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->register($request->validated());

            return $this->successResponse(
                'Usuário cadastrado com sucesso',
                [
                    'user' => new UserResource($result['user']),
                    'token' => $result['token'],
                    'token_type' => 'Bearer',
                ],
                Response::HTTP_CREATED
            );
        } catch (ValidationException $e) {
            return $this->validationErrorResponse(
                'Erro de validação',
                $e->errors()
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro interno do servidor',
                $e->getMessage()
            );
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return $this->successResponse(
                'Login realizado com sucesso',
                [
                    'user' => new UserResource($result['user']),
                    'token' => $result['token'],
                    'token_type' => 'Bearer',
                ]
            );
        } catch (ValidationException $e) {
            return $this->validationErrorResponse(
                'Credenciais inválidas',
                $e->errors()
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro interno do servidor',
                $e->getMessage()
            );
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user()->currentAccessToken());

            return $this->successResponse('Logout realizado com sucesso');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao realizar logout',
                $e->getMessage()
            );
        }
    }

    public function user(Request $request): JsonResponse
    {
        try {
            return $this->successResponse(
                'Dados do usuário obtidos com sucesso',
                [
                    'user' => new UserResource($request->user()),
                ]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Erro ao obter dados do usuário',
                $e->getMessage()
            );
        }
    }
}
