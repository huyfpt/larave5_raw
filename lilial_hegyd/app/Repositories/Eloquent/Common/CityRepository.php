<?php namespace App\Repositories\Eloquent\Common;

use App\Models\Common\City;
use App\Repositories\Contracts\Common\CityRepositoryInterface;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Str;

class CityRepository extends Repository implements CityRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return City::class;
    }

    /**
     * @param string $name : search key for restriction by name (like ...%)
     * @param integer $offset
     * @param integer $limit
     * @return Illuminate\Support\Collection of entities
     */
    public function findByName($name = null, $offset = 0, $limit = 0)
    {
        $query = City::query();

        if ($name != null)
        {
            $name_slug = Str::slug($name);

            $query = $query->where('name', 'like', "%$name%")
                ->orWhere('slug', 'like', "%$name%")
                ->orWhere('zip', 'like', "%$name%")
                ->where('name', 'like', "%$name_slug%")
                ->orWhere('slug', 'like', "%$name_slug%")
                ->orWhere('zip', 'like', "%$name_slug%");
        }
        if ($offset != 0)
        {
            $query = $query->offset($offset);
        }
        if ($limit != 0)
        {
            $query = $query->limit($limit);
        }

        $query->orderBy('name');

        return $query->get();
    }
}