<?php namespace App\Http\Controllers\Common\Common;

use App\Events\Logs\EDM\DownloadFileEvent;
use App\Services\Common\ExtranetService;
use Hegyd\EDM\Repositories\Contracts\FolderRepositoryInterface;
use \Hegyd\Uploads\Controllers\MediaController as Controller;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{

    public function show($upload_id, $filename)
    {
        $file = parent::show($upload_id, $filename);

        event(new DownloadFileEvent($this->upload, auth()->user()));

        return $file;
    }

    public function download($upload_id, $filename)
    {
        $file = parent::download($upload_id, $filename);

        event(new DownloadFileEvent($this->upload, auth()->user()));

        return $file;
    }


    protected function _handleAccess($upload, $user)
    {
        parent::_handleAccess($upload, $user);

        if ($upload->folder_id)
        {
            $extranet_service = app(ExtranetService::class);
            $shop = $extranet_service->getShop();
            $role = $extranet_service->getRole();

            if ( ! in_array($role->name, ['super_admin', 'admin']) && $upload->folder_id)
            {
                $excluded_folders = app(FolderRepositoryInterface::class)->getNotAuthorizedFolders($role->id, $shop->id);

                if (in_array($upload->folder_id, $excluded_folders))
                {
                    abort(401);
                }
            }
        }

    }
}