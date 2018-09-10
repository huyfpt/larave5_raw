<?php


namespace Hegyd\Seos\Services;


use Hegyd\Seos\Repositories\Contracts\SeosRepositoryInterface;
use Hegyd\Seos\Repositories\Eloquent\SeosRepository;

class SeosService
{
    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(seosRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getActiveForSlider($role)
    {
        $more_datas = app(config('hegyd-seos.filters.seos'))->buildFilter($role, $more_datas = array());

        return app(config('hegyd-seos.repository.seos'))->getActiveForSlider($role, $more_datas);
    }

    /**
     * On retourne tous les utilisateurs pouvant être auteur d'un article
     *
     * @return array
     */
    public function populateAuthor()
    {
        $referrers = [];

        $users = app(config('hegyd-seos.models.user'))::all();

        $users->each(function ($user) use (&$referrers) {
            $referrers[$user->id] = $user->fullname(true);
        });

        return $referrers;
    }
}