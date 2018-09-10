<?php namespace App\Notifications\Content;

use App\Notifications\AbstractNotification;
use Hegyd\News\Models\News;
use Illuminate\Notifications\Messages\MailMessage;

class NewsAvailable extends AbstractNotification
{

    public function __construct(News $model, $type = null)
    {
        parent::__construct($model, $type);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->getMessage(),
            'href'    => $this->getHref(),
        ];
    }

    public function getMessage()
    {
        return trans('notifications.messages.news.available', ['name' => $this->model->name]);
    }

    public function getHref()
    {
        return $this->model->url();
    }
}
