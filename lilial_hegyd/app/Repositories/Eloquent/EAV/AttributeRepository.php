<?php namespace App\Repositories\Eloquent\EAV;

use App\Models\EAV\Attribute;
use App\Repositories\Contracts\EAV\AttributeRepositoryInterface;
use App\Repositories\Eloquent\Repository;

class AttributeRepository extends Repository implements AttributeRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Attribute::class;
    }

    public function findByClassAndField($class, $field)
    {
        return Attribute::where('class_name', $class)
            ->where('field_name', $field)
            ->first();
    }

    public function findByClassName($className)
    {
        return Attribute::where('class_name', $class)
            ->get();
    }

}