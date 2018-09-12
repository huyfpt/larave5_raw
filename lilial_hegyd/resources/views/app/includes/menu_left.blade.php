
<!-- Left navbar-header -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">
        <div class="min-head">
        <div class="coverHead"></div>
            <div class="logo">
                <a href="/">
                    <img src="{!! $visualLogo !!}" alt="logo" class="" />
                </a>
            </div>
        </div>

        <ul class="nav" id="side-menu">

            <li>
                <a  href="{!! route('index') !!}"
                    {!! Html::active('', ['waves-effect']) !!}>
                    <i class="icon-speedometer" data-icon="v"></i>
                    <span class="hide-menu">
                        Tableau de bord
                    </span>
                </a>
            </li>

            <li>
                <a  href="{!! route('extranet.notifications.index') !!}"
                    {!! Html::active(route('extranet.notifications.index', [], false).'*', ['waves-effect']) !!}>
                    <i class="fas fa-bell" data-icon="v"></i>
                    <span class="hide-menu">
                        Notifications
                    </span>
                </a>
            </li>

            {{-- @if(Entrust::can('extranet.news.index'))
            <li>
                <a  href="{!! route('news_category.index') !!}"
                    {!! Html::active(route('news_category.index', [], false).'*', ['waves-effect']) !!}>
                    <i class="icon-feed" data-icon="v"></i>
                    <span class="hide-menu">
                        Actualités
                    </span>
                </a>
            </li>
            @endif --}}
            @if(Entrust::can([
                'admin.news.index',
                'admin.shops.index',
                'admin.settings.index',
                'admin.logs.index',
                'admin.permissions.index',
                'admin.users.index',
                'admin.clients.index',
                'admin.plans.index',
                'admin.faqs.index',
                'admin.products.index',
                'admin.pages.index',
                'admin.seos.index',
                'admin.seo_url_redirects.index',
            ]))
            <li>
                @php
                    $adminUrls = [
                        route('admin.eav.index', [], false).'*',
                        route('admin.shops.index', [], false).'*',
                        route('admin.settings.index', [], false).'*',
                        route('admin.logs.index', [], false).'*',
                        route('admin.permissions.index', [], false).'*',
                        route('admin.users.index', [], false).'*',
                        route('admin.clients.index', [], false).'*',
                        route('admin.plans.index', [], false).'*',
                        route('admin.pages.index', [], false).'*',
                        route('admin.seos.index', [], false).'*',
                        route('admin.seo_url_redirects.index', [], false).'*',
                        route('admin.news.index', [], false).'*',
                        route('admin.faqs.index', [], false).'*',
                        route('admin.categories.index', [], false).'*',
                        route('admin.products.index', [], false).'*',
                        route('admin.newsletters.index', [], false).'*',
                    ];
                @endphp
                <a href="#" {!! Html::actives($adminUrls, [], ['aria-expanded="true"']) !!}>
                    <i class="icon-equalizer" data-icon="v"></i>
                    <span class="hide-menu">
                    Administration <span class="fa arrow"></span>
                </span>
                </a>
                <ul {!! Html::actives($adminUrls, ['nav nav-second-level collapse'], ['aria-expanded="true"'], 'in') !!}>
                    @if(Entrust::can('admin.users.index'))
                    <li>
                        <a  href="{!! route('admin.users.index') !!}"
                            {!! Html::active(route('admin.users.index', [], false).'*') !!}>
                            Utilisateurs
                        </a>
                    </li>
                    @endif

                    @php
                        $faqUrls = [
                            route('admin.faqs.index', [], false).'*',
                        ];
                    @endphp
                    <li id="faq">
                        <a href="#" {!! Html::actives($faqUrls, [], ['aria-expanded="true"']) !!}>
                            <i data-icon="v"></i>
                            <span class="hide-menu">
                                FAQ <span class="fa arrow"></span>
                            </span>
                        </a>
                        <ul {!! Html::actives($faqUrls, ['nav nav-third-level collapse'], ['aria-expanded="true"']) !!}>
                            @if(Entrust::can('admin.faqs.index'))
                                <li class="link-faq">
                                    <a  href="{!! route('admin.faqs.index') !!}"
                                        {!! Html::active(route('admin.faqs.index', [], false).'*') !!}>
                                        FAQ
                                    </a>
                                </li>
                            @endif
                            @if(Entrust::can('admin.faqs_category.index'))
                                <li class="link-faq">
                                    <a  href="{!! route('admin.faqs_category.index') !!}"
                                        {!! Html::active(route('admin.faqs_category.index', [], false).'*') !!}>
                                        Catégorie
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    
                    @php
                        $clubUrls = [
                            route('admin.plans.index', [], false).'*',
                            route('admin.news.index', [], false).'*',
                        ];
                    @endphp
                    <li id="club">
                        <a href="#" {!! Html::actives($clubUrls, [], ['aria-expanded="true"']) !!}>
                            <i data-icon="v"></i>
                            <span class="hide-menu">
                                Club Lilial <span class="fa arrow"></span>
                            </span>
                        </a>
                        <ul {!! Html::actives($clubUrls, ['nav nav-third-level collapse'], ['aria-expanded="true"']) !!}>
                            
                            @if(Entrust::can('admin.plans.index'))
                            <li class="link-club">
                                <a  href="{!! route('admin.plans.index') !!}"
                                    {!! Html::active(route('admin.plans.index', [], false).'*') !!}>
                                    @lang('hegyd-plans::plans.title.index')
                                </a>
                            </li>
                            @endif
                            @if(Entrust::can('admin.plans_category.index'))
                            <li class="link-club">
                                <a  href="{!! route('admin.plans_category.index') !!}"
                                    {!! Html::active(route('admin.plans_category.index', [], false).'*') !!}>
                                    @lang('hegyd-plans::plans_categories.title.index')
                                </a>
                            </li>
                            @endif

                            @if(Entrust::can('admin.news.index'))
                            <li class="link-club">
                                <a  href="{!! route('admin.news.index') !!}"
                                    {!! Html::active(route('admin.news.index', [], false).'*') !!}>
                                    @lang('hegyd-news::news.title.index')
                                </a>
                            </li>
                            @endif
                            <li class="link-club">
                                <a  href="{!! route('admin.news_category.index') !!}"
                                    {!! Html::active(route('admin.news_category.index', [], false).'*') !!}>
                                    @lang('hegyd-news::news_categories.title.index')
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if(Entrust::can('admin.clients.index'))
                    <li>
                        <a  href="{!! route('admin.clients.index') !!}"
                            {!! Html::active(route('admin.clients.index', [], false).'*') !!}>
                            Gestion Clients
                        </a>
                    </li>
                    @endif

                    @php
                        $catalogueUrls = [
                            route('admin.categories.index', [], false).'*',
                            route('admin.products.index', [], false).'*',
                        ];
                    @endphp
                    <li id="catalogue">
                        <a href="#" {!! Html::actives($catalogueUrls, [], ['aria-expanded="true"']) !!}>
                            <i data-icon="v"></i>
                            <span class="hide-menu">
                                Catalogue De Vente <span class="fa arrow"></span>
                            </span>
                        </a>
                        <ul {!! Html::actives($adminUrls, ['nav nav-third-level collapse'], ['aria-expanded="true"']) !!}>
                            <li class="link-catalogue">
                                <a  href="{!! route('admin.products.index') !!}"
                                    {!! Html::active(route('admin.products.index', [], false).'*') !!}>
                                    Produits
                                </a>
                            </li>

                            <li class="link-catalogue">

                                <a  href="{!! route('admin.categories.index') !!}"
                                    {!! Html::active(route('admin.categories.index', [], false).'*') !!}>
                                    Catégorie
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(Entrust::can('admin.newsletters.index'))
                    <li>
                        <a  href="{!! route('admin.newsletters.index') !!}"
                            {!! Html::active(route('admin.newsletters.index', [], false).'*') !!}>
                            Gestion Newsleter
                        </a>
                    </li>
                    @endif

                    <li>
                        <a  href="{!! route('admin.seos.index') !!}"
                            {!! Html::active(route('admin.seos.index', [], false).'*') !!}>
                            Gestion SEO
                        </a>
                    </li>

                    <li>
                        <a  href="{!! route('admin.pages.index') !!}"
                            {!! Html::active(route('admin.pages.index', [], false).'*') !!}>
                            Gestion CMS
                        </a>
                    </li>

                    {{-- <li>
                        <a  href="{!! route('admin.seo_url_redirects.index') !!}"
                            {!! Html::active(route('admin.seo_url_redirects.index', [], false).'*') !!}>
                            Url Seo Redirection
                        </a>
                    </li> --}}
                    @if(Entrust::can('admin.settings.index'))
                            <li>
                            <a  href="{!! route('admin.settings.index') !!}"
                            {!! Html::active(route('admin.settings.index', [], false).'*') !!}>
                            Configuration
                                </a>
                                </li>
                        @endif
                    <!-- @if(Entrust::can('admin.eav.index'))
                    <li>
                        <a  href="{!! route('admin.eav.index') !!}"
                                {!! Html::active(route('admin.eav.index', [], false).'*') !!}>
                            @lang('eav.title.management')
                        </a>
                    </li>
                    @endif -->
                    @if(Entrust::can('admin.acl.index'))
                    <li>
                        <a  href="{!! route('admin.permissions.index') !!}"
                            {!! Html::active(route('admin.permissions.index', [], false).'*') !!}>
                            Permissions
                        </a>
                    </li>
                    @endif
                    @if(Entrust::can('admin.logs.index'))
                    <li>
                        <a  href="{!! route('admin.logs.index') !!}"
                            {!! Html::active(route('admin.logs.index', [], false).'*') !!}>
                            Logs
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
        @endif
        </ul>
    </div>
</div>
<!-- Left navbar-header end -->