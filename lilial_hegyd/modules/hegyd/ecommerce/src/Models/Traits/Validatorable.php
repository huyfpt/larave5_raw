<?php namespace Hegyd\eCommerce\Models\Traits;

/**
 * Trait for offering to Models the capability of beeing validate by Controllers.
 */
trait Validatorable
{


    /**
     * Extra fields not in fillable to be added to nice names (translation).
     *
     * @var array
     */
    protected $addToNiceNames = [];

    /**
     * Relations to be added to nice names (translation).
     *
     * @var array
     */
    protected $addRelationsToNiceName = [];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data, $primaryKey = 'id')
    {
        if (isset($data[$primaryKey]))
        {
            $this->{$primaryKey} = $data[$primaryKey];
        }
        $validator = \Validator::make($data, $this->rules());
        $validator->setAttributeNames($this->niceNames());

        return $validator;
    }

    /**
     * Translate attributes names.
     *
     * @return array
     */
    protected function niceNames()
    {
        $niceNames = [];
        if (isset($this->fillable))
        {
            foreach ($this->fillable as $attribute)
            {
                $niceNames[$attribute] = $this->niceName($attribute);
            }
        }

        if (isset($this->addToNiceNames))
        {
            foreach ($this->addToNiceNames as $key => $attribute)
            {
                $niceNames[$key] = $this->niceName($attribute);
            }
        }

        if (isset($this->addRelationsToNiceName))
        {
            foreach ($this->addRelationsToNiceName as $key => $field)
            {
                $niceNames[$key] = trans($field);
            }
        }

        return $niceNames;
    }

    /**
     *
     * @param string $attribute
     * @return string the name translated using the associated translation file
     */
    protected function niceName($attribute)
    {
        $translationFile = $this->getName(true);

        return trans('hegyd-ecommerce::' . $translationFile . '.fields.' . $attribute);
    }


    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        return [];
    }

}
