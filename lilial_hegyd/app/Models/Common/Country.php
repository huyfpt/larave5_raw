<?php

namespace App\Models\Common;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Common\Country
 *
 * @property integer $id
 * @property integer $iso_num
 * @property string $iso_alpha_2
 * @property string $iso_alpha_3
 * @property string $title_fr
 * @property string $title_en
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereIsoNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereIsoAlpha2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereIsoAlpha3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereTitleFr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereTitleEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends AbstractModel
{

    protected $table = 'countries';


}
