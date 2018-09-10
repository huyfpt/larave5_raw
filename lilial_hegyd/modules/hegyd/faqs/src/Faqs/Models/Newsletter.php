<?php
namespace Hegyd\Faqs\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Newsletter extends AbstractModel
{
    protected $dates = [
        'created_at'
    ];

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'active',
        'created_at'
    ];

    protected $casts = [
      'created_at' => 'datetime:Y-m-d'
    ];

    /**
     * Validation rules
     *
     * @return array
     */
    protected function rules()
    {
        $except_id = $this->exists ? ',' . $this->id : '';
        $required_if_not_exists = $this->exists ? '' : '|required';

        $rules = [
            'first_name'    => 'required|max:50',
            'last_name'     => 'required|max:50',
            'email'           => 'email'
        ];

        return $rules;
    }

    /**
     * @return mixed
     */
    public function publishDate()
    {
        if ($this->created_at)
            return $this->created_at;

        return $this->created_at;
    }

    /**
     * Check if newsletter is available
     * @return bool
     */
    public function isActive()
    {
        $is_active = false;

        if ($this->active)
        {
            $is_active = true;
        }

        return $is_active;
    }

}