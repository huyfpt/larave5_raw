<?php namespace App\Http\Middleware;


use App\Services\Common\ExtranetService;
use Closure;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);

        app(ExtranetService::class)->shareUserVars();

        return $next($request);
    }


}