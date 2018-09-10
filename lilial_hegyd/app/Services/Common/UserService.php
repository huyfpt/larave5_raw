<?php namespace App\Services\Common;

use App\Models\Common\User;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use App\Services\Mail\UserService as MailService;

class UserService
{

    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function civilities()
    {
        return [
            User::CIVILITY_MADAM  => trans('app.civility.madam'),
            User::CIVILITY_MISTER => trans('app.civility.mister'),
        ];
    }

    public function civilityText($civility)
    {
        $civilities = $this->civilities();
        if (isset($civilities[$civility]))
        {
            return $civilities[$civility];
        }

        return trans('app.unknown');
    }

    public function populateFullname()
    {
        return $this->repository->populateFullname();
    }

    public function forceResetPassword(User $user)
    {
        if ( ! $user->active)
        {
            return;
        }

        $password = $this->generatePassword();

        $this->repository->update(['password' => bcrypt($password)], $user->id);

        app(MailService::class)->sendForceResetPassword($user, $password);
    }

    public function generatePassword($length = 8)
    {
        return str_random($length);
    }
    
    public function convertPhone($phone)
    {
        if($phone)
        {
            return trim(substr_replace(chunk_split($phone, 2, ' '), '+33 ', 0, 1));
        }
    }
}