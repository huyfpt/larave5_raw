<?php namespace Hegyd\eCommerce\Repositories\Eloquent\eCommerce;


use App\Models\Common\User;
use Hegyd\eCommerce\Models\eCommerce\Order;
use Hegyd\eCommerce\Repositories\Contracts\eCommerce\OrderRepositoryInterface;
use Hegyd\eCommerce\Repositories\Eloquent\Repository;

class OrderRepository extends Repository implements OrderRepositoryInterface
{

    public function model()
    {
        return Order::class;
    }


    public function countOnGoing($site = null)
    {
        $query = Order::where('status', Order::STATUS_ON_GOING);
        if ($site)
        {
            $query->where('site_id', $site->id);
        }

        return $query->count();
    }

    public function countBeforeValidated($site = null)
    {
        $query = Order::where('status', '<', Order::STATUS_VALIDATED);
        if ($site)
        {
            $query->where('site_id', $site->id);
        }

        return $query->count();
    }

    /**
     * Check if the model can be deleted or not
     * @param $model
     * @param array $errors
     * @return boolean true if the deletion is possible else false (and the $errors whill be filled with the errors)
     */
    function checkDelete($model, array &$errors)
    {
        return true;
    }

    public function users()
    {
        $users = User::join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*')
            ->distinct()
            ->orderBy('lastname')
            ->get();

        return $users;
    }

    public function statusByUser($user)
    {
        return Order::select('status')
            ->distinct()
            ->where('user_id', $user->id)
            ->pluck('status');
    }
}