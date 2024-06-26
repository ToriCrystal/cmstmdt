<?php

namespace App\Api\V1\Services\Auth;

use App\Api\V1\Repositories\Cart\CartRepositoryInterface;
use  App\Api\V1\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Enums\Gender;
use Illuminate\Support\Facades\URL;

class AuthService implements AuthServiceInterface
{
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    protected $instance;

    private CartRepositoryInterface $cartRepository;

    public function __construct(UserRepositoryInterface $repository, CartRepositoryInterface $cartRepository)
    {
        $this->repository = $repository;
        $this->cartRepository = $cartRepository;
    }

    public function store(Request $request)
    {

        $this->data = $request->validated();
        $this->data['username'] = $this->data['phone'];
        $this->data['gender'] = Gender::Male;
        $this->data['password'] = bcrypt($this->data['password']);
        $user = $this->repository->create($this->data);
        // Tạo cart khi đăng ký
        if ($user) {
            $cartData = ['user_id' => $user->id];
            $this->cartRepository->create($cartData);
        }
        return $user;
    }

    public function update(Request $request)
    {

        $this->data = $request->validated();

        if (isset($this->data['password']) && $this->data['password']) {
            $this->data['password'] = bcrypt($this->data['password']);
        } else {
            unset($this->data['password']);
        }

        return $this->repository->update($this->data['id'], $this->data);

    }

    public function delete($id)
    {
        return $this->repository->delete($id);

    }

    public function updateTokenPassword(Request $request)
    {
        $user = $this->repository->findByKey('email', $request->input('email'));
        $this->data['token_get_password'] = (string)str()->uuid() . '-' . time();
        $this->instance['user'] = $this->repository->updateObject($user, $this->data);
        return $this;
    }

    public function generateRouteGetPassword($routeName)
    {
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName, now()->addMinutes(30), [
                'token' => $this->data['token_get_password'],
                'code' => $this->instance['user']->code
            ]
        );
        return $this;
    }

    public function getInstance()
    {
        return $this->instance;
    }
}
