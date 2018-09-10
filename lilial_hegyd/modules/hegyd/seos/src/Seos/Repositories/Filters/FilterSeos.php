<?php namespace Hegyd\Seos\Repositories\Filters;
class FilterSeos
{
    public function buildFilter($role, $more_datas)
    {
        return $more_datas;
    }
    public function getEntityChildrenQuery($role_id, $more_datas, $query)
    {
        if ($role_id != 0)
        {
            app(config('hegyd-seos.filters.seos'))->getAllSeos($role_id, $more_datas, $query);
        }
    }
    public function getAllSeosQuery($seos, $role_id, $more_datas)
    {
        if ($role_id != 0)
            app(config('hegyd-seos.filters.seos'))->getAllSeos($role_id, $more_datas, $seos);
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
    public function getAllSeos($role_id, $more_datas, $query)
    {
        $query->where(function ($query) use ($role_id, $more_datas)
        {
            // R
            if ($role_id != 0)
            {
                $query->orWhere(function ($q) use ($role_id)
                {
                    $q->whereHas('roles', function ($query) use ($role_id)
                    {
                        $query->where('role_id', '=', $role_id);
                    });
                    $q->doesntHave('roles', 'or');
                });
            }
        });
    }

    public function canShow($seos, $role_id, $more_datas)
    {
        return true;
    }
}