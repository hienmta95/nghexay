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


<div class="jp_banner_heading_cont_wrapper">
    <div class="container">
        <div class="row">

            {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
            {{--<div class="jp_job_heading_wrapper">--}}
            {{--<div class="jp_job_heading">--}}
            {{--<h1><span>5,000+</span> Browse Jobs</h1>--}}
            {{--<p>Find Jobs, Employment & Career Opportunities</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php $attr = ['countryCode' => config('country.icode')]; ?>
                <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}"
                      method="GET">
                    {!! csrf_field() !!}
                    <div class="jp_header_form_wrapper">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <input type="text" name="q" placeholder="{{ t('What?') }}" value="">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="jp_form_location_wrapper">
                                <i class="fa fa-dot-circle-o first_icon"></i>
                                <select name="c" id="category">
                                    <option value="">Chọn ngành nghề</option>
                                    @foreach ($categories as $category)
                                        <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                                    @endforeach
                                </select>
                                <i class="fa fa-angle-down second_icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="jp_form_exper_wrapper">
                                <i class="fa fa-dot-circle-o first_icon"></i>
                                @if (isset($cities) and $cities->count() > 0)
                                    <select name="l" placeholder="Địa điểm làm việc" id="location" >
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
                                <i class="fa fa-angle-down second_icon"></i>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="jp_form_btn_wrapper">
                                <ul>
                                    {{--<li><a href="#"><i class="fa fa-search"></i> {{ t('Find') }}</a></li>--}}
                                    <li><button type="submit"><i class="fa fa-search"></i> {{ t('Find') }}</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="jp_banner_main_jobs_wrapper">
                    <div class="jp_banner_main_jobs">
                        {{--<ul>--}}
                        {{--<li><i class="fa fa-tags"></i> Trending Keywords :</li>--}}
                        {{--<li><a href="#">ui designer,</a></li>--}}
                        {{--<li><a href="#">developer,</a></li>--}}
                        {{--<li><a href="#">senior</a></li>--}}
                        {{--<li><a href="#">it company,</a></li>--}}
                        {{--<li><a href="#">design,</a></li>--}}
                        {{--<li><a href="#">call center</a></li>--}}
                        {{--</ul>--}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="jp_banner_jobs_categories_wrapper">
    <div class="container">
        <?php $arrFa = ['fa-code', 'fa-laptop', 'fa-bar-chart', 'fa-medkit', 'fa-university', 'fa-th-large'] ?>
        @foreach ($categories as $key => $category)
            @if($key < 6)
                <div class="jp_top_jobs_category_wrapper jp_job_cate_left_border {{ $key == 0 ? 'jp_job_cate_left_border_bottom' : '' }}">
                    <div class="jp_top_jobs_category">
                        <i class="fa {{ $arrFa[$key] }}"></i>
                        <h3><a href="#">{!! $category->name !!}</a></h3>
                        {{--<p>(240 jobs)</p>--}}
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

@push('js-stack')
    <script>
        $(function () {
            $('#category').select2();
            $('#location').select2();
        });
    </script>
@endpush