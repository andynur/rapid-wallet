<?php

namespace App\Services\User;

use App\Constants\RoleNames;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use LaravelEasyRepository\ServiceApi;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserServiceImplement extends ServiceApi implements UserService
{
    /**
     * @param string $title
     */
    protected $title = "user";

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * register service implementation
     * @param array $data
     * @return UserService
     */
    public function register(array $data): UserService
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $user = $this->mainRepository->create($data);
            $user->assignRole(RoleNames::USER);

            return $this->setCode(201)
                ->setMessage("Registration success")
                ->setData($user);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * login service implementation
     * @param array $credentials
     * @return UserService
     */
    public function login(array $credentials): UserService
    {
        try {
            $user = $this->mainRepository->findByEmail($credentials['email']);
            if (!$user) {
                throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
            }

            $hash_check = Hash::check($credentials['password'], $user->password);
            if (!$hash_check) {
                throw new UnauthorizedHttpException('Basic', 'Invalid credentials.');
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'name' => $user->name,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];

            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($data);
        } catch (\Exception $exception) {
            if ($exception instanceof UnauthorizedHttpException) {
                return $this->setCode(401)->setMessage($exception->getMessage());
            }

            return $this->exceptionResponse($exception);
        }
    }
}
