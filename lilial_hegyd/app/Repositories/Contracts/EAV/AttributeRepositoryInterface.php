<?php

namespace App\Repositories\Contracts\EAV;

interface AttributeRepositoryInterface
{

    public function findByClassAndField($class, $field);

    public function findByClassName($className);

}