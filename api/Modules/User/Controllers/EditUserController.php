<?php

namespace App\Modules\User\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Modules\User\Request\EditUserRequest;
use App\Modules\User\Services\UserService;

class EditUserController
{
    public function __construct(
        private Request $request,
        private Response $response,
        private UserService $userService,
        private EditUserRequest $editUserRequest
    ) {}

    public function handle(array $vars)
    {
        $userId = $vars['id'] ?? null;
        $data = $this->request->all();

        $this->editUserRequest->validate($data);
        $user = $this->userService->updateUser((int)$userId, $data);

        return $this->response->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
}
