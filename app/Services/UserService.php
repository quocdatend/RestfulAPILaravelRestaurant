<?php

namespace App\Services;

use App\Models\User;
/**
 * Class UserService.
 */
class UserService
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserService constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAllUsers()
    {
        return $this->user->all();
    }
    /**
     * Get user by ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserById($id)
    {
        return $this->user->find($id);
    }
    /**
     * find user by email.
     */
    public function findUserByEmail($email)
    {
        return $this->user->where('email', $email)->first();
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createUser(array $data)
    {
        return $this->user->create($data);
    }

}
