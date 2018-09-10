<?php namespace App\Repositories\Eloquent\Common;

use App\Models\Common\Country;
use App\Repositories\Contracts\Common\CountryRepositoryInterface;
use App\Repositories\Eloquent\Repository;

class CountryRepository extends Repository implements CountryRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Country::class;
    }

    /**
     * @param string $name : search key for restriction by name (like ...%)
     * @param integer $offset
     * @param integer $limit
     * @return Illuminate\Support\Collection of entities
     */
    public function findByName($name = null, $offset = 0, $limit = 0)
    {
        $query = Country::query();

        if ($name != null)
        {
            $query = $query->where('title_fr', 'like', $name . '%')
                            ->orWhere('title_en', 'like', $name . '%');
        }
        if ($offset != 0)
        {
            $query = $query->offset($offset);
        }
        if ($limit != 0)
        {
            $query = $query->limit($limit);
        }

        $query->orderBy('title_fr');

        return $query->get();
    }
}