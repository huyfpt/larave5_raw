<?php namespace App\Services\Common;

use App\Models\Common\Client;
use App\Repositories\Contracts\Common\ClientRepositoryInterface;
use App\Repositories\Contracts\Common\UserRepositoryInterface;

class ClientService
{

    // Containing our $repository to make all our database calls to
    protected $repository;
    protected $userRepository;

    public function __construct(ClientRepositoryInterface $repository, UserRepositoryInterface $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function types()
    {
        return [
            Client::TYPE_USER  => trans('clients.type.user'),
            Client::TYPE_PROFESSIONAL => trans('clients.type.professional'),
        ];
    }

    public function typeText($type)
    {
        $types = $this->types();
        if (isset($types[$type]))
        {
            return $types[$type];
        }

        return trans('app.unknown');
    }

}