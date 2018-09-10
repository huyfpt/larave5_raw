<?php


return [

    /*
   |--------------------------------------------------------------------------
   | Hegyd Logs Model
   |--------------------------------------------------------------------------
   |
   | This is the Log model used to create correct relations.  Update
   | the log if it is in a different namespace.
   |
   */
    'models'        => [
        'upload' => \Hegyd\Uploads\Models\Upload::class,
        'user'   => \App\Models\Common\User::class,
    ],
];