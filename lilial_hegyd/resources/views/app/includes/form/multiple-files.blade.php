@php
    $preview = [];
    $previewConfig = [];

    if(!isset($field))
    {
        $field = 'documents';
    }

    if(!isset($label_class))
    {
        $label_class='col-md-2';
    }

    if(!isset($div_class))
    {
        $div_class='col-md-10';
    }

    foreach($model->{$field}()->orderBy('position')->get() as $key => $document)
    {
        if(strpos($document->mime_type, 'image') !== false){
            $preview[$key] = '<img style="height:160px" src="'.$document->media .'" />';
        }else{
            $preview[$key] = '<div class="file-preview-image"><span class="file-icon-4x"><i class="fas fa-file"></i></span></div>';
        }
        $config = new StdClass();
        $config->caption = $document->filename;
        $config->width = '120px';
        $config->url = route($delete_route, [$model->id, $document->id]);
        $config->key = $key;
        $config->document_id = $document->id;

        $previewConfig[$key] = $config;
    }


    $inputDatas = [
       'class' => 'file-loading multiple-file-input',
       'data-show-upload'=>'false',
       'multiple',
   ];

   if($model->exists)
   {
        $inputDatas['data-upload-url'] = route($upload_route, $model->id);
   }

   if(isset($update_route))
   {
      $inputDatas['data-update-url'] = route($update_route, $model->id);
   }

@endphp
<div class="form-group {!! Form::hasError($field, $errors) !!}">
    <label class="{{$label_class}} control-label" for="{{$field}}">@lang(isset($label) ? $label : 'app.documents')
        @if(!empty($required))
            <span class="required"> * </span>
        @endif
    </label>
    <div class="{{$div_class}}">
       {!! Form::file($field . '[]', $inputDatas) !!}

        <div name="initDocuments" class="hide" data-preview='{!! json_encode($preview) !!}' data-preview-config='{!! json_encode($previewConfig) !!}'></div>
    </div>
</div>

@push('stylesheets')
    {!! Html::style('/vendor/bower/bootstrap-fileinput/css/fileinput.min.css') !!}
@endpush
@push('scripts')

    {!! Html::script('/vendor/bower/bootstrap-fileinput/js/fileinput.min.js') !!}
    {!! Html::script('/vendor/bower/bootstrap-fileinput/js/plugins/sortable.min.js') !!}
    {!! Html::script('/vendor/bower/bootstrap-fileinput/js/locales/fr.js') !!}

    {!! Html::script('/app/js/multiple-file-input.js') !!}
@endpush