<?php

namespace App\Repositories\User;

use App\Constants\Caches;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * find data by email
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User
    {
        // Cache for 1 hour
        $key = Caches::USER_EMAIL . '_' . $email;
        return Cache::remember($key, Caches::ONE_HOUR_TTL, function () use ($email) {
            return $this->model->where('email', $email)->first();
        });
    }
}
