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
<div class="header">
    <nav class="navbar navbar-site navbar-default" role="navigation">
        <div class="container-fluid">
            @include('layouts.inc.header-items')
        </div>
    </nav>
</div>
