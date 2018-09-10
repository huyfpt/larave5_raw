<?php namespace Hegyd\eCommerce\Mails;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

abstract class AbstractMail extends Mailable
{

    use Queueable, SerializesModels;

    protected $default_configuration;
    protected $configuration = [
        'prefixes' => [
            'route' => '',
            'lang'  => '',
            'view'  => '',
        ],
    ];
    protected $site_name;
    protected $site_domain;

    public function __constuct()
    {
        $this->createConfiguration();

        $this->site_domain = config('app.domain');
        $this->site_name = config('app.name');

        $this->with([
            'site_name'   => $this->site_name,
            'site_domain' => $this->site_domain,
        ]);

    }

    abstract public function build();

    abstract public function configure();

    /**
     * Set the subject of the message.
     *
     * @param  string $subject
     * @return $this
     */
    public function subject($subject)
    {
        $subject = trans('hegyd-ecommerce::emails.global.prefix_subject') . $subject;

        return parent::subject($subject);
    }


    /*###### CONFIGURATION ######*/


    protected function createConfiguration()
    {
        $this->configuration = $this->configure();
        if (empty($this->configuration))
        {
            throw new \Exception("Please fill the configure method.");
        }
        if ( ! empty($this->default_configuration))
        {
            $this->configuration = array_replace_recursive($this->default_configuration, $this->configuration);
        }
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
        if ( ! empty($this->configuration['prefixes'] && ! empty($this->configuration['prefixes'][$key])))
        {
            return $this->configuration['prefixes'][$key] . $suffix;
        }

        return '';
    }

    /**
     * Prepend the routePrefix config to $suffix .
     *
     * @param  string $name
     * @return string
     */
    protected function getRoute($suffix)
    {
        return $this->prefix('route', $suffix);
    }

    /**
     * Prepend the viewPrefix config to $suffix.
     *
     * @param  string $suffix
     * @return string
     */
    protected function getView($suffix = null)
    {
        return $this->prefix('view', $suffix);
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

}