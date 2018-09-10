<?php

namespace App\Http\Controllers\Admin\Content;

use App\Events\Notifications\Content\PlansAvailableEvent;
use App\Jobs\NotifyUsers;
use \Hegyd\Plans\Controllers\Backend\PlansController as Controller;
use Illuminate\Database\Eloquent\Model;

class PlansController extends Controller
{

    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);

        if (isset($data['notify_users']) && $data['notify_users'] && $model->isActive())
        {
            dispatch(new NotifyUsers(new NewsAvailableEvent($model)));
        }

        return $model;
    }
}