<?php namespace App\Models\Common;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * @package App\Models\Common
 */
class City extends AbstractModel
{

    protected $table = 'cities';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
