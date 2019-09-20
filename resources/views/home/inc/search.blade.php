<?php
// Init.
$sForm = [
    'enableFormAreaCustomization' => '1',
    'hideTitles' => '1',
    'title' => t('Find a job near you'),
    'subTitle' => t('Simple, fast and efficient'),
    'bigTitleColor' => '', // 'color: #FFF;',
    'subTitleColor' => '', // 'color: #FFF;',
    'backgroundColor' => '', // 'background-color: #444;',
    'backgroundImage' => '', // null,
    'height' => '', // '400px',
    'parallax' => '0',
    'hideForm' => '0',
    'formBorderColor' => '', // 'background-color: #7324bc;',
    'formBorderSize' => '', // '5px',
    'formBtnBackgroundColor' => '', // 'background-color: #7324bc; border-color: #7324bc;',
    'formBtnTextColor' => '', // 'color: #FFF;',
];

// Get Search Form Options
if (isset($searchFormOptions)) {
    if (isset($searchFormOptions['enable_form_area_customization']) and !empty($searchFormOptions['enable_form_area_customization'])) {
        $sForm['enableFormAreaCustomization'] = $searchFormOptions['enable_form_area_customization'];
    }
    if (isset($searchFormOptions['hide_titles']) and !empty($searchFormOptions['hide_titles'])) {
        $sForm['hideTitles'] = $searchFormOptions['hide_titles'];
    }
    if (isset($searchFormOptions['title_' . config('app.locale')]) and !empty($searchFormOptions['title_' . config('app.locale')])) {
        $sForm['title'] = $searchFormOptions['title_' . config('app.locale')];
        $sForm['title'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['title']);
        if (str_contains($sForm['title'], '{count_jobs}')) {
            try {
                $countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
            } catch (\Exception $e) {
                $countPosts = 0;
            }
            $sForm['title'] = str_replace('{count_jobs}', $countPosts, $sForm['title']);
        }
        if (str_contains($sForm['title'], '{count_users}')) {
            try {
                $countUsers = \App\Models\User::count();
            } catch (\Exception $e) {
                $countUsers = 0;
            }
            $sForm['title'] = str_replace('{count_users}', $countUsers, $sForm['title']);
        }
    }
    if (isset($searchFormOptions['sub_title_' . config('app.locale')]) and !empty($searchFormOptions['sub_title_' . config('app.locale')])) {
        $sForm['subTitle'] = $searchFormOptions['sub_title_' . config('app.locale')];
        $sForm['subTitle'] = str_replace(['{app_name}', '{country}'], [config('app.name'), config('country.name')], $sForm['subTitle']);
        if (str_contains($sForm['subTitle'], '{count_jobs}')) {
            try {
                $countPosts = \App\Models\Post::currentCountry()->unarchived()->count();
            } catch (\Exception $e) {
                $countPosts = 0;
            }
            $sForm['subTitle'] = str_replace('{count_jobs}', $countPosts, $sForm['subTitle']);
        }
        if (str_contains($sForm['subTitle'], '{count_users}')) {
            try {
                $countUsers = \App\Models\User::count();
            } catch (\Exception $e) {
                $countUsers = 0;
            }
            $sForm['subTitle'] = str_replace('{count_users}', $countUsers, $sForm['subTitle']);
        }
    }
    if (isset($searchFormOptions['parallax']) and !empty($searchFormOptions['parallax'])) {
        $sForm['parallax'] = $searchFormOptions['parallax'];
    }
    if (isset($searchFormOptions['hide_form']) and !empty($searchFormOptions['hide_form'])) {
        $sForm['hideForm'] = $searchFormOptions['hide_form'];
    }
}

// Country Map status (shown/hidden)
$showMap = false;
if (file_exists(config('icetea.core.maps.path') . config('country.icode') . '.svg')) {
    if (isset($citiesOptions) and isset($citiesOptions['show_map']) and $citiesOptions['show_map'] == '1') {
        $showMap = true;
    }
}

