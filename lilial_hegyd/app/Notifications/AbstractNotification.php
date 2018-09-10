<?php namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

abstract class AbstractNotification extends Notification implements ShouldQueue
{

    use Queueable;

    const TYPE_CREATE = 1;
    const TYPE_UPDATE = 2;
    const TYPE_OTHER = 50;

    protected $via_providers = ['database'];
    protected $model;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Model $model, $type = null)
    {
        $this->model = $model;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->via_providers;
    }

    abstract public function getMessage();

    abstract public function getHref();
}
