<?php

namespace App\Repositories\Contracts\EAV;

use App\Models\Common\User;
use App\Models\EAV\Attribute;
use App\Models\EAV\AttributeValue;

interface AttributeValueRepositoryInterface
{

    /**
     * @param Attribute $attribute    Attribute
     * @param String    $field        Field name requested
     * @param User      $user         User requested
     * @return AttributeValue[]
     */
    public function getAttributeValuesAssociatedToUser($attribute, $user);

    /**
     * Retrieve one attribute value using a specific given fixed key
     * @param $key
     * @return mixed
     */
    public function getAttributeValueByKey($key);

}