//$provinces = \App\Models\SubAdmin1::where('country_code','VN')->orderBy('position','desc')->get();
$categories = \App\Models\Category::where('active', 1)->where('parent_id', 0)->where('translation_lang', config('app.locale'))->orderBy('name', 'asc')->get();
?>
@if (isset($sForm['enableFormAreaCustomization']) and $sForm['enableFormAreaCustomization'] == '1')

    @if (isset($firstSection) and !$firstSection)
        <div class="h-spacer"></div>
    @endif

    <?php $parallax = (isset($sForm['parallax']) and $sForm['parallax'] == '1') ? 'parallax' : ''; ?>
    <div class="wide-intro fullBackground {{ $parallax }}">
        <?php /* <div class="home-slider owl-carousel"
             style="width: 100%;height:400px;display: block; overflow: hidden;position: relative">
            @if (isset($searchFormOptions['background_image']) and !empty($searchFormOptions['background_image']))

                <img src="{!!  \Storage::url($searchFormOptions['background_image']) . getPictureVersion()  !!}"/>
            @endif

            @if (isset($searchFormOptions['background_image_1']) and !empty($searchFormOptions['background_image_1']))
                <img src="{!!  \Storage::url($searchFormOptions['background_image_1']) . getPictureVersion()  !!}"/>
            @endif
            @if (isset($searchFormOptions['background_image_2']) and !empty($searchFormOptions['background_image_2']))
                <img src="{!!  \Storage::url($searchFormOptions['background_image_2']) . getPictureVersion()  !!}"/>
            @endif
            @if (isset($searchFormOptions['background_image_3']) and !empty($searchFormOptions['background_image_3']))
                <img src="{!!  \Storage::url($searchFormOptions['background_image_3']) . getPictureVersion()  !!}"/>
            @endif
        </div> */?>
        <div class="dtable hw100" style="position: absolute;z-index: 1;top:0">
            <div class="dtable-cell hw100">
                <div class="container text-center">
                    @if ($sForm['hideTitles'] != '1')
                        <h1 class="intro-title animated fadeInDown"> {{ $sForm['title'] }} </h1>
                        <p class="sub animateme fittext3 animated fadeIn">
                            {!! $sForm['subTitle'] !!}
                        </p>
                    @endif

                    @if ($sForm['hideForm'] != '1')
                        <div class="row search-row fadeInUp">
                            <div class="col-md-10 col-md-offset-1 col-sm-12">

                                <?php $attr = ['countryCode' => config('country.icode')]; ?>
                                <form id="seach" name="search"
                                      action="{{ lurl(trans('routes.v-search', $attr), $attr) }}"
                                      method="GET">
                                    <div class="col-lg-4 col-sm-5 search-col relative">
                                        <i class="icon-docs icon-append"></i>
                                        <input type="text" name="q" class="form-control keyword has-icon"
                                               placeholder="{{ t('What?') }}" value="">
                                    </div>
                                    <div class="col-lg-3 col-sm-5 search-col relative">
                                        <i class="icon-cog icon-append"></i>
                                        <select name="c" id="category" class="form-control has-icon selector">
                                            <option value="">Chọn ngành nghề</option>
                                            @foreach ($categories as $category)
                                                <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-sm-5 search-col relative locationicon">
                                        <i class="icon-location-2 icon-append"></i>
                                        <?php /*<input type="hidden" id="lSearch" name="l" value="">
                                        @if ($showMap)
                                            <input type="text" id="locSearch" name="location"
                                                   class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                                   placeholder="{{ t('Where?') }}" value="" title=""
                                                   data-placement="bottom"
                                                   data-toggle="tooltip" type="button"
                                                   data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
                                        @else
                                            <input type="text" id="locSearch" name="location"
                                                   class="form-control locinput input-rel searchtag-input has-icon"
                                                   placeholder="{{ t('Where?') }}" value="">
                                        @endif*/?>

                                        @if (isset($cities) and $cities->count() > 0)
                                            <select id="location" name="l" class="form-control has-icon selector" placeholder="Địa điểm làm việc">
                                                <option value="">Tất cả</option>
                                                @foreach ($cities as $city)
                                                    <?php
                                                    $attr = ['countryCode' => config('country.icode')];
                                                    $fullUrlLocation = lurl(trans('routes.v-search', $attr), $attr);
                                                    $locationParams = [
                                                        'l' => $city->id,
                                                        'r' => '',
                                                        'c' => (isset($cat)) ? $cat->tid : '',
                                                        'sc' => (isset($subCat)) ? $subCat->tid : '',
                                                    ];
                                                    ?>
                                                    <option value="{!! $city->id !!}" @if(\request()->get('l') == $city->id) selected @endif >
                                                        {{ $city->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    <div class="col-lg-2 col-sm-2 search-col">
                                        <button class="btn btn-primary btn-search btn-block">
                                            <i class="icon-search"></i> <strong>{{ t('Find') }}</strong>
                                        </button>
                                    </div>
                                    {!! csrf_field() !!}
                                </form>
                            </div>

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@else

    @include('home.inc.spacer')
    <div class="container">
        <div class="intro">
            <div class="dtable hw100">
                <div class="dtable-cell hw100">
                    <div class="container text-center">
                        <div class="row search-row">
                            <?php $attr = ['countryCode' => config('country.icode')]; ?>
                            <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}"
                                  method="GET">
                                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 search-col relative">
                                    <i class="icon-docs icon-append"></i>
                                    <input type="text" name="q" class="form-control keyword has-icon"
                                           placeholder="{{ t('What?') }}" value="">
                                </div>
                                <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 search-col relative locationicon">
                                    <i class="icon-location-2 icon-append"></i>
                                    <?php /*<input type="hidden" id="lSearch" name="l" value="">
                                    @if ($showMap)
                                        <input type="text" id="locSearch" name="location"
                                               class="form-control locinput input-rel searchtag-input has-icon tooltipHere"
                                               placeholder="{{ t('Where?') }}" value="" title="" data-placement="bottom"
                                               data-toggle="tooltip" type="button"
                                               data-original-title="{{ t('Enter a city name OR a state name with the prefix ":prefix" like: :prefix', ['prefix' => t('area:')]) . t('State Name') }}">
                                    @else
                                        <input type="text" id="locSearch" name="location"
                                               class="form-control locinput input-rel searchtag-input has-icon"
                                               placeholder="{{ t('Where?') }}" value="">
                                    @endif*/?>

                                    @if (isset($cities) and $cities->count() > 0)
                                        <select id="location" name="l">
                                        @foreach ($cities as $city)
                                            <?php
                                            $attr = ['countryCode' => config('country.icode')];
                                            $fullUrlLocation = lurl(trans('routes.v-search', $attr), $attr);
                                            $locationParams = [
                                                'l' => $city->id,
                                                'r' => '',
                                                'c' => (isset($cat)) ? $cat->tid : '',
                                                'sc' => (isset($subCat)) ? $subCat->tid : '',
                                            ];
                                            ?>
                                            <option value="{!! $city->id !!}" @if(\request()->get('l') == $city->id) selected @endif>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 search-col">
                                    <button class="btn btn-primary btn-search btn-block">
                                        <i class="icon-search"></i> <strong>{{ t('Search') }}</strong>
                                    </button>
                                </div>
                                {!! csrf_field() !!}
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endif

@push('css-stack')
    {{--<link rel="stylesheet" href="/js/owl-carousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="/js/owl-carousel/assets/owl.theme.default.css">--}}
    <style>
        .home-slider .owl-carousel .owl-wrapper {
            display: flex !important;
        }

        .home-slider .owl-carousel .owl-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            max-width: initial;
        }

        .home-slider .owl-dots {
            position: absolute;
            display: block;
            width: 100%;
            bottom: 20px;
            z-index: 999;
            flex: 1;
            text-align: center;

        }

        .home-slider .owl-dot {
            background-color: #FFFFFF;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            margin-right: 5px;
            display: inline-flex;
        }

        .home-slider .owl-dot.active {
            background-color: #FDE328;
        }

        #homepage > div.container > div > divr.ow-featured-category.row-featured-company {
            display: none;
        }
    </style>
@endpush
@push('js-stack')
    <script src="/js/homeslide.js"></script>

    <script>
        <?php

            $images = [];
            if(isset($searchFormOptions['background_image']) and !empty($searchFormOptions['background_image'])){
                $images[] = \Storage::url($searchFormOptions['background_image']) . getPictureVersion();
            }
        if(isset($searchFormOptions['background_image_2']) and !empty($searchFormOptions['background_image_2'])){
            $images[] = \Storage::url($searchFormOptions['background_image_2']) . getPictureVersion();
        }
        if(isset($searchFormOptions['background_image_3']) and !empty($searchFormOptions['background_image_3'])){
            $images[] = \Storage::url($searchFormOptions['background_image_3']) . getPictureVersion();
        }
        if(isset($searchFormOptions['background_image_4']) and !empty($searchFormOptions['background_image_4'])){
            $images[] = \Storage::url($searchFormOptions['background_image_4']) . getPictureVersion();
        }

        ?>
        $('#category').select2();
        $('#location').select2();
        $('.fullBackground').fullClip({
            images: <?php echo json_encode($images)?>,
            transitionTime: 1500,
            wait: 5000
        });
    </script>
@endpush

<div class="clearfix"></div>
