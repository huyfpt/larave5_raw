<?php


namespace Hegyd\Plans\Services;


use Hegyd\Plans\Repositories\Contracts\PlansRepositoryInterface;
use Hegyd\Plans\Repositories\Eloquent\PlansRepository;
use Hegyd\Plans\Models\Plans;
use App\Models\Common\City;
use Illuminate\Http\Request;

class PlansService
{
    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(plansRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function getActiveForSlider($role)
    {
        $more_datas = app(config('hegyd-plans.filters.plans'))->buildFilter($role, $more_datas = array());

        return app(config('hegyd-plans.repository.plans'))->getActiveForSlider($role, $more_datas);
    }

    /**
     * On retourne tous les utilisateurs pouvant être auteur d'un article
     *
     * @return array
     */
    public function populateAuthor()
    {
        $referrers = [];

        $users = app(config('hegyd-plans.models.user'))::all();

        $users->each(function ($user) use (&$referrers) {
            $referrers[$user->id] = $user->fullname(true);
        });

        return $referrers;
    }

    public function metaRobots()
    {
        $array = [
            Plans::INDEX_FOLLOW => Plans::INDEX_FOLLOW,
            Plans::NOINDEX_FOLLOW => Plans::NOINDEX_FOLLOW,
            Plans::INDEX_NOFOLLOW => Plans::INDEX_NOFOLLOW,
            Plans::NOINDEX_NOFOLLOW => Plans::NOINDEX_NOFOLLOW,
        ];
        return $array;
    }

    public function populatePostCode()
    {
        $post_code = City::select('zip')->distinct('zip')->limit(20)->get();

        return $post_code;
    }

    public function listPostCode($keyword = '')
    {
        $query = City::select('zip')->distinct('zip');
        if (!empty($keyword)) {
            $post_code = $query->where('zip', 'LIKE', '%'.$keyword.'%')->limit(20)->get();
        }
        else
        {
            $post_code = $this->populatePostCode();
        }

        if(!empty($post_code))
        {
            $post_code = $post_code->map(function ($item) {
                return ['id' => $item['zip'], 'text' => $item['zip']];
            });
        }

        return $post_code;
    }
}