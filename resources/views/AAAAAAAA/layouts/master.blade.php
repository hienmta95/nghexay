<?php
    $fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
    $plugins = array_keys((array)config('plugins'));
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ config('app.locale') }}"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('common.meta-robots')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-title" content="{{ config('settings.app.app_name') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('storage/app/default/ico/apple-touch-icon-144-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('storage/app/default/ico/apple-touch-icon-114-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('storage/app/default/ico/apple-touch-icon-72-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('storage/app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion() }}">
    <link rel="shortcut icon" href="{{ asset('storage/'. config('settings.app.favicon')) . getPictureVersion() }}">
    <title>{!! MetaTag::get('title') !!}</title>
    {!! MetaTag::tag('description') !!}{!! MetaTag::tag('keywords') !!}
    <link rel="canonical" href="{{ $fullUrl }}"/>
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if (strtolower($localeCode) != strtolower(config('app.locale')))
            <link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" hreflang="{{ strtolower($localeCode) }}"/>
        @endif
    @endforeach
    @if (count($dnsPrefetch) > 0)
        @foreach($dnsPrefetch as $dns)
            <link rel="dns-prefetch" href="//{{ $dns }}">
        @endforeach
    @endif
    @if (isset($post))
        @if (isVerifiedPost($post))
            @if (config('services.facebook.client_id'))
                <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
            @endif
            {!! $og->renderTags() !!}
            {!! MetaTag::twitterCard() !!}
        @endif
    @else
        @if (config('services.facebook.client_id'))
            <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
        @endif
        {!! $og->renderTags() !!}
        {!! MetaTag::twitterCard() !!}
    @endif
    @include('feed::links')
    @if (config('settings.seo.google_site_verification'))
        <meta name="google-site-verification" content="{{ config('settings.seo.google_site_verification') }}" />
    @endif
    @if (config('settings.seo.msvalidate'))
        <meta name="msvalidate.01" content="{{ config('settings.seo.msvalidate') }}" />
    @endif
    @if (config('settings.seo.alexa_verify_id'))
        <meta name="alexaVerifyID" content="{{ config('settings.seo.alexa_verify_id') }}" />
    @endif


    <!--start theme style -->
    @yield('before_styles')
    @include('layouts.inc.tools.style')
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/animate.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/bootstrap.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/font-awesome.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/fonts.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/reset.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/owl.carousel.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/owl.theme.default.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/flaticon.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/style.css') . getPictureVersion() }}" />
{{--    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/style_II.css') . getPictureVersion() }}" />--}}
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/responsive.css') . getPictureVersion() }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('refactor-theme/css/select2/select2.css') . getPictureVersion() }}" />
    @yield('after_styles')

    @if (isset($plugins) and !empty($plugins))
		@foreach($plugins as $plugin)
			@yield($plugin . '_styles')
		@endforeach
	@endif

	@if (config('settings.style.custom_css'))
		{!! printCss(config('settings.style.custom_css')) . "\n" !!}
	@endif

	@if (config('settings.other.js_code'))
		{!! printJs(config('settings.other.js_code')) . "\n" !!}
	@endif
	@stack('css-stack')
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>

<body class="{{ config('app.skin') }}">
    <!-- preloader Start -->
    <div id="preloader">
        <div id="status"><img src="refactor-theme/images/header/loadinganimation.gif" id="preloader_image" alt="loader">
        </div>
    </div>
    <!-- Top Scroll End -->

    @section('header')
        @include('AAAAAAAA.layouts.inc.header')
    @show

    @section('search')
    @show

    @section('wizard')
    @show

    @yield('content')

    @section('info')
    @show

    @section('footer')
        @include('AAAAAAAA.layouts.inc.footer')
    @show


    <script>
        var siteUrl = '<?php echo url((!currentLocaleShouldBeHiddenInUrl() ? config('app.locale') : '' ) . '/'); ?>';
        var languageCode = '<?php echo config('app.locale'); ?>';
        var countryCode = '<?php echo config('country.code', 0); ?>';
        var timerNewMessagesChecking = <?php echo (int)config('settings.other.timer_new_messages_checking', 0); ?>;

                {{-- Init. Translation Vars --}}
        var langLayout = {
                'hideMaxListItems': {
                    'moreText': "{{ t('View More') }}",
                    'lessText': "{{ t('View Less') }}"
                },
                'select2': {
                    errorLoading: function(){
                        return "{!! t('The results could not be loaded.') !!}"
                    },
                    inputTooLong: function(e){
                        var t = e.input.length - e.maximum, n = {!! t('Please delete #t character') !!};
                        return t != 1 && (n += 's'),n
                    },
                    inputTooShort: function(e){
                        var t = e.minimum - e.input.length, n = {!! t('Please enter #t or more characters') !!};
                        return n
                    },
                    loadingMore: function(){
                        return "{!! t('Loading more results…') !!}"
                    },
                    maximumSelected: function(e){
                        var t = {!! t('You can only select #max item') !!};
                        return e.maximum != 1 && (t += 's'),t
                    },
                    noResults: function(){
                        return "{!! t('No results found') !!}"
                    },
                    searching: function(){
                        return "{!! t('Searching…') !!}"
                    }
                }
            };
    </script>

@yield('before_scripts')

<!--main js file start-->
<script src="{{ url('refactor-theme/js/jquery_min.js') }}"></script>
<script src="{{ url('refactor-theme/js/bootstrap.js') }}"></script>
<script src="{{ url('refactor-theme/js/jquery.menu-aim.js') }}"></script>
<script src="{{ url('refactor-theme/js/jquery.countTo.js') }}"></script>
<script src="{{ url('refactor-theme/js/jquery.inview.min.js') }}"></script>
<script src="{{ url('refactor-theme/js/owl.carousel.js') }}"></script>
<script src="{{ url('refactor-theme/js/modernizr.js') }}"></script>
<script src="{{ url('refactor-theme/js/custom.js') }}"></script>
<script src="{{ url('refactor-theme/js/custom_II.js') }}"></script>
<script src="{{ url('refactor-theme/js/jquery.matchHeight-min.js') }}"></script>
<script src="{{ url('refactor-theme/js/select2.min.js') }}"></script>
<!--main js file end-->

@yield('after_scripts')

@if (isset($plugins) and !empty($plugins))
    @foreach($plugins as $plugin)
        @yield($plugin . '_scripts')
    @endforeach
@endif
@stack('js-stack')
@if (config('settings.footer.tracking_code'))
    {!! printJs(config('settings.footer.tracking_code')) . "\n" !!}
@endif


</body>

</html>