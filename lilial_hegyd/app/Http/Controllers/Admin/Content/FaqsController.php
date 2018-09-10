<?php
namespace App\Http\Controllers\Admin\Content;

use App\Events\Notifications\Content\FaqsAvailableEvent;
use App\Jobs\NotifyUsers;
use \Hegyd\Faqs\Controllers\Backend\FaqsController as Controller;
use Illuminate\Database\Eloquent\Model;

class FaqsController extends Controller
{
    protected function afterSave(Model $model, $data = [])
    {
        $model = parent::afterSave($model, $data);

        if (isset($data['notify_users']) && $data['notify_users'] && $model->isActive())
        {
            dispatch(new NotifyUsers(new FaqsAvailableEvent($model)));
        }

        return $model;
    }
}