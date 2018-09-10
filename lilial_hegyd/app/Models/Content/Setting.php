<?php namespace App\Models\Content;

use App\Models\AbstractModel;
use Hegyd\Uploads\Models\Upload;

class Setting extends AbstractModel
{

    protected $table = 'settings';

    protected $fillable = [
        'name',
        'key',
        'value',
        'default',
        'description',
        'position',
        'type',
        'icon',
        'class',
        'class_icon',
        'category_id',
    ];

    const TYPE_TEXT = 10;
    const TYPE_TEXTAREA = 20;
    const TYPE_NUMBER = 30;
    const TYPE_EMAIL = 40;
    const TYPE_SELECT = 50;
    const TYPE_IMAGE = 60;
    const TYPE_FILE = 70;
    const TYPE_COLOR = 80;

    public function category()
    {
        return $this->belongsTo(SettingCategory::class);
    }

    public function file()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    public function media($field = 'file', $size_type = Upload::SIZE_NORMAL, $size = 0, $color = Upload::COLOR_NORMAL)
    {
        return parent::media($field, $size_type, $size, $color);
    }

    public function defaultMedia()
    {
        if ($this->default)
        {
            return env('APP_URL') . $this->default;
        }

        return parent::defaultMedia();
    }
}