<?php

namespace App\Models\Common;

use App\Models\AbstractModel;

/**
 * App\Models\Common\Address
 *
 * @property integer $id
 * @property string $address
 * @property string $additional_1
 * @property string $additional_2
 * @property string $zip
 * @property string $city
 * @property integer $addressable_id
 * @property string $addressable_type
 * @property integer $country_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Common\Country $country
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereAdditional1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereAdditional2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereZip($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Common\Address whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Address extends AbstractModel
{

    protected $table = 'addresses';

    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'email',
        'phone',
        'company',
        'address',
        'additional_1',
        'additional_2',
        'zip',
        'city',
        'country_id',
        'addressable_id',
        'addressable_type',
        'latitude',
        'longitude',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }
}
