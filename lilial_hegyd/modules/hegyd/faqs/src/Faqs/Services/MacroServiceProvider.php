<?php
namespace Hegyd\Faqs\Services;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Route;
use Html;
use Form;

/**
 * Class MacroServiceProvider
 * @package App\Providers
 */
class MacroServiceProvider extends ServiceProvider
{

    /**
     * Register any macros of application
     */
    public function boot()
    {

        /**
         * Html::macro
         */

        Html::macro('active', function ($path, $options = [])
        {
            return \Request::is($path) ? 'class="active ' . implode(' ', $options) . '"' : 'class="' . implode(' ', $options) . '"';
        });

        Html::macro('actives', function ($paths, $options = [])
        {
            foreach ($paths as $key => $path)
            {
                if (\Request::is($path))
                {
                    return 'class="active ' . implode(' ', $options) . '"';
                }
            }

            return 'class="' . implode(' ', $options) . '"';
        });

        /**
         * create the required attribute for form controls
         *  used by the JQuery Validation Plugin
         * @param string $fieldName
         * @return string
         */
        Html::macro('requiredAttributes', function ($fieldName = null)
        {
            if ( ! empty($fieldName))
            {
                return 'required data-msg-required="' . htmlentities(Lang::get('validation.required_field_msg',
                    ['field' => Lang::get($fieldName)])) . '"';
            }

            return 'required data-msg-required="' . htmlentities(Lang::get('this_field_is_required_msg')) . '"';
        });

        /**
         *
         * @param string $rule => fill the data-rule-{{$rule}}
         * @param string $message => fill the data-msg-{{$rule}}={{$message}}
         * @return string
         */
        Html::macro('validatorAttributes', function ($rule, $message)
        {
            return 'data-rule-' . $rule . '="true" data-msg-' . $rule . '="' . htmlentities(Lang::get($message)) . '"';
        });

        /**
         *
         * @param string $rule => fill the data-rule-{{$rule}}
         * @param string $value => fill thedata-rule-{{$rule}}={{$value}}
         * @return string
         */
        Html::macro('validatorAttributesValue', function ($rule, $value)
        {
            return 'data-rule-' . $rule . '="' . $value . '"';
        });


        /**
         * Form::macroo
         */

        Form::macro('hasError', function ($name, $errors, $ret = 'has-error')
        {
            return $errors->has($name) ? $ret : '';
        });

        Form::macro('errorMsg', function ($name, $errors)
        {
            $errs = $errors->get($name);
            $errs = array_map(function ($x)
            {
                return $x = '<li>' . $x . '</li>';
            }, $errs);

            return '<span class="help-block"><ul>' . implode('', $errs) . '</ul></span>';
        });
    }

    public function register()
    {
    }
}