@extends('layouts.master')

<?php
// Phone
$phone = TextToImage::make($post->phone, IMAGETYPE_PNG, ['backgroundColor' => 'rgba(0,0,0,0.0)', 'color' => '#FFFFFF']);
$phoneLink = 'tel:' . $post->phone;
$phoneLinkAttr = '';
if (!auth()->check()) {
    if (config('settings.single.guests_can_apply_jobs') != '1') {
        $phone = t('Click to see');
        $phoneLink = '#quickLogin';
        $phoneLinkAttr = 'data-toggle="modal"';
    }
}

// Contact Recruiter URL
$applyJobURL = '#applyJob';
$applyLinkAttr = 'data-toggle="modal"';
if (!empty($post->application_url)) {
    $applyJobURL = $post->application_url;
    $applyLinkAttr = '';
}
if (!auth()->check()) {
    if (config('settings.single.guests_can_apply_jobs') != '1') {
        $applyJobURL = '#quickLogin';
        $applyLinkAttr = 'data-toggle="modal"';
    }
}
?>

@section('content')
    {!! csrf_field() !!}
    <input type="hidden" id="post_id" value="{{ $post->id }}">

 
    @include('common.alert')

    <div class="main-container">
        @include('post.inc.post-heading')
        <?php if (\App\Models\Advertising::where('slug', 'top')->count() > 0): ?>

        <?php
        $paddingTopExists = false;
        endif;
        ?>
        @include('common.spacer')

        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-thin-right">
                    <div class="inner inner-box ads-details-wrapper">
                        <div class="ads-details">
                            <div class="pd-20">
                                <div class="ads-details-info jobs-details-info enable-long-words mb-20">

                                    <h5 class="list-title">
                                        {{ t('Job Details') }}
                                    </h5>
                                    <!-- Description -->
                                    <div class="mb-20">
                                        {!! (transformDescription($post->description)) !!}
                                    </div>

                                    <h5 class="list-title">{{ t('Benefit') }}</h5>
                                    <!-- Description -->
                                    <div class="mb-20">
                                        {!! (transformDescription($post->benefit)) !!}
                                    </div>
                                    <h5 class="list-title">{{ t('Requirement') }}</h5>
                                    <!-- Description -->
                                    <div class="mb-20">
                                        {!! (transformDescription($post->requirement)) !!}
                                    </div>
                                    <h5 class="list-title">{{ t('Document') }}</h5>
                                    <!-- Description -->
                                    <div class="mb-20">
                                        {!! (transformDescription($post->document)) !!}
                                    </div>

                                <!-- Tags -->
                                    @if (!empty($post->tags))
                                        <?php $tags = explode(',', $post->tags); ?>
                                        @if (!empty($tags))
                                            <div style="clear: both;"></div>
                                            <div class="tags">
                                                <h5 class="list-title">{{ t('Tags') }}</h5>
                                                @foreach($tags as $iTag)
                                                    <?php $attr = ['countryCode' => config('country.icode'), 'tag' => $iTag]; ?>
                                                    <a href="{{ lurl(trans('routes.v-search-tag', $attr), $attr) }}">
                                                        {{ $iTag }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/.ads-details-wrapper-->
                    <?php /*<div class="inner inner-box pd-20 mt-20">
                        <h5 class="title">Thông tin liên hệ</h5>

                        <div class="mw-box-item box-contact"><!---->
                            <div class="row">
                                <div class="col-md-6 col-lg-3 label-contact"><strong>Người liên hệ:</strong></div>
                                <div class="col-md-6 col-lg-9 "><span>{!! $post->user->name !!}</span></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 label-contact"><strong>Địa chỉ công ty:</strong></div>
                                <div class="col-md-6 col-lg-9 "><span>{!! $post->company->address !!}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-3 label-contact"><strong>Hạn nộp hồ sơ:</strong></div>
                                <div class="col-md-6 col-lg-9 "><span
                                            class="">{!! \Carbon\Carbon::parse($post->deadline)->format('d/m/Y') !!}</span>&nbsp;
                                    <!----></div>
                            </div>
                            <div class="row  mt-20 mb-10">
                                <div class="col-md-6 col-lg-3 label-contact">
                                    &nbsp;
                                </div>
                                <div class="col-md-6 col-lg-9 ">
                                    @if (auth()->check())
                                        @if (auth()->user()->id == $post->user_id)
                                            <a class="btn btn-success" href="{{ lurl('posts/'.$post->id.'/edit') }}">
                                                <i class="fa fa-pencil-square-o"></i> {{ t('Edit') }}
                                            </a>
                                        @else
                                            @if ($post->email != '' and in_array(auth()->user()->user_type_id, [2]))
                                                <a class="btn btn-success"
                                                   {!! $applyLinkAttr !!} href="{{ $applyJobURL }}">
                                                    <i class="icon-mail-2"></i> {{ t('Apply Online') }}
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        @if ($post->email != '')
                                            <a class="btn btn-default" {!! $applyLinkAttr !!} href="{{ $applyJobURL }}">
                                                <i class="icon-mail-2"></i> {{ t('Apply Online') }}
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div> */?>

<div class="clearfix mt-20"></div>
                    @if($relatedPosts)
                    <h3>Tin tuyển dụng liên quan</h3>

                        <div class="inner inner-box">
                            @foreach($relatedPosts as $relatedPosts)
                                @include('post.inc.item-list',['post'=>$relatedPosts])
                                @endforeach

                        </div>


                        @endif


                </div>
                <!--/.page-content-->
                <div class="col-sm-4 page-sidebar-right">
                    <aside>
                        <div class="panel">
                            <div class="panel-body">
                                @if ($post->featured==1 and !empty($post->latestPayment))
                                    @if (isset($post->latestPayment->package) and !empty($post->latestPayment->package))
                                        <i class="icon-ok-circled tooltipHere"
                                           style="color: {{ $post->latestPayment->package->ribbon }};" title=""
                                           data-placement="right"
                                           data-toggle="tooltip"
                                           data-original-title="{{ $post->latestPayment->package->short_name }}"></i>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="panel sidebar-panel panel-contact-seller">
                            <div class="panel-heading">{{ t('Company Information') }}</div>
                            <div class="panel-content user-info">
                                <div class="panel-body text-center">
                                    <div class="seller-info">
                                        <div class="company-logo-thumb mb20">
                                            @if (isset($post->company) and !empty($post->company))
                                                <?php $attr = ['countryCode' => config('country.icode'), 'id' => $post->company->id,'companySlug' =>  $post->company->slug]; ?>
                                                <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}">
                                                    <img alt="Logo {{ $post->company_name }}" class="img-responsive"
                                                         src="{{ resize($post->logo, 'big') }}">
                                                </a>
                                            @else
                                                <img alt="Logo {{ $post->company_name }}" class="img-responsive"
                                                     src="{{ resize($post->logo, 'big') }}">
                                            @endif
                                        </div>
                                        @if (isset($post->company) and !empty($post->company))
                                            <h3 class="no-margin">
                                                <?php $attr = ['countryCode' => config('country.icode'), 'id' => $post->company->id,'companySlug' =>  $post->company->slug]; ?>
                                                <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}">
                                                    {{ $post->company->name }}
                                                </a>
                                            </h3>
                                        @else
                                            <h3 class="no-margin">{{ $post->company_name }}</h3>
                                        @endif
                                        <?php /*<p>
                                            {{ t('Location') }}:&nbsp;
                                            <strong>
                                                <?php $attr = [
                                                    'countryCode' => config('country.icode'),
                                                    'city' => slugify($post->city->name),
                                                    'id' => $post->city->id
                                                ]; ?>
                                                <a href="{!! lurl(trans('routes.v-search-city', $attr), $attr) !!}">
                                                    {{ $post->city->name }}
                                                </a>
                                            </strong>
                                        </p>*/?>
                                        @if (!empty($post->company_description))
                                        <!-- Company Description -->

                                            <div class="text-left">
                                                {!! (createAutoLink(strCleaner($post->company_description))) !!}
                                            </div>
                                        @endif


                                        @if (isset($post->company) and !empty($post->company))
                                            @if (!empty($post->company->website))
                                                <p>
                                                    {{ t('Web') }}:
                                                    <strong>
                                                        <a href="{{ $post->company->website }}" target="_blank"
                                                           rel="nofollow">
                                                            {{ getHostByUrl($post->company->website) }}
                                                        </a>
                                                    </strong>
                                                </p>
                                            @endif
                                        @endif

                                    </div>
                                    <div class="user-ads-action">
                                        @if (auth()->check())
                                            @if (auth()->user()->id == $post->user_id)
                                                <a href="{{ lurl('posts/' . $post->id . '/edit') }}" data-toggle="modal"
                                                   class="btn btn-success btn-block">
                                                    <i class="fa fa-pencil-square-o"></i> {{ t('Update the Details') }}
                                                </a>
                                                @if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
                                                    <a href="{{ lurl('posts/' . $post->id . '/payment') }}"
                                                       data-toggle="modal" class="btn btn-success btn-block">
                                                        <i class="icon-ok-circled2"></i> {{ t('Make It Premium') }}
                                                    </a>
                                                @endif
                                            @else
                                                @if ($post->email != '' and in_array(auth()->user()->user_type_id, [2]))
                                                    <a href="{{ $applyJobURL }}"
                                                       {!! $applyLinkAttr !!} class="btn btn-primary btn-block">
                                                        <i class="icon-mail-2"></i> {{ t('Apply Online') }}
                                                    </a>
                                                @endif
                                                @if ($post->phone_hidden != 1 and !empty($post->phone))
                                                    <a href="{{ $phoneLink }}"
                                                       {!! $phoneLinkAttr !!} class="btn btn-primary btn-block showphone">
                                                        <i class="icon-phone-1"></i>
                                                        {!! $phone !!}{{-- t('View phone') --}}
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            @if ($post->email != '')
                                                <a href="{{ $applyJobURL }}"
                                                   {!! $applyLinkAttr !!} class="btn btn-primary btn-block">
                                                    <i class="icon-mail-2"></i> {{ t('Apply Online') }}
                                                </a>
                                            @endif
                                            @if ($post->phone_hidden != 1 and !empty($post->phone))
                                                <a href="{{ $phoneLink }}"
                                                   {!! $phoneLinkAttr !!} class="btn btn-primary btn-block showphone">
                                                    <i class="icon-phone-1"></i>
                                                    {!! $phone !!}{{-- t('View phone') --}}
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (config('settings.single.show_post_on_googlemap'))
                            <div class="panel sidebar-panel">
                                <div class="panel-heading">{{ t('Location\'s Map') }}</div>
                                <div class="panel-content">
                                    <div class="panel-body text-left" style="padding: 0;">
                                        <div class="ads-googlemaps">
                                            <iframe id="googleMaps" width="100%" height="250" frameborder="0"
                                                    scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (isVerifiedPost($post))
                            @include('layouts.inc.social.horizontal')
                        @endif

                        <div class="panel sidebar-panel">
                            <div class="panel-heading">{{ t('Tips for candidates') }}</div>
                            <div class="panel-content">
                                <div class="panel-body text-left">
                                    <ul class="list-check">
                                        <li> {{ t('Check if the offer matches your profile') }} </li>
                                        <li> {{ t('Check the start date') }} </li>
                                        <li> {{ t('Meet the employer in a professional location') }} </li>
                                    </ul>
                                    <?php $tipsLinkAttributes = getUrlPageByType('tips'); ?>
                                    @if (!str_contains($tipsLinkAttributes, 'href="#"') and !str_contains($tipsLinkAttributes, 'href=""'))
                                        <p>
                                            <a class="pull-right" {!! $tipsLinkAttributes !!}>
                                                {{ t('Know more') }}
                                                <i class="fa fa-angle-double-right"></i>
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        @include('home.inc.featured', ['firstSection' => false])
        @include('layouts.inc.advertising.bottom', ['firstSection' => false])
        @if (isVerifiedPost($post))
            @include('layouts.inc.tools.facebook-comments', ['firstSection' => false])
        @endif

    </div>
