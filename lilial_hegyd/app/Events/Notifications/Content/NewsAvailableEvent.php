<?php namespace App\Events\Notifications\Content;


use App\Events\Notifications\NotificationEvent;
use App\Models\Common\User;
use App\Notifications\Content\NewsAvailable;
use App\Repositories\Contracts\Common\UserRepositoryInterface;
use Hegyd\News\Models\News;

class NewsAvailableEvent extends NotificationEvent
{

    protected $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function getUsers()
    {
        return app(UserRepositoryInterface::class)->findByPermission('extranet.news.index');
    }

    public function getNotificationModel()
    {
        return new NewsAvailable($this->news);
    }
}