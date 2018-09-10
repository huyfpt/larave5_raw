<?php namespace App\Services\EAV;

use App\Repositories\Contracts\EAV\AttributeRepositoryInterface;

class AttributeService
{

    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(AttributeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByClassAndField($class, $field)
    {
        return app(AttributeRepositoryInterface::class)
            ->findByClassAndField($class, $field);
    }

    public function getValuesByClassAndField($class, $field)
    {

        // First retrieve attribute
        $attribute = app(AttributeRepositoryInterface::class)->findByClassAndField($class, $field);

        // Then format and return attribute values
        return $attribute->values()->orderBy('position')->pluck('value', 'id');

    }

    public function getAllGroupedByEntityKey()
    {

        $attributes = $this->repository->all();

        $groupedAttributes = [];

        foreach($attributes as $attribute){
            $groupedAttributes[$attribute->translate_key_entity][] = $attribute;
        }

        return $groupedAttributes;

    }

}