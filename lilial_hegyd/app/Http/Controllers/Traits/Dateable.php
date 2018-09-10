<?php namespace App\Http\Controllers\Traits;

use Carbon\Carbon;

/**
 * Change date format
 */
trait Dateable
{

    private static $EMPTY_DATE = '0000-00-00';
    private static $EMPTY_DATE_TIME = '0000-00-00 00:00:00';

    protected abstract function configureDates();

    /**
     * save dates with specific language format to Standard SQL Format
     * @param array $datas
     */
    protected function saveDates($datas)
    {
        $dates = $this->configureDates();

        if (empty($dates) || empty($datas))
        {
            return $datas;
        }

        $this->_saveDate($datas, $dates);

        return $datas;
    }

    private function _saveDate(&$datas, $dates)
    {
        foreach ($dates as $date => $config)
        {
            if ( ! isset($datas[$date]))
            {
                continue;
            }

            if (isset($config['sub']) && $config['sub'])
            {
                $this->_saveDate($datas[$date], $config);
                continue;
            }

            if ($datas[$date] == '' || $datas[$date] == self::$EMPTY_DATE)
            {
                $datas[$date] = null;
            } else
            {
                $from_format = $this->_getFormat($config, 'from_format');

                $datas[$date] = Carbon::createFromFormat($from_format, $datas[$date]);
            }
        }

    }

    /**
     * save date time with specific language format to Standard SQL Format
     * @param array $datas
     */
    protected function saveDateTimes($datas)
    {
        $dates = $this->configureDates();

        if (empty($dates) || empty($datas))
        {
            return $datas;
        }
        foreach ($dates as $date => $config)
        {
            if ( ! isset($datas[$date]))
            {
                continue;
            }
            if ($datas[$date] == '' || $datas[$date] == self::$EMPTY_DATE_TIME)
            {
                $datas[$date] = null;
            } else
            {
                $from_format = $this->_getFormat($config, 'from_format');

                $datas[$date] = Carbon::createFromFormat($from_format, $datas[$date]);
            }
        }

        return $datas;
    }

    /**
     * Format model's dates from declared dates for beeing displaing in locale language
     * @param object $model
     * @return object : the model transmated
     */
    protected function formatLocaleDates($model)
    {
//        $dates = $this->configureDates();
//        if (empty($dates) || is_null($model))
//        {
//            return $model;
//        }
//        foreach ($dates as $date => $config)
//
//        {
//            if (empty($model[$date]) || $model[$date] == self::$EMPTY_DATE)
//            {
//                $model[$date] = '';
//            } else
//            {
//                $from_format = $this->_getFormat($config, 'from_format');
//                $format = $this->_getFormat($config);
//
//                $model_date = $model[$date];
//                if ($model instanceof Carbon)
//                {
//                    $model[$date] = $model_date->format($format);
//                } else if (is_string($model_date))
//                {
//                    $model[$date] = Carbon::createFromFormat($from_format, $model_date)->format($format);
//                } else
//                {
//                    $model[$date] = '';
//                }
//            }
//        }

        return $model;
    }

    private function _getFormat($config, $format_key = 'format')
    {
        $format = trans('dates.php_date_format');
        if (isset($config[$format_key]))
        {
            $format = $config[$format_key];

        } else if (isset($config['format']))
        {
            $format = $config['format'];
        }

        return $format;
    }
}