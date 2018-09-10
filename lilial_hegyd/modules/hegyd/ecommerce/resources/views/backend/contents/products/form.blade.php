@extends(config('hegyd-ecommerce.main_layout.backend'))

@section('title')
    {!! $title !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                {!! Form::model($model, ['route' => $route, 'method' => $method, 'class' => 'form-horizontal', 'files' => true, 'id'=> 'product_form']) !!}
                <div class="ibox-title">
                    <h3>{!! $title !!}</h3>
                    <div class="ibox-tools">
                        @include('hegyd-ecommerce::backend.includes.form.actions')

                {{-- [
                    'more_actions' => [
                        [
                            'text'        => trans('hegyd-ecommerce::products.buttons.show_page'),
                            'href'        => route(config('hegyd-ecommerce.routes.frontend.product.show'), $model->id),
                            'target'      =>'_blank',
                            'class'       => 'btn-default',
                            'only_exists' => true
                        ]
                    ]
                ] --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <ul class="nav nav-tabs" id="formTabProduct">
                            <li class="active"><a href="#tabReference" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_reference')
                            </a></li>
                            <li><a href="#tabImages" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_images')
                            </a></li>
                            <li><a href="#tabCategory" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_category')
                            </a></li>
                            {{-- <li><a href="#tabAttribute" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_attribute') --}}
                            </a></li>
                            <li><a href="#tabRelated" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_product_related')
                            </a></li>
                            <li><a href="#tabFaq" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_faq')
                            </a></li>
                            <li><a href="#tabSeo" data-toggle="tab">
                                @lang('hegyd-ecommerce::products.labels.tab_seo')
                            </a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tabReference">
                                @include('hegyd-ecommerce::backend.contents.products.includes.tab_reference')

                            </div>
                            <div class="tab-pane fade" id="tabImages">
                                @include('hegyd-ecommerce::backend.includes.form.image', ['required' => false])
                                @include('hegyd-ecommerce::backend.includes.form.multiple-files', [
                                'field'         => 'visuals',
                                'label'         => 'hegyd-ecommerce::products.fields.visuals',
                                'upload_route'  => config('hegyd-ecommerce.routes.backend.product.uploads.store'),
                                'update_route'  => config('hegyd-ecommerce.routes.backend.product.uploads.update'),
                                'delete_route'  => config('hegyd-ecommerce.routes.backend.product.uploads.delete'),
                                ])
                            </div>
                            <div class="tab-pane fade" id="tabCategory">
                                @include('hegyd-ecommerce::backend.contents.products.includes.tab_category')
                            </div>
                            <div class="tab-pane fade" id="tabAttribute">
                                @include('hegyd-ecommerce::backend.contents.products.includes.tab_attribute')
                            </div>
                            <div class="tab-pane fade" id="tabRelated">
                                @include('hegyd-ecommerce::backend.contents.products.includes.tab_related')
                            </div>
                            <div class="tab-pane fade" id="tabFaq">
                                @include('hegyd-ecommerce::backend.contents.products.includes.tab_faq')
                            </div>
                            <div class="tab-pane fade" id="tabSeo">
                                @include('hegyd-ecommerce::backend.contents.products.includes.tab_seo')
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('hegyd-ecommerce::backend.includes.form.footer')
                {!! Form::close() !!}

                {{-- [
                    'more_actions' => [
                        [
                            'text'        => trans('hegyd-ecommerce::products.buttons.show_page'),
                            'href'        => route(config('hegyd-ecommerce.routes.frontend.product.show'), $model->id),
                            'target'      =>'_blank',
                            'class'       => 'btn-default',
                            'only_exists' => true
                        ]
                    ]
                ] --}}
            </div>
        </div>
    </div>

    @include('hegyd-ecommerce::backend.contents.products.includes.category-modal', [
        'category' => new \Hegyd\eCommerce\Models\ProductCatalog\Category()
    ])
@endsection
@push('stylesheets')
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/select2/dist/css/select2.min.css') !!}
{!! Html::style('/vendor/hegyd/ecommerce/dependencies/summernote/dist/summernote.css') !!}
{!! Html::style('/vendor/hegyd/ecommerce/css/form.css') !!}
@endpush
@push('scripts')
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/select2/dist/js/select2.full.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/select2/dist/js/i18n/fr.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/summernote/dist/summernote.min.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/summernote/dist/lang/summernote-fr-FR.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/dependencies/jquery-form/jquery.form.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/modal.js') !!}
{!! Html::script('/vendor/hegyd/ecommerce/js/products/form.js') !!}
@endpush