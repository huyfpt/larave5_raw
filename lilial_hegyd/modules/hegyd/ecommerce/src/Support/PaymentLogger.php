<?php namespace Hegyd\eCommerce\Support;


use Carbon\Carbon;
use Illuminate\Log\Writer;
use Monolog\Logger;

class PaymentLogger extends Writer
{

    protected $path;

    public function __construct($filename)
    {
        parent::__construct(new Logger('log'));

        $this->path = $this->getCurrentPath($filename);
        $this->useFiles($this->path);
    }

    protected function getCurrentPath($filename)
    {
        $date = Carbon::now();
        $base_path = storage_path('logs/payments/');
        $path = $base_path . $date->format('Y/m/d/');

        if ( ! file_exists($path))
        {
            mkdir($path, 0777, true);
        }
        $path .= $filename;
        if ( ! file_exists($path))
        {
            touch($path);
        }

        return $path;
    }
}