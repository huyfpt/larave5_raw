<?php namespace App\Events\Logs\CRUD;

use App\Events\Logs\LogEvent;
use App\Models\Common\User;
use Illuminate\Database\Eloquent\Model;

class ActiveEvent extends LogEvent
{

    protected $active;

    public function __construct(Model $model, User $user = null, $entity_name_key = null, $active = true)
    {
        parent::__construct($model, $user, $entity_name_key);
        $this->active = $active;
    }

    public function getActiveKey()
    {
        $key = 'active';

        if ( ! $this->active)
        {
            $key = 'unactive';
        }

        return $key;
    }

    public function getEvent()
    {
        return $this->getModelAlias() . '.' . $this->getActiveKey();
    }

    public function getMessage()
    {
        $fullname = 'Utilisateur inconnu';
        $user = $this->getUser();

        if ($user)
        {
            $fullname = $user->fullname();
        }

        return trans('logs.messages.' . $this->getActiveKey() . '.' . $this->getModelAlias(), ['fullname' => $fullname, 'entity_name' => $this->getEntityName($this->getModel())]);
    }
}