<?php namespace App\Http\Controllers\Traits;

use App\Repositories\Contracts\EAV\AttributeRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

trait Attributable
{

    public function saveAttributes(array $datas, Model $model = null)
    {

        // Check if current model have attributes defined
        $modelAttributes = app(AttributeRepositoryInterface::class)
            ->findAllBy('class_name', get_class($model));

        // Then loop on each model attributes
        foreach ($modelAttributes as $attribute){
            // And check if attribute field_name is available in datas array
            if ( isset($datas[$attribute->field_name]) ){

                $values = [];

                // If value is multiple ids, then make an array to sync all at the same time
                if ( is_array($datas[$attribute->field_name]) && count($datas[$attribute->field_name]) ) {
                    foreach ($datas[$attribute->field_name] as $value){
                        $values[$value] = ['field'=> $attribute->field_name];
                    }
                } else {
                    $values = [$datas[$attribute->field_name] => ['field'=> $attribute->field_name]];
                }
                /**
                 * Fix for snake case field name
                 * Example :
                 * Field: company_type
                 * Relation : companyType()
                 */
                $fieldName = camel_case($attribute->field_name);

                // Sync $values
                $model->{$fieldName}()->sync($values);

            }
        }

        return $model;

    }

}