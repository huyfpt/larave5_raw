<?php

namespace App\Models\EAV;


use App\Models\AbstractModel;

class Attribute extends AbstractModel
{

    protected $table = 'attributes';

    protected $fillable = [
        'name',
        'key',
        'translate_key_entity',
        'translate_key_attribute',
        'with_color',
        'with_roles',
        'with_users',
    ];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    /**
     * Prepare an associative array of select options (with id=>value) for current attribute
     * This will allow to fill the select form field options
     * @param bool $withNullFirstOption
     * @return array
     */
    public function getSelectableOptions($withNullFirstOption = false)
    {

        $selectableValues = [];

        // Prepare null option item to place in first position if required
        $nullOption = [];
        if($withNullFirstOption) {
            $nullOption = [ null => $this->transAttribute('null_option_label') ];
        }

        // Prepare real options
        $realOptions = $this->values()->orderBy('position')->pluck('value', 'id')->toArray();

        // Then merge both null option if not empty and real options
        return $nullOption + $realOptions;

    }

    /**
     * Prepare an associative array of select options (with id=>value) for value creation
     * When we create an new value we propose to select the initialPosition
     * This will allow to fill the select form field options
     * @param bool $withNullFirstOption
     * @return array
     */
    public function getInitialPositionsOptions()
    {

        // Prepare the first position (0)
        $avalaiblePositions = [0 => trans('eav.options.position.first')];

        // Prepare other values positions ('after ...')
        $values = $this->values()->orderBy('position')->pluck('value', 'position')->toArray();
        foreach ($values as $position => $value){
            // Increment current position to avoid overwriting the first position
            $avalaiblePositions[($position+1)] = trans('eav.options.position.after_value', ['value'=>$value]);
        }

        // Then merge both null option if not empty and real options
        return $avalaiblePositions;

    }

    /**
     * Evaluate if there is a selected value linked to the model attribute.
     * If not, then return null
     * @param $model
     * @return null
     */
    public function getSelectedIds($model)
    {

        $selectedValue = $model->{$this->field_name};

        if ($selectedValue)
            return $selectedValue->id;
        else
            return null;

    }

    public function transAttribute($key)
    {
        return trans($this->translate_key_attribute.'.'.$key);
    }

    public function transEntity($key)
    {
        return trans($this->translate_key_entity.'.'.$key);
    }

}