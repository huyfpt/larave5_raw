<?php namespace Hegyd\eCommerce\Models;

use Hegyd\eCommerce\Models\Traits\Validatorable;
use Hegyd\Uploads\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Hegyd\Uploads\Services\UploadService;

class AbstractModel extends Model
{

    use Validatorable;


    /**
     * @param $attribute
     * @return bool
     */
    public function hasAttribute($attribute)
    {
        $attributes = $this->getAttributes();

        return isset($attributes[$attribute]);
    }

    /**
     * Get media path that points to /storage/app
     * @param type $file
     * @return type
     */
    public function storagePath($file = '', $visibility = Upload::VISIBILITY_PUBLIC)
    {
        $path = storage_path('app' . DIRECTORY_SEPARATOR);

        switch ($visibility)
        {
            case Upload::VISIBILITY_PUBLIC:
                $path .= 'public' . DIRECTORY_SEPARATOR;
                break;

            case Upload::VISIBILITY_PRIVATE:
                $path .= 'private' . DIRECTORY_SEPARATOR;
                break;
        }

        $path .= $this->getName() . DIRECTORY_SEPARATOR . $file;

        return $path;
    }

    /**
     * @param string $field
     * @param int $size_type
     * @param int $size
     * @param int $color
     * @return string
     */
    public function media($field = 'visual', $size_type = Upload::SIZE_NORMAL, $size = 0, $color = Upload::COLOR_NORMAL)
    {
        if ($this->{$field})
        {
            return app(UploadService::class)->generateSrc($this->{$field}, $size_type, $size, $color);
        }

        return $this->defaultMedia();
    }


    /**
     * Default media
     *
     * @return string
     */
    public function defaultMedia()
    {
        return null;
    }

    /**
     * Get model name to be used in files (translation ...).
     *
     * @return array
     */
    public function getName($plurial = false)
    {
        $classArr = explode('\\', get_class($this));

        $str = trim(strtolower(preg_replace('/[A-Z]/', '_$0', end($classArr))), '_');
        if ($plurial)
        {
            $str .= 's';
        }

        return $str;
    }


}