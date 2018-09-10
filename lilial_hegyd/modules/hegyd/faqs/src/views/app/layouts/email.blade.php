<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <!-- Define Charset -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">

    <title>@yield('title', isset($subject) ? $subject : '')</title><!-- Responsive Styles and Valid Styles -->

    @include('hegyd-faqs::emails.includes.stylesheets')
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tr bgcolor="#e8e8e8"><td height="30"></td></tr>
    <tr bgcolor="#e8e8e8">
        <td width="100%" align="center" valign="top" bgcolor="#e8e8e8">

            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container">

                @if (array_key_exists('online_view_link', View::getSections()))
                    <tr align="right">
                        <td style="color: #888888; font-size: 11px; font-weight: normal; font-family: Tahoma, Arial, sans-serif; line-height: 15px;"  class="main-header">
                            <singleline>
                                Si ce mail ne s'affiche pas correctement, <a href="@yield('online_view_link')" style="color: #888888; text-decoration: underline;"><span style="color: #888888; text-decoration: underline;">cliquez ici</span></a>.
                            </singleline>
                        </td>
                    </tr>
                @endif

                <tr><td height="40"></td></tr>

                <tr class="logo">
                    <td>
                    </td>
                </tr>
                <tr><td height="20"></td></tr>

                <tr>
                    <td>
                        <div style="height: 8px;width: 100%;background: #555555;border-radius: 5px 5px 0 0;"></div>
                    </td>
                </tr>

            </table>

            <!----------   main content---------->
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="container" bgcolor="ffffff">



                <!--------- Header  ---------->
                <tr><td height="30"></td></tr>

                <tr>
                    <td>
                        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="container-middle">

                            <tr>
                                <td>
                                    <table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
                                        <tr>
                                            <td class="main-header" style="color: #555555; font-size: 24px; font-weight: normal; font-family: Tahoma, Arial, sans-serif;">
                                                <singleline>
                                                    @yield('welcome', isset($user) ? trans('hegyd-faqs::emails.global.welcome', ['fullname' => $user->fullname()]) : trans('hegyd-faqs::emails.global.welcome_short'))
                                                </singleline>
                                            </td>
                                        </tr>

                                        <tr><td height="25"></td></tr>
                                        <tr>
                                            <td>
                                                <img style="display: block;"
                                                    src="{{url(config('hegyd-faqs.directories.assets') . '/img/emails/sep.jpg')}}"
                                                    height="1" width="100%" alt="" class="" />
                                            </td>
                                        </tr>

                                        <tr><td height="35"></td></tr>

                                        <tr>
                                            <td class="main-header" style="color: #888888; font-size: 12px; line-height: 17px; font-weight: bold; font-family: Tahoma, Arial, sans-serif;">
                                                <singleline>
                                                    @yield('subject', isset($subject) ? $subject : '')
                                                </singleline>
                                            </td>
                                        </tr>

                                        <tr><td height="15"></td></tr>

                                        <tr>
                                            <td class="main-header" style="color: #888888; font-size: 15px; line-height: 26px; font-weight: normal; font-family: Tahoma, Arial, sans-serif;">
                                                <multiline>
                                                    @yield('message')
                                                </multiline>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="main-header" style="color: #888888; font-size: 15px; line-height: 26px; font-weight: normal; font-family: Tahoma, Arial, sans-serif;">
                                                <multiline>
                                                    @yield('message2')
                                                </multiline>
                                            </td>
                                        </tr>

                                        <tr><td height="15"></td></tr>

                                        @if (array_key_exists('link', View::getSections()))
                                            <tr class="button">
                                                <td>
                                                    <a href="@yield('link')" title="" style="display: block; width: 228px; border-style: none !important; border: 0 !important;">
                                                        <img style="display: block;"
                                                            src="{{url(config('hegyd-faqs.directories.assets') . '/img/emails/btn-interface.png' )}}"
                                                            width="228" height="42" alt="Accéder à mon interface" />
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="color: #888888; font-size: 15px; line-height: 15px; font-weight: normal; font-family: Tahoma, Arial, sans-serif;">
                                                <multiline>
                                                    @lang('hegyd-faqs::emails.global.footer', ['site_domain' => url('/'), 'site_name' => config('app.name')])
                                                </multiline>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr><!--------- end main section -------->


                <tr><td height="25"></td></tr>
            </table>


            <!---------- footer  -------->
            <table border="0" width="600" cellpadding="0" cellspacing="0" class="container">
                <tr>
                    <td style="line-height: 10px;">
                        <img style="display: block;"
                            src="{{url(config('hegyd-faqs.directories.assets') . '/img/emails/bottom-footer-bg.png')}}"
                            alt="" class="header-bg" />
                    </td>
                </tr>
                <tr><td height="25"></td></tr>
                <tr>
                    <td style="color: #888888; font-size: 11px; font-weight: normal; font-family: Tahoma, Arial, sans-serif; line-height: 17px;">
                        <singleline>
                            Ceci est un message automatique, veuillez ne pas y répondre directement.
                        </singleline>
                    </td>
                </tr>
            </table>
            <!---------  end footer -------->
        </td>
    </tr>

    <tr><td height="30"></td></tr>

</table>


</body>
</html>