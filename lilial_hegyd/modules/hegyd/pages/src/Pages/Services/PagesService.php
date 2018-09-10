<?php


namespace Hegyd\Pages\Services;


use Hegyd\Pages\Repositories\Contracts\PagesRepositoryInterface;
use Hegyd\Pages\Repositories\Eloquent\PagesRepository;

class PagesService
{
    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(pagesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getActiveForSlider($role)
    {
        $more_datas = app(config('hegyd-pages.filters.pages'))->buildFilter($role, $more_datas = array());

        return app(config('hegyd-pages.repository.pages'))->getActiveForSlider($role, $more_datas);
    }

    /**
     * On retourne tous les utilisateurs pouvant être auteur d'un article
     *
     * @return array
     */
    public function populateAuthor()
    {
        $referrers = [];

        $users = app(config('hegyd-pages.models.user'))::all();

        $users->each(function ($user) use (&$referrers) {
            $referrers[$user->id] = $user->fullname(true);
        });

        return $referrers;
    }
}