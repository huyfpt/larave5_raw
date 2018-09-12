<?php

namespace App\Support;

use App\Models\Common\Company;
use App\Repositories\Contracts\Common\CompanyRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

/**
 * Class Tools
 * @package App\Support
 */
class AppTools
{

    /**
     * Count lenght for a given string
     *
     * @param string $str
     * @param string $encoding
     * @return int
     */
    public function strlen($str, $encoding = 'UTF-8')
    {
        if (is_array($str))
        {
            return false;
        }
        $str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
        if (function_exists('mb_strlen'))
        {
            return mb_strlen($str, $encoding);
        }

        return strlen($str);
    }

    /**
     * Delete unicode class from regular expression patterns
     *
     * @param string $pattern
     * @return string pattern
     */
    public function cleanNonUnicodeSupport($pattern)
    {
        if ( ! defined('PREG_BAD_UTF8_OFFSET'))
        {
            return $pattern;
        }

        return preg_replace('/\\\[px]\{[a-z]{1,2}\}|(\/[a-z]*)u([a-z]*)$/i', '$1$2', $pattern);
    }

    /**
     * Format and save images uploaded from summernote
     *
     * @param string $html
     * $param strin $path
     * @return string
     */
    protected function saveHtmlImages($html, $path)
    {
        $result = preg_replace_callback("/src=\"data:([^\"]+)\"/", function ($matches) use ($path)
        {
            list($postType, $encPost) = explode(';', $matches[1]);
            if (substr($encPost, 0, 6) != 'base64')
            {
                return $matches[0];
            }
            $imgBase64 = substr($encPost, 6);
            $imgExt = \ImageManager::getMimeTypeExtension($postType);
            if ( ! $imgExt)
            {
                return $matches[0];
            }
            $filename = $path . '/' . time() . '.' . $imgExt;
            $imgPath = public_path() . '/' . $filename;
            $imgDecoded = base64_decode($imgBase64);
            $fp = fopen($imgPath, 'w');
            if ( ! $fp)
            {
                return $matches[0];
            }
            fwrite($fp, $imgDecoded);
            fclose($fp);

            return 'src="/' . $filename . '"';
        }, $html);

        return $result;
    }

    /**
     * Get public storage path
     *
     * @param string $path
     * $param bool $absolute
     * @return string
     */
    public function storagePublicPath($path = '', $absolute = true)
    {
        if ($absolute)
        {
            return app_storage_path('app/public/' . $path);
        }

        return 'app/public/' . $path;
    }

    /**
     * Get private storage path
     *
     * @param string $path
     * $param bool $absolute
     * @return string
     */
    public function storagePrivatePath($path = '', $absolute = true)
    {
        if ($absolute)
        {
            return app_storage_path('app/private/' . $path);
        }

        return 'app/private/' . $path;
    }

    /**
     * Get the inverse of a given color
     *
     * @param string $color
     * @return string
     */
    public function inverseColor($color)
    {
        $color = str_replace('#', '', $color);
        if (strlen($color) != 6)
        {
            return '#757575';
        }
        $rgb = '';
        for ($x = 0; $x < 3; $x ++)
        {
            $c = 255 - hexdec(substr($color, (2 * $x), 2));
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0' . $c : $c;
        }

        return '#' . $rgb;
    }

    /**
     * Get current class fron current user role
     *
     * @return string
     */
    public function currentClass()
    {
        if ( ! \Auth::user())
        {
            return '';
        } elseif (\Auth::user()->hasRole('admin'))
        {
            return '1789-index';
        } elseif (\Auth::user()->hasRole('franchisor'))
        {
            return 'tete-reseau-index';
        } else
        {
            return 'franchise-index';
        }
    }

    /**
     * Redirect user after login
     *
     * @return void
     */
    public function userDashboard()
    {
        if (\Auth::user()->hasRole('admin'))
        {
            return redirect(Route('frontend.admin.index'));
        } elseif (\Auth::user()->hasRole('franchisor'))
        {
            return redirect(Route('frontend.franchisor.dashboard'));
        } else
        {
            return redirect(Route('frontend.franchisee.dashboard'));
        }
    }

    public function proposedUsername($first_name, $last_name)
    {
        $number = mt_rand(0, 999);
        if ($number < 10)
        {
            $number = '00' . $number;
        } elseif ($number < 100)
        {
            $number = '0' . $number;
        }

        return strtolower(substr($first_name, 0, 1)) . strtoupper(substr($last_name, 1, 1)) . $number;
    }

    // returns a two-dimensional array or rows and fields

    function parse_csv($csv_string, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true)
    {
        $enc = preg_replace_callback(
            '/"(.*?)"/s', function ($field)
        {
            return urlencode(utf8_encode($field[1]));
        }, preg_replace('/(?<!")""/', '!!Q!!', $csv_string)
        );
        $lines = preg_split($skip_empty_lines ? ($trim_fields ? '/( *\R)+/s' : '/\R+/s') : '/\R/s', $enc);

        return array_map(
            function ($line) use ($delimiter, $trim_fields)
            {
                $fields = $trim_fields ? array_map('trim', explode($delimiter, $line)) : explode($delimiter, $line);

                return array_map(
                    function ($field)
                    {
                        return str_replace('!!Q!!', '"', utf8_decode(urldecode($field)));
                    }, $fields
                );
            }, $lines
        );
    }

