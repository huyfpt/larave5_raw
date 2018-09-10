<?php 

namespace Hegyd\Plans\Controllers\Traits;

use App\Models\Common\Address;
use App\Models\Content\Seo;
use Illuminate\Database\Eloquent\Model;

trait Addressable
{

    abstract function configureAddresses();

    public function saveAddresses(array $datas, Model $model = null)
    {
        $addressToSave = $this->configureAddresses();

        foreach ($addressToSave as $relationKey => $config)
        {
            if (isset($datas[$relationKey]))
            {

                if ($model->{$relationKey})
                {
                    $address = $this->_buildAddressModel($datas[$relationKey], $model->{$relationKey});
                } else
                {
                    $address = $this->_buildAddressModel($datas[$relationKey], new Address());
                }

                $model->{$relationKey}()->save($address);
            }
        }


        return $model;
    }

    private function _buildAddressModel(array $datas, Address $address)
    {

        $address->fill($datas);

        return $address;
    }
}