<?php
$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
$plugins = array_keys((array)config('plugins'));
?>
        <!DOCTYPE html>
<html lang="{{ config('app.locale') }}"{!! (config('lang.direction')=='rtl') ? ' dir="rtl"' : '' !!}>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('common.meta-robots')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-title" content="{{ config('settings.app.app_name') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="{{ \Storage::url('app/default/ico/apple-touch-icon-144-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="{{ \Storage::url('app/default/ico/apple-touch-icon-114-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="{{ \Storage::url('app/default/ico/apple-touch-icon-72-precomposed.png') . getPictureVersion() }}">
    <link rel="apple-touch-icon-precomposed"
          href="{{ \Storage::url('app/default/ico/apple-touch-icon-57-precomposed.png') . getPictureVersion() }}">
    <link rel="shortcut icon" href="{{ \Storage::url(config('settings.app.favicon')) . getPictureVersion() }}">
    <title>{!! MetaTag::get('title') !!}</title>
    {!! MetaTag::tag('description') !!}{!! MetaTag::tag('keywords') !!}
    <link rel="canonical" href="{{ $fullUrl }}"/>
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if (strtolower($localeCode) != strtolower(config('app.locale')))
            <link rel="alternate" href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}"
                  hreflang="{{ strtolower($localeCode) }}"/>
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
                <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}"/>
            @endif
            {!! $og->renderTags() !!}
            {!! MetaTag::twitterCard() !!}
        @endif
    @else
        @if (config('services.facebook.client_id'))
            <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}"/>
        @endif
        {!! $og->renderTags() !!}
        {!! MetaTag::twitterCard() !!}
    @endif
    @include('feed::links')
    @if (config('settings.seo.google_site_verification'))
        <meta name="google-site-verification" content="{{ config('settings.seo.google_site_verification') }}"/>
    @endif
    @if (config('settings.seo.msvalidate'))
        <meta name="msvalidate.01" content="{{ config('settings.seo.msvalidate') }}"/>
    @endif
    @if (config('settings.seo.alexa_verify_id'))
        <meta name="alexaVerifyID" content="{{ config('settings.seo.alexa_verify_id') }}"/>
    @endif

    @yield('before_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="{{ url(mix('css/app.css')) }}" rel="stylesheet">

    @stack('css-stack')

    @include('layouts.inc.tools.style')
    <link href="{{ url('js/toastr/toastr.min.css') . getPictureVersion() }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/css/perfect-scrollbar.min.css" />
    <link href="{{ url('css/custom.css') . getPictureVersion() }}" rel="stylesheet">
    <link href="{{ url('css/resp.css') . getPictureVersion() }}" rel="stylesheet">
    @yield('after_styles')
@stack('css-stack')
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

	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script>
        paceOptions = {
            elements: true
        };

    </script>
    <script src="{{ url('assets/js/pace.min.js') }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.4.0/perfect-scrollbar.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/select2/js/i18n/'.config('app.locale').'.js'))
        <script src="{{ url('assets/plugins/select2/js/i18n/'.config('app.locale').'.js') }}"></script>

    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    <script src="/js/simpleUpload.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
        <script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}"
                type="text/javascript"></script>
    @endif


</head>
<body>

<div id="account-wrapper">

    @section('header')
        @include('layouts.inc.header-fluid')
    @show

    @section('search')
    @show

    @section('wizard')
    @show

    <div class="main-container-x account-wrapper">
        <div class="container-x">
            <div class="row-x" id="wrapper">
                <div class="page-sidebar left-side" id="sidebar-wrapper">
                    @include('account.inc.sidebar')
                </div>
                <div class="right-side" id="page-content-wrapper">
                    @if (Session::has('flash_notification'))
                        <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('flash::message')
                                </div>
                            </div>
                        </div>
                    @endif
                    @include('flash::message')

                    @if (isset($errors) and $errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>
                                <strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong>
                            </h5>
                            <ul class="list list-check">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @section('info')
    @show

</div>

@section('modal_location')
@show
@section('modal_abuse')
@show
@section('modal_message')
@show

@includeWhen(!auth()->check(), 'layouts.inc.modal.login')
@include('layouts.inc.modal.change-country')
@include('cookieConsent::index')

<script>
            {{-- Init. Root Vars --}}
    var siteUrl = '<?php echo url((!currentLocaleShouldBeHiddenInUrl() ? config('app.locale') : '') . '/'); ?>';
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
                errorLoading: function () {
                    return "{!! t('The results could not be loaded.') !!}"
                },
                inputTooLong: function (e) {
                    var t = e.input.length - e.maximum, n = {!! t('Please delete #t character') !!};
                    return t != 1 && (n += 's'), n
                },
                inputTooShort: function (e) {
                    var t = e.minimum - e.input.length, n = {!! t('Please enter #t or more characters') !!};
                    return n
                },
                loadingMore: function () {
                    return "{!! t('Loading more results…') !!}"
                },
                maximumSelected: function (e) {
                    var t = {!! t('You can only select #max item') !!};
                    return e.maximum != 1 && (t += 's'), t
                },
                noResults: function () {
                    return "{!! t('No results found') !!}"
                },
                searching: function () {
                    return "{!! t('Searching…') !!}"
                }
            }
        };
</script>

@yield('before_scripts')



<script src="{{ url('/js/toastr/toastr.min.js') }}"></script>
<script type="text/javascript">

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if($('.left-side').length){
           var ups = new PerfectScrollbar('.left-side');
        }
        {{-- Select Boxes --}}
        $('.selecter').select2({
            language: langLayout.select2,
            dropdownAutoWidth: 'true',
            minimumResultsForSearch: Infinity,
            width: '100%'
        });

        {{-- Searchable Select Boxes --}}
        $('.sselecter').select2({
            language: langLayout.select2,
            dropdownAutoWidth: 'true',
            width: '100%'
        });

        {{-- Social Share --}}
        $('.share').ShareLink({
            title: '{{ addslashes(MetaTag::get('title')) }}',
            text: '{!! addslashes(MetaTag::get('title')) !!}',
            url: '{!! $fullUrl !!}',
            width: 640,
            height: 480
        });

        {{-- Modal Login --}}
        @if (isset($errors) and $errors->any())
        @if ($errors->any() and old('quickLoginForm')=='1')
        $('#quickLogin').modal();
        @endif
        @endif

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    });
</script>

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