    function format_uri($string, $separator = '-')
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array('&' => 'and', "'" => '');
        $string = mb_strtolower(trim($string), 'UTF-8');
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);

        return $string;
    }

    /**
     * Convert price to french price format
     *
     * @param float $price
     * @param int $after
     * @return string
     */
    public function displayPrice($price, $after = 2)
    {
        return sprintf('%s €', number_format($price, $after, ',', ' '));
    }

    /**
     * Convert number to french percentage format
     *
     * @param float $number
     * @param int $after
     * @return string
     */
    public function displayPercentage($number, $after = 2)
    {
        $number = floatval(number_format($number, $after, '.', ' '));

        return sprintf('%s', str_replace('.', ',', $number)) . ' %';
    }

    /**
     * Get all current year months
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getMonths($startDate, $endDate)
    {
        $startTime = strtotime($startDate);
        $endTime = strtotime($endDate);

        $startYear = date('Y', $startTime);
        $endYear = date('Y', $endTime);

        $startMonth = date('m', $startTime);
        $endMonth = date('m', $endTime);

        $nbMonths = (($endYear - $startYear) * 12) + ($endMonth - $startMonth);

        $nb = $nbMonths <= 11 ? $nbMonths + (11 - $nbMonths) : $nbMonths;

        $months = [];
        for ($m = $nb; $m >= 0; $m --)
        {
            $date = date('Y-m', strtotime($endYear . '-' . $endMonth . ' -' . $m . ' month'));
            $month = date('F', mktime(0, 0, 0, date('m', strtotime($date)), 1, date('Y', strtotime($date))));
            $months[$date] = trans('app.' . $month);
        }

        return $months;
    }

    /**
     * Generate media thumbnail in cache
     *
     * @param type $src
     * @param type $width
     * @param type $height
     * @return string
     */
    public function thumbnail($src, $width = 300, $height = 200)
    {
        $srcFile = app_storage_path('app' . DIRECTORY_SEPARATOR . 'public' . str_replace(['/media', '/'], ['', DIRECTORY_SEPARATOR], $src));
        $path = app_storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'thumbnails');
        if ( ! file_exists($path))
        {
            mkdir($path, 0777);
        }
        $manager = new ImageManager(['driver' => 'gd']);
        $cacheThumb = md5($src . $width . $height) . '.' . explode('.', $src)[1];
        $cacheThumbFile = $path . DIRECTORY_SEPARATOR . $cacheThumb;
        $cacheThumbUrl = '/media/cache/thumbnails/' . $cacheThumb;
        if ( ! file_exists($cacheThumbFile))
        {
            $manager->make($srcFile)->resize($width, $height, function ($constraint)
            {
                $constraint->aspectRatio();
            })->save($cacheThumbFile);
        }

        return $cacheThumbUrl;
    }

    /**
     * Encode special characters under HTML format
     *
     * @param string $data
     * @return string
     */
    public function htmlEncode($data)
    {
        $SAFE_OUT_CHARS = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890._-";
        $result = "";
        for ($i = 0; $i < strlen($data); $i ++)
        {
            if (strchr($SAFE_OUT_CHARS, $data{$i}))
            {
                $result .= $data{$i};
            } else if (($var = bin2hex(substr($data, $i, 1))) <= "7F")
            {
                $result .= "&#x" . $var . ";";
            } else
            {
                $result .= $data{$i};
            }
        }

        return $result;
    }

    /**
     * transform a string in the CamelCase to under_scored_case
     * @param string $string
     * @return string
     */
    function camelCaseToUnderscoredCase($string)
    {
        return trim(strtolower(preg_replace('/[A-Z]/', '_$0', $string)), '_');
    }


    /**
     * Format date string
     *
     * @param string $date
     * @param string $format
     * @param string $fromFormat
     * @return string
     */
    public function formatDate($date, $format, $fromFormat = 'Y-m-j')
    {
        $formatedDate = Carbon::createFromFormat($fromFormat, $date);

        return $formatedDate ? $formatedDate->format($format) : $date;
    }

    /**
     * Get Date part from datetime
     *
     * @param string $date
     * @return string
     */
    public function timeToDate($date)
    {
        $res = explode(' ', $date);

        return isset($res[0]) ? $res[0] : $date;
    }

    public function getAlias($entity)
    {
        return last(preg_split('/\\\\/', strtolower(get_class($entity))));
    }

    public function extractSubDomain(){
        $http_host = parse_url(Request::server('HTTP_HOST'));
        $sub_domain = str_replace(env("APP_DOMAIN"), "", $http_host["path"]);
        return $sub_domain;
    }

    /**
     * Get the currentCompany according the current domain.
     * @return mixed
     */
    public function currentCompany()
    {
        $current_sub_domain = AppTools::extractSubDomain();

        $company = app(CompanyRepositoryInterface::class)->getModel()->where("subdomain", "=", $current_sub_domain)->first();

        if($company){
            return $company;
        }else{
            abort(404);
        }

    }

    public function ajaxUploadImageSummernote(\Illuminate\Http\Request $request)
    {
        $model = $request['model'];
        $file = $request->file('file');
        
        $destinationPath = app_storage_path().'/app/public/'.$model;
        $filename = $file->getClientOriginalName();

        $file->move($destinationPath, $filename);

        return response()->json(['name' => $filename]);
    }

}
