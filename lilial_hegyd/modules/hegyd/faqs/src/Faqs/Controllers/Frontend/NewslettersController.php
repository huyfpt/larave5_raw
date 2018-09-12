<?php
namespace Hegyd\Faqs\Controllers\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hegyd\Faqs\Repositories\Contracts\NewsletterRepositoryInterface;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\JsonResponse;

class NewslettersController extends AbstractFrontendController
{

    public function __construct(Request $request, NewsletterRepositoryInterface $repository)
    {
        parent::__construct($request, $repository);
    }

    protected function configure()
    {
        return [
            'prefixes'         => [
                'route' => config('hegyd-faqs.routes.frontend.prefix.faqs'),
                'lang'  => 'hegyd-faqs::faqs.',
                'view'  => 'hegyd-faqs::frontend.faqs.',
                'acl'   => config('hegyd-faqs.permissions.prefix.frontend.faqs'),
            ],
        ];

    }

    public function store()
    {
        $datas = Input::all();
        $validator = $this->validation($datas);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 422);
        } else {
            $this->repository->save($datas);
            $message = trans('hegyd-faqs::newsletter.success_msg');
            return response()->json($message, Response::HTTP_OK);
        }
    }

    /**
     * Run ajax, Add new letter email
     * @return mixed
     */
    public function ajaxSave()
    {
        $datas = Input::all();
        $validator = $this->validation($datas);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]); 
        } else {
            $this->repository->save($datas);
            $message = trans('hegyd-faqs::newsletter.success_msg');
            return response()->json(['message' => $message, Response::HTTP_OK]);
        }
    }

    /**
     * Validation.
     * @param array $datas
     * @return Validator
     */
    protected function validation(array $datas)
    {
        $validator = $this->repository->validator($datas);

        return $validator;
    }
}