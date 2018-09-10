<?php namespace App\Repositories\Eloquent\EAV;

use App\Models\EAV\AttributeValue;
use App\Repositories\Contracts\EAV\AttributeValueRepositoryInterface;
use App\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

class AttributeValueRepository extends Repository implements AttributeValueRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return AttributeValue::class;
    }

    /**
     * Retrieve attributeValues linked to a requested user
     * @param Attribute $attribute    Attribute
     * @param String    $field        Field name requested
     * @param User      $user         User requested
     * @return AttributeValue[]
     */
    public function getAttributeValuesAssociatedToUser($attribute, $user)
    {

        $query = AttributeValue::select('attribute_values.*')
            ->join('attributes', 'attributes.id', '=', 'attribute_values.attribute_id')
            ->join('attribute_value_user', 'attribute_values.id', '=', 'attribute_value_user.attribute_value_id')
            ->where('attributes.class_name', $attribute->class_name)
            ->where('attributes.field_name', $attribute->field_name)
            ->where('attribute_value_user.user_id', $user->id)
        ;

        $values = $query->get();

        return $values;

    }


    /**
     * Retrieve only one attribute value (or null) using exact given key
     * @param $key
     * @return mixed
     */
    public function getAttributeValueByKey($key)
    {

        return AttributeValue::where('key' , '=', $key)->first();

    }

    /**
     * @param Attribute $attribute
     * @param array     $excludingKeys
     * @return mixed
     */
    public function getAttributeValueExcludingKey($attribute, $excludingKeys)
    {

        $attributeValues = $attribute->values()->whereNotIn('key' , $excludingKeys);
        return $attributeValues->get();

    }


}