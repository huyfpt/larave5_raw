<?php namespace Hegyd\Permissions\Models;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Hegyd\Permissions\Models\CategoryPermission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ACL\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ACL\CategoryPermission[] $children
 *
 * @mixin \Eloquent
 */
class CategoryPermission extends AbstractModel
{

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('hegyd-permissions.category_table');
        parent::__construct($attributes);
    }

    public function children()
    {
        return $this->hasMany(CategoryPermission::class, 'parent_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'category_id');
    }
}
