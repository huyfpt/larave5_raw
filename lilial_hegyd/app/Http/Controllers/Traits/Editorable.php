<?php

namespace App\Http\Controllers\Traits;

/**
 * A trait to automatically handle uploaded files
 */
trait Editorable
{

    protected abstract function configureEditors();

    /**
     * Convert base 64 images to jpg file.
     * @param array $datas
     * @return array
     */
    public function convertBase64(array $datas)
    {
        $editors = $this->configureEditors();
        if (!$editors) {
            return $datas;
        }
        foreach ($editors as $editor) {
            $datas[$editor] = $this->convertBase64Editor($datas[$editor]);
        }
        return $datas;
    }

    /**
     * Convert base 64 images to files in a specific editor
     * @param string $editor
     * @return string
     */
    public function convertBase64Editor($editor)
    {
        $result = preg_replace_callback("/src=\"data:([^\"]+)\"/",
            function ($matches) {
            list($postType, $encPost) = explode(';', $matches[1]);
            if (substr($encPost, 0, 6) != 'base64') {
                return $matches[0];
            }
            $imgBase64 = substr($encPost, 6);
            $imgExt    = \ImageManager::getMimeTypeExtension($postType);
            if (!$imgExt) {
                return $matches[0];
            }
            do {
                $filename = uniqid().'.'.$imgExt;
                $filePath = $this->repository->storagePath().$filename;
            } while (file_exists($filePath));

            $medianame  = $this->repository->mediaPath().$filename;
            $imgDecoded = base64_decode($imgBase64);
            $fp         = fopen($filePath, 'w');
            if (!$fp) {
                return $matches[0];
            }
            fwrite($fp, $imgDecoded);
            fclose($fp);
            return 'src="'.$medianame.'"';
        }, $editor);
        return $result;
    }
}