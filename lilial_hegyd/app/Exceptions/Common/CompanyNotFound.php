<?php namespace App\Exceptions\Common;


class CompanyNotFound extends \Exception
{

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = trans('exceptions.company');
        $code = 404;

        parent::__construct($message, $code, $previous);
    }
}