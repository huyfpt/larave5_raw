<?php

/**
 * Retourne le dossier storage pour les applications sur lesquelles il y a l'intégration continue.
 * Sinon le dossier récupéré est xxx/releases/xxxxx -
 * Au bout de deux nouvelles versions ce dossier est supprimé, et les uploads ne sont plus disponible.
 */
if ( ! function_exists('app_storage_path'))
{
    function app_storage_path($path = '')
    {
        error_reporting(0);
        $storage_path = storage_path($path);

        try
        {
            if (chdir(base_path('../../shared/storage/')))
            {
                $storage_path = getcwd() . DIRECTORY_SEPARATOR . $path;
            }
        } catch (Exception $e)
        {
            if (env('APP_ENV') != 'local')
            {
                \Log::error('##############################################################');
                \Log::error(base_path('../../shared/storage/') . ' DOESN\'T EXISTS !');
                \Log::error('##############################################################');
            }
        }

        return $storage_path;
    }
}