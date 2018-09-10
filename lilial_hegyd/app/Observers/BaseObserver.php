<?php namespace App\Observers;

use App\Events\Logs\CRUD\ActiveEvent;
use App\Events\Logs\CRUD\CreateEvent;
use App\Events\Logs\CRUD\DeleteEvent;
use App\Events\Logs\CRUD\UpdateEvent;
use App\Facades\AppTools;
use Hegyd\Logs\Models\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class BaseObserver
{

    // Voir https://laravel.com/docs/5.1/eloquent#events
    // pour les différents évenements observable

    protected $entityNameKey = 'name';

    /**
     * Après la création d'une entité
     * @param $model
     */
    public function created($model)
    {
        if ( ! Auth::check())
            return;

        event(new CreateEvent($model, auth()->user(), $this->entityNameKey));

    }

    /**
     * Pendant la mise à jour d'une entité
     * @param $model
     */
    public function updating($model)
    {
        if ( ! Auth::check())
            return;

        // Récupérations du NOM des champs modifiés
        $keys = array_keys($model->getDirty());
        // Récupération des valeurs ORIGINALES des champs modifiés
        $before = array_get_values($model->getOriginal(), $keys);
        $after = $model->getDirty();

        $alias = AppTools::getAlias($model);

        $activeLog = isset($before['active']) && isset($after['active']) && $before['active'] != $after['active'];

        $user = Auth::user();
        if ($activeLog)
        {
            $active = true;
            if ($before['active'] == 1 && $after['active'] == 0)
                $active = false;

            event(new ActiveEvent($model, auth()->user(), $this->entityNameKey, $active));
        }

        if ($activeLog && count($after) > 1 || ! $activeLog)
        {
            event(new UpdateEvent($model, auth()->user(), $this->entityNameKey));
        }
    }

    /**
     * Après la suppression d'une entité
     * @param $model
     */
    public function deleted($model)
    {
        if ( ! Auth::check())
            return;

        event(new DeleteEvent($model, auth()->user(), $this->entityNameKey));
    }
}