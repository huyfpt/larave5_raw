<?php namespace App\Services\EAV;

use App\Models\EAV\Attribute;
use App\Repositories\Contracts\EAV\AttributeValueRepositoryInterface;
use Illuminate\Support\Str;

class AttributeValueService
{

    // Containing our $repository to make all our database calls to
    protected $repository;

    public function __construct(AttributeValueRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /*
     * Generate a key for new attributes values
     * @param string $entityName
     * @param string $attributeName
     * @param string $valueName
     * @return string
     */
    public function generateValueKey($entityName, $attributeName, $valueName)
    {
        $tempKey = Str::slug($entityName, '_').".".
            Str::slug($attributeName, '_').".".
            Str::slug($valueName, '_');

        return strtolower($tempKey);
    }

    /**
     * @param $value
     */
    public function updateOthersAttributeValuesPosition($value)
    {
        $attribute = $value->attribute;
        foreach ($attribute->values()->orderBy('position')->get() as $otherValue){
            if (
                $value->id != $otherValue->id
                && $otherValue->position >= $value->position
            ){
                $otherValue->position++;
                $otherValue->save();
            }
        }
    }

    /**
     * @param Attribute $attribute
     * @param array $newOrder
     */
    public function updateAttributeValuesOrder(Attribute $attribute, array $newOrder)
    {

        $valuesById = $attribute->values()->get()->keyBy('id');

        foreach ($newOrder as $newPosition => $valueData){

            $valueId = $valueData['id'];

            if (isset($valuesById[$valueId])){
                $value = $valuesById[$valueId];
                $value->position = $newPosition;
                $value->save();
            }

        }

    }

}