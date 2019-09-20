<?php
// Search parameters
$queryString = (request()->getQueryString() ? ('?' . request()->getQueryString()) : '');

// Get the Default Language
$cacheExpiration = (isset($cacheExpiration)) ? $cacheExpiration : config('settings.other.cache_expiration', 60);
$defaultLang = Cache::remember('language.default', $cacheExpiration, function () {
    $defaultLang = \App\Models\Language::where('default', 1)->first();
    return $defaultLang;
});

// Check if the Multi-Countries selection is enabled
$multiCountriesIsEnabled = false;
$multiCountriesLabel = '';
if (config('settings.geo_location.country_flag_activation')) {
    if (!empty(config('country.code'))) {
        if (\App\Models\Country::where('active', 1)->count() > 1) {
            $multiCountriesIsEnabled = true;
            $multiCountriesLabel = 'title="' . t('Select a Country') . '"';
        }
    }
}

// Logo Label
$logoLabel = '';
if (getSegment(1) != trans('routes.countries')) {
    $logoLabel = config('settings.app.app_name') . ((!empty(config('country.name'))) ? ' ' . config('country.name') : '');
}
?>

<!-- Header Wrapper Start -->
<div class="jp_top_header_img_wrapper" style="background-image: url(refactor-theme/images/header/header_img3.jpg)">
    <div class="jp_slide_img_overlay"></div>

    @include('AAAAAAAA.layouts.inc.header-items')

    @if(\Request::route()->getName() == 'homepage')

        @include('AAAAAAAA.home.inc.search')

    @else

    @endif

</div>
<!-- Header Wrapper End -->
