<?php namespace App\Http\Controllers\Traits;

use App\Models\Content\Seos;
use Illuminate\Database\Eloquent\Model;

trait Seosable
{

    abstract function configureSeos();

    public function saveSeos(array $datas, Model $model = null)
    {
        $seosToSave = $this->configureSeos();

        foreach ($seosToSave as $relationKey => $config)
        {
            if (isset($datas[$relationKey]))
            {

                if ( ! isset($config['relation']))
                {
                    throw new \Exception('Declare relation entry in seos configuration');
                }

                $relation = $config['relation'];

                if ($relation == Seos::RELATION_UNIQUE)
                {
                    if ($model->{$relationKey})
                    {
                        $seos = $this->_buildSeosModel($datas[$relationKey], $model->{$relationKey});
                    } else
                    {
                        $seos = $this->_buildSeosModel($datas[$relationKey], new Seos());
                    }

                    $model->{$relationKey}()->save($seos);
                }
            }
        }


        return $model;
    }

    private function _buildSeosModel(array $datas, Seos $seos)
    {
        unset($datas['id']);

        $seos->fill($datas);

        return $seos;
    }
}