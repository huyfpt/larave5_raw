<?php namespace Hegyd\Seos\Controllers\Traits;

use Illuminate\Support\Arr;

trait Configurable
{

    /** @var array default configuration fields */
    protected $_defaultConfig = [];

    /** @var array the config array created by the implemention of the configure method by subclases * */
    protected $_config;

    /**
     * Create the specific configuration array for the view
     * @returns array
     */
    protected abstract function configure();

    /**
     * Create the default configuration for the abstract implementations
     * @returns array
     */
    protected function defaults()
    {
        return [];
    }

    /**
     * Check if the $name field exist in the $this->_config else throw an appropriate exception
     * @param string $name
     * @throws Exception
     * @return the config value if not empty
     */
    protected function getConfigNotEmpty($name)
    {
        if (empty($this->_config[$name]) && $this->_config[$name] !== false)
        {
            throw new \Exception('Please fill the \'' . $name . '\' field in the array returned by your configure() method');
        }

        return $this->_config[$name];
    }

    protected function createConfiguration()
    {
        $this->_config = $this->configure();
        if (empty($this->_config))
        {
            throw new \Exception("Please fill the configure method.");
        }
        $defaults = $this->defaults();
        if ( ! empty($defaults))
        {
            $this->_defaultConfig = $defaults;
            $this->_config = array_replace_recursive($this->_defaultConfig, $this->_config);
        }
    }

    /**
     * search in $this->_config the value corresponding to the key
     * @param string $key
     * @return string
     */
    protected function getConfig($key, $default = null)
    {
        return Arr::get($this->_config, $key, $default);
    }

    /**
     * Construct the string for getting resource by concatenate the prefix[key] to the suffix
     * If the suffix begin with /, this method will returns it directly
     * @param string $key the name of the prefix to use
     * @param string $suffix the suffix to add
     * @return string
     */
    protected function prefix($key, $suffix = null)
    {
        if (starts_with($suffix, "/"))
        {
            return substr($suffix, 1);
        }
        if ( ! empty($this->_config['prefixes'] && ! empty($this->_config['prefixes'][$key])))
        {
            return $this->_config['prefixes'][$key] . $suffix;
        }

        return '';
    }

    /**
     * Prepend the routePrefix config to $suffix and generate a URL to a named route.
     *
     * @param  string $name
     * @param  array $parameters
     * @param  bool $absolute
     * @return string
     */
    protected function route($suffix, $parameters = [], $absolute = true)
    {
        return route($this->prefix('route', $suffix), $parameters, $absolute);
    }

    /**
     * Prepend the routePrefix config to $suffix and generate the named route
     *
     * @param  string $suffix
     * @return string
     */
    protected function routeAlias($suffix)
    {
        return $this->prefix('route', $suffix);
    }

    /**
     * Prepend the viewPrefix config to $suffix and get the evaluated view contents for the given view.
     *
     * @param  string $suffix
     * @param  array $data
     * @param  array $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function view($suffix = null, $data = [], $mergeData = [])
    {
        return view($this->prefix('view', $suffix), $data, $mergeData);
    }

    /**
     * Prepend the langPrefix config to $suffix and translate the given message
     *
     * @param  string $suffix
     * @param  array $parameters
     * @param  string $domain
     * @param  string $locale
     * @return \Symfony\Component\Translation\TranslatorInterface|string
     */
    protected function trans($suffix, $parameters = [], $domain = 'messages', $locale = null)
    {
        return trans($this->prefix('lang', $suffix), $parameters, $domain, $locale);
    }

    /**
     * Check if auth user has permission
     *
     * @param mixed $suffix
     * @return bool
     */
    protected function acl($suffix)
    {
        $permissions = [];
        if (is_array($suffix))
        {
            foreach ($suffix as $s)
            {
                $permissions[] = $this->prefix('acl', $s);
            }
        } else
        {
            $permissions[] = $this->prefix('acl', $suffix);
        }

        return \Entrust::can($permissions);
        return true;
    }

    /**
     * the variables to inject in the form view (for edit and creation)
     * @return array
     */
    protected function viewVars()
    {
        return [];
    }

}
