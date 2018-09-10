<?php namespace App\Events\Logs;


use App\Events\Event;
use App\Facades\AppTools;
use App\Models\Common\User;
use App\Services\Common\ExtranetService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

abstract class LogEvent extends Event
{

    protected $model;
    protected $user;
    protected $entity_name_key = 'name';

    public function __construct(Model $model = null, User $user = null, $entity_name_key = null)
    {
        $this->model = $model;

        if ( ! $user)
        {
            $user = auth()->user();
        }

        $this->user = $user;

        if ($entity_name_key)
        {
            $this->entity_name_key = $entity_name_key;
        }
    }

    abstract public function getEvent();

    abstract public function getMessage();

    public function getData()
    {
        return ['ip' => Request::getClientIp(),
                'company_id' => session(ExtranetService::CURRENT_COMPANY_KEY),
                'shop_id' => session(ExtranetService::CURRENT_SHOP_KEY),
                'role_id' => session(ExtranetService::CURRENT_ROLE_KEY)
        ];
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getModelAlias()
    {
        return AppTools::getAlias($this->model);
    }

    protected function getEntityName()
    {
        $model = $this->model;

        $entity_name = '';
        if (is_array($this->entity_name_key))
        {
            foreach ($this->entity_name_key as $field)
            {
                $entity_name .= $model->{$field} . ' ';
            }

        } else
        {
            $entity_name = $model->{$this->entity_name_key};
        }

        return $entity_name;
    }
}