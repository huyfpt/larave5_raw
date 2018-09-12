<?php

namespace Hegyd\Faqs\Services;


use Hegyd\Faqs\Repositories\Contracts\FaqsRepositoryInterface;
use Hegyd\Faqs\Repositories\Eloquent\FaqsRepository;
use Hegyd\Faqs\Models\Faqs;
class FaqsService
{
    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(FaqsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getActiveForSlider($role)
    {
        $more_datas = app(config('hegyd-faqs.filters.faqs'))->buildFilter($role, $more_datas = array());

        return app(config('hegyd-faqs.repository.faqs'))->getActiveForSlider($role, $more_datas);
    }

    /**
     * On retourne tous les utilisateurs pouvant être auteur d'un article
     *
     * @return array
     */
    public function populateAuthor()
    {
        $referrers = [];

        $users = app(config('hegyd-faqs.models.user'))::all();

        $users->each(function ($user) use (&$referrers) {
            $referrers[$user->id] = $user->fullname(true);
        });

        return $referrers;
    }

    /**
     * Get the meta robots
     * @return array
     */
    public function metaRobots()
    {
        $array = [
            Faqs::INDEX_FOLLOW     => Faqs::INDEX_FOLLOW,
            Faqs::NOINDEX_FOLLOW   => Faqs::NOINDEX_FOLLOW,
            Faqs::INDEX_NOFOLLOW   => Faqs::INDEX_NOFOLLOW,
            Faqs::NOINDEX_NOFOLLOW => Faqs::NOINDEX_NOFOLLOW,
        ];
        return $array;
    }
}