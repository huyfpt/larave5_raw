<?php
/**
 * ValidationServiceProvider class
 *
 * Handle Faq validation
 * @category   ValidationServiceProvider
 * @package    Hegyd\Faqs\Services
 * @author     Do Viet Hung <hungdv@dfm-engineering.com>
 * @copyright  2018 Hegyd
 * @license    www.hegyd.com
 * @version    1.0.0
 * @since      Class available since Release 1.0
 */
namespace Hegyd\Faqs\Services;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ValidationServiceProvider extends ServiceProvider
{


    public function boot()
    {
        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $end_at = $parameters[0];
            $data = $validator->getData();
            $end_date = $data[$end_at];
            $end_date = Carbon::createFromFormat('d/m/Y', $end_date);
            $start_date = Carbon::createFromFormat('d/m/Y', $value);

            if ($end_date->gt($start_date)) {
                return true;
            }
            return false;
        });

        Validator::extend('difference_value', function($attribute, $value, $parameters, $validator) {
            $data        = $validator->getData();
            $label       = strtolower($data['label']);
            $category_id = $data['parent_id'];
            if (!$category_id) {
                return true;
            }
            $category    = DB::table('faqs_categories')->where('id', $category_id)->first();
            $categoryName = strtolower($category->label);

            if ($categoryName === $label) {
                return false;
            }
            return true;
        });

    }

    public function register()
    {
    }
}