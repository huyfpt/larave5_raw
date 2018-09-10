<?php namespace app\Observers\Common;

use App\Observers\BaseObserver;

class UserObserver extends BaseObserver
{

    protected $entityNameKey = ['firstname', 'lastname'];
}