@endsection

@section('modal_message')
    @if (auth()->check() or config('settings.single.guests_can_apply_jobs')=='1')
        @include('post.inc.compose-message')
    @endif
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
    @if (config('services.googlemaps.key'))
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}"
                type="text/javascript"></script>
    @endif

    <script>
        /* Favorites Translation */
        var lang = {
            labelSavePostSave: "{!! t('Save Job') !!}",
            labelSavePostRemove: "{{ t('Saved Job') }}",
            loginToSavePost: "{!! t('Please log in to save the Ads.') !!}",
            loginToSaveSearch: "{!! t('Please log in to save your search.') !!}",
            confirmationSavePost: "{!! t('Post saved in favorites successfully !') !!}",
            confirmationRemoveSavePost: "{!! t('Post deleted from favorites successfully !') !!}",
            confirmationSaveSearch: "{!! t('Search saved successfully !') !!}",
            confirmationRemoveSaveSearch: "{!! t('Search deleted successfully !') !!}"
        };

        $(document).ready(function () {
            @if (config('settings.single.show_post_on_googlemap'))
            /* Google Maps */
            getGoogleMaps(
                '{{ config('services.googlemaps.key') }}',
                '{{ (isset($post->city) and !empty($post->city)) ? addslashes($post->city->name) . ',' . config('country.name') : config('country.name') }}',
                '{{ config('app.locale') }}'
            );
            @endif
        })
    </script>
@endsection
