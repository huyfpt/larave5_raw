<?php namespace Hegyd\Permissions\Models;

use Zizaco\Entrust\EntrustPermission;

/**
 * Hegyd\Permissions\Models\Permission
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $category_id
 * @property-read \App\Models\ACL\CategoryPermission $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ACL\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ACL\Permission whereCategoryId($value)
 * @mixin \Eloquent
 */
class Permission extends EntrustPermission
{

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryPermission::class);
    }
}