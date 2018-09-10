<?php namespace App\Repositories\Filters;

use App\Services\Common\ExtranetService;

class FilterNews extends \Hegyd\News\Repositories\Filters\FilterNews
{

    public function buildFilter($role, $more_datas)
    {
        if ( ! in_array($role->name, config('hegyd-news.administrators')))
        {
            $company = app(ExtranetService::class)->getCompany();

            if ($company)
            {
                $company_id = $company->id;
                $more_datas['company_id'] = $company_id;
            }
        }

        return parent::buildFilter($role, $more_datas);
    }

    public function getAllNewsQuery($news, $role_id, $more_datas)
    {
        if ($role_id || $more_datas['company_id'] != 0)
            app(config('hegyd-news.filters.news'))->getAllNews($role_id, $more_datas, $news);
    }
    /**
     *  Permet de récupérer les dossiers auxquels le role et le shop on le droit.
     * @param $role_id
     * @param $shop_id
     * @param $query
     */
    // folder1(admin/cachan)
    // folder2 (rien/rien)
    // folder3(rien/bagneux)
    // folder4(admin/rien)
    //  agence = A
    //  role = B
    //
    //  !A&!R || A=NULL&R || A&R=NULL || A&R
    public function getAllNews($role_id, $more_datas, $query)
    {
        $company_id = 0;

        if (isset($more_datas['company_id']))
            $company_id = $more_datas['company_id'];

        $query->where(function ($query) use ($role_id, $company_id) {
            // A=NULL&R
            if ($role_id != 0 && $company_id == 0)
            {
                $query->orWhere(function ($q) use ($role_id, $company_id) {
                    $q->whereHas('roles', function ($query) use ($role_id) {
                        $query->where('role_id', '=', $role_id);
                    });
                    $q->doesntHave('roles', 'or');

                });

            }

            // A&R=NULL
            if ($company_id != 0 && $role_id == 0)
            {
                $query->orWhere(function ($q) use ($role_id, $company_id) {

                    $q->whereHas('companies', function ($query) use ($company_id) {
                        $query->where('company_id', '=', $company_id);
                    });
                    $q->doesntHave('companies', 'or');
                });
            }

            // A&R
            if ($role_id != 0 && $company_id != 0)
            {

                $query->orWhere(function ($q) use ($role_id, $company_id) {
                    $q->where(function ($qu) use ($company_id) {

                        $qu->whereHas('companies', function ($query) use ($company_id) {
                            $query->where('company_id', '=', $company_id);
                        });
                        $qu->doesntHave('companies', 'or');
                    });

                    $q->where(function ($qu) use ($role_id) {
                        $qu->whereHas('roles', function ($query) use ($role_id) {
                            $query->where('role_id', '=', $role_id);
                        });
                        $qu->doesntHave('roles', 'or');
                    });
                });
            }

        });

    }

    public function canShow($news, $role_id, $more_datas)
    {
        $ids_company = $news->companies()->pluck('company_id')->toArray();

        $company_id = app(ExtranetService::class)->getCompany()->id;

        if ( ! in_array($company_id, $ids_company))
            return false;

        return true;
    }
}