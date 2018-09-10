<?php

namespace App\Models\EAV;


use App\Models\AbstractModel;
use App\Models\Common\User;
use Hegyd\Permissions\Models\Role;

class AttributeValue extends AbstractModel
{

    protected $table = 'attribute_values';

    protected $fillable = [
        'value',
        'key',
        'color',
        'position',
        'attribute_id',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributables()
    {
        return $this->morphedByMany($this->attribute->class_name, 'attributable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function canDelete()
    {

        if ( $this->removable && $this->attributables()->count() == 0 )
            return true;

        return false;

    }

}