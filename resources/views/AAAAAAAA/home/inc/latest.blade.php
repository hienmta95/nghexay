<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration');
}
?>


<!-- jp tittle slider Wrapper Start -->
@if (isset($featuredCompanies) and !empty($featuredCompanies))
@if (isset($featuredCompanies->companies) and $featuredCompanies->companies->count() > 0)
<div class="jp_tittle_slider_main_wrapper" style="float:left; width:100%; margin-top:30px;">
    <div class="container">
        <div class="jp_tittle_name_wrapper match1">
            <div class="jp_tittle_name">
                <h3>Việc làm </h3>
                <h4>Tuyển gấp</h4>
            </div>
        </div>
        <div class="jp_tittle_slider_wrapper match1">
            <div class="jp_tittle_slider_content_wrapper">
                <div class="owl-carousel owl-theme">

                    @if (isset($vipJobs) and !empty($vipJobs))
                    <?php
                    $fgroups = collect($vipJobs)->take(30);

                    for ($i = 0; $i < count($fgroups); $i+=3) {
                    ?>
                        <div class="item">

                        @if(isset($fgroups[$i]))
                        <?php $post = $fgroups[$i]; ?>
                        <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                        <div class="jp_tittle_slides_one">
                            <a href="{{ lurl($post->uri, $attr) }}" title="{!! $post->title !!}">
                                <div class="jp_tittle_side_img_wrapper">
                                    <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                </div>
                                <div class="jp_tittle_side_cont_wrapper">
                                    <h4>{{ $post->title }}</h4>
                                    <p>{{ $post->company_name }}</p>
                                </div>
                            </a>
                        </div>
                        @endif

                        @if(isset($fgroups[$i+1]))
                        <?php $post = $fgroups[$i+1]; ?>
                        <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                        <div class="jp_tittle_slides_one jp_tittle_slides_two">
                            <a href="{{ lurl($post->uri, $attr) }}" title="{!! $post->title !!}">
                                <div class="jp_tittle_side_img_wrapper">
                                    <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                </div>
                                <div class="jp_tittle_side_cont_wrapper">
                                    <h4>{{ $post->title }}</h4>
                                    <p>{{ $post->company_name }}</p>
                                </div>
                            </a>
                        </div>
                        @endif

                        @if(isset($fgroups[$i+2]))
                        <?php $post = $fgroups[$i+2]; ?>
                        <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                        <div class="jp_tittle_slides_one jp_tittle_slides_third">
                            <a href="{{ lurl($post->uri, $attr) }}" title="{!! $post->title !!}">
                                <div class="jp_tittle_side_img_wrapper">
                                    <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                </div>
                                <div class="jp_tittle_side_cont_wrapper">
                                    <h4>{{ $post->title }}</h4>
                                    <p>{{ $post->company_name }}</p>
                                </div>
                            </a>
                        </div>
                        @endif

                    </div>
                    <?php } ?>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endif
@endif
<!-- jp tittle slider Wrapper End -->

<!-- jp first sidebar Wrapper Start -->
<div class="jp_first_sidebar_main_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="jp_hiring_slider_main_wrapper">
                            <div class="jp_hiring_heading_wrapper">
                                <h2>Doanh nghiệp hàng đầu</h2>
                            </div>
                            <div class="jp_hiring_slider_wrapper">
                                <div class="owl-carousel owl-theme">

                                    <?php
                                    $fgroups = $featuredCompanies->companies->toArray();

                                    for ($i = 0; $i < count($fgroups); $i++) {
                                    ?>

                                    <?php
                                    // Company URL setting
                                    $iCompany = $fgroups[$i];
                                    $attr = ['countryCode' => config('country.icode'), 'id' => $iCompany['id'], 'companySlug' => $iCompany['slug']];
                                    $companyUrl = lurl(trans('routes.v-search-company', $attr), $attr);
                                    ?>

                                    <div class="item">
                                        <div class="jp_hiring_content_main_wrapper">
                                            <div class="jp_hiring_content_wrapper">
                                                <img src="{{ resizeThumb(\App\Models\Company::getLogo($iCompany['logo']), 185,90,'true','false') }}" alt="{{ $iCompany['name'] }}" />
                                                <div class="wrap-matchHeight">
                                                    <h4>{{ $iCompany['name'] }}</h4>
{{--                                                    <p>{{ $iCompany['company_name'] }}</p>--}}
                                                </div>

                                                <ul style="margin-top: 15px">
                                                    <li>
                                                        <a href="{{ $companyUrl }}" title="{{ $iCompany['name'] }}">
                                                            Chi tiết
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="cc_featured_product_main_wrapper">
                            <div class="jp_hiring_heading_wrapper jp_job_post_heading_wrapper">
                                <h2>Việc hấp dẫn</h2>
                            </div>
                            <ul class="nav nav-tabs" role="tablist">
                                {{--<li role="presentation"><a href="#best" aria-controls="best" role="tab" data-toggle="tab">Full Time </a></li>--}}
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="best">
                                <div class="ss_featured_products">
                                    <div class="owl-carousel owl-theme">

                                        @if (isset($featured) and !empty($featured) and !empty($featured->posts))
                                            <?php
                                                $groups = collect($featured->posts)->take(40);
                                                $perPage = round(count($groups)/3);
                                            ?>

                                            <div class="item" data-hash="zero">
                                                <div id="featured-list" class="jobs-list ">
                                                    <?php
                                                    for ($i = 0; $i < $perPage; $i++) {
                                                    ?>
                                                    <?php $post = $groups[$i]; ?>
                                                    <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id];
                                                    // Get the Post's City
                                                    $cacheId = config('country.code') . '.city.' . $post->city_id;
                                                    $city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                        $city = \App\Models\City::find($post->city_id);
                                                        return $city;
                                                    });
                                                    if (empty($city)) continue;

                                                    // Get the Post's Type
                                                    $cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
                                                    $postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                        $postType = \App\Models\PostType::findTrans($post->post_type_id);
                                                        return $postType;
                                                    });
                                                    if (empty($postType)) continue;

                                                    // Get the Post's Salary Type
                                                    $cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
                                                    $salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                        $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
                                                        return $salaryType;
                                                    });
                                                    if (empty($salaryType)) continue;
                                                    ?>

                                                    <div class="jp_job_post_main_wrapper_cont {{ $i != 0 ? 'jp_job_post_main_wrapper_cont2' : '' }}">
                                                        <div class="jp_job_post_main_wrapper">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                    <div class="jp_job_post_side_img">
                                                                        <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                                                    </div>
                                                                    <div class="jp_job_post_right_cont">
                                                                        <h4>{{ $post->title }}</h4>
                                                                        <p>{{ $post->company_name }}</p>
                                                                        <ul>
                                                                            <li><i class="fa fa-cc-paypal"></i> <?php
                                                                                $money = '';
                                                                                if ($post->salary_min > 0 or $post->salary_max > 0) {

                                                                                    $money .= \App\Helpers\Number::money($post->salary_min);
                                                                                    if ($post->salary_max > 0) {
                                                                                        if ($post->salary_min > 0) {
                                                                                            $money .= ' - ';
                                                                                        }

                                                                                        $money .= \App\Helpers\Number::money($post->salary_max);

                                                                                        if (!empty($salaryType)) {
                                                                                            $money .= t('per') . $salaryType->name;
                                                                                        }
                                                                                    }
                                                                                } else {
                                                                                    $money = 'Thương lượng';
                                                                                }
                                                                                echo $money;
                                                                                ?></li>
                                                                            <li><i class="fa fa-map-marker"></i> {{ $city->name }}</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                    <div class="jp_job_post_right_btn_wrapper">
                                                                        <ul>
                                                                            <li>
                                                                                {{--<a href="#"><i class="fa fa-heart-o"></i></a>--}}
                                                                            </li>
                                                                            <li><a href="{{ lurl($post->uri, $attr) }}">Full Time</a></li>
                                                                            <li><a href="{{ lurl($post->uri, $attr) }}">Đăng kí</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--<div class="jp_job_post_keyword_wrapper">--}}
                                                            {{--<ul>--}}
                                                                {{--<li><i class="fa fa-tags"></i>Keywords :</li>--}}
                                                                {{--<li><a href="#">ui designer,</a></li>--}}
                                                                {{--<li><a href="#">developer,</a></li>--}}
                                                                {{--<li><a href="#">senior</a></li>--}}
                                                                {{--<li><a href="#">it company,</a></li>--}}
                                                                {{--<li><a href="#">design,</a></li>--}}
                                                                {{--<li><a href="#">call center</a></li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="item" data-hash="one">
                                                    <div id="featured-list" class="jobs-list ">
                                                        <?php
                                                        for ($i = $perPage; $i < 2*$perPage; $i++) {
                                                        ?>
                                                        <?php $post = $groups[$i]; ?>
                                                        <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id];
                                                        // Get the Post's City
                                                        $cacheId = config('country.code') . '.city.' . $post->city_id;
                                                        $city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                            $city = \App\Models\City::find($post->city_id);
                                                            return $city;
                                                        });
                                                        if (empty($city)) continue;

                                                        // Get the Post's Type
                                                        $cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
                                                        $postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                            $postType = \App\Models\PostType::findTrans($post->post_type_id);
                                                            return $postType;
                                                        });
                                                        if (empty($postType)) continue;

                                                        // Get the Post's Salary Type
                                                        $cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
                                                        $salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                            $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
                                                            return $salaryType;
                                                        });
                                                        if (empty($salaryType)) continue;
                                                        ?>

                                                        <div class="jp_job_post_main_wrapper_cont {{ $i != $perPage ? 'jp_job_post_main_wrapper_cont2' : '' }}">
                                                            <div class="jp_job_post_main_wrapper">
                                                                <div class="row">
                                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                        <div class="jp_job_post_side_img">
                                                                            <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                                                        </div>
                                                                        <div class="jp_job_post_right_cont">
                                                                            <h4>{{ $post->title }}</h4>
                                                                            <p>{{ $post->company_name }}</p>
                                                                            <ul>
                                                                                <li><i class="fa fa-cc-paypal"></i> <?php
                                                                                    $money = '';
                                                                                    if ($post->salary_min > 0 or $post->salary_max > 0) {

                                                                                        $money .= \App\Helpers\Number::money($post->salary_min);
                                                                                        if ($post->salary_max > 0) {
                                                                                            if ($post->salary_min > 0) {
                                                                                                $money .= ' - ';
                                                                                            }

                                                                                            $money .= \App\Helpers\Number::money($post->salary_max);

                                                                                            if (!empty($salaryType)) {
                                                                                                $money .= t('per') . $salaryType->name;
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        $money = 'Thương lượng';
                                                                                    }
                                                                                    echo $money;
                                                                                    ?></li>
                                                                                <li><i class="fa fa-map-marker"></i> {{ $city->name }}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                        <div class="jp_job_post_right_btn_wrapper">
                                                                            <ul>
                                                                                <li>
                                                                                    {{--<a href="#"><i class="fa fa-heart-o"></i></a>--}}
                                                                                </li>
                                                                                <li><a href="{{ lurl($post->uri, $attr) }}">Full Time</a></li>
                                                                                <li><a href="{{ lurl($post->uri, $attr) }}">Đăng kí</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--<div class="jp_job_post_keyword_wrapper">--}}
                                                            {{--<ul>--}}
                                                            {{--<li><i class="fa fa-tags"></i>Keywords :</li>--}}
                                                            {{--<li><a href="#">ui designer,</a></li>--}}
                                                            {{--<li><a href="#">developer,</a></li>--}}
                                                            {{--<li><a href="#">senior</a></li>--}}
                                                            {{--<li><a href="#">it company,</a></li>--}}
                                                            {{--<li><a href="#">design,</a></li>--}}
                                                            {{--<li><a href="#">call center</a></li>--}}
                                                            {{--</ul>--}}
                                                            {{--</div>--}}
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            <div class="item" data-hash="two">
                                                    <div id="featured-list" class="jobs-list ">
                                                        <?php
                                                        for ($i = 2*$perPage; $i < count($groups); $i++) {
                                                        ?>
                                                        <?php $post = $groups[$i]; ?>
                                                        <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id];
                                                        // Get the Post's City
                                                        $cacheId = config('country.code') . '.city.' . $post->city_id;
                                                        $city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                            $city = \App\Models\City::find($post->city_id);
                                                            return $city;
                                                        });
                                                        if (empty($city)) continue;

                                                        // Get the Post's Type
                                                        $cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
                                                        $postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                            $postType = \App\Models\PostType::findTrans($post->post_type_id);
                                                            return $postType;
                                                        });
                                                        if (empty($postType)) continue;

                                                        // Get the Post's Salary Type
                                                        $cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
                                                        $salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                            $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
                                                            return $salaryType;
                                                        });
                                                        if (empty($salaryType)) continue;
                                                        ?>

                                                        <div class="jp_job_post_main_wrapper_cont {{ $i != 2*$perPage ? 'jp_job_post_main_wrapper_cont2' : '' }}">
                                                            <div class="jp_job_post_main_wrapper">
                                                                <div class="row">
                                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                        <div class="jp_job_post_side_img">
                                                                            <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                                                        </div>
                                                                        <div class="jp_job_post_right_cont">
                                                                            <h4>{{ $post->title }}</h4>
                                                                            <p>{{ $post->company_name }}</p>
                                                                            <ul>
                                                                                <li><i class="fa fa-cc-paypal"></i> <?php
                                                                                    $money = '';
                                                                                    if ($post->salary_min > 0 or $post->salary_max > 0) {

                                                                                        $money .= \App\Helpers\Number::money($post->salary_min);
                                                                                        if ($post->salary_max > 0) {
                                                                                            if ($post->salary_min > 0) {
                                                                                                $money .= ' - ';
                                                                                            }

                                                                                            $money .= \App\Helpers\Number::money($post->salary_max);

                                                                                            if (!empty($salaryType)) {
                                                                                                $money .= t('per') . $salaryType->name;
                                                                                            }
                                                                                        }
                                                                                    } else {
                                                                                        $money = 'Thương lượng';
                                                                                    }
                                                                                    echo $money;
                                                                                    ?></li>
                                                                                <li><i class="fa fa-map-marker"></i> {{ $city->name }}</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                        <div class="jp_job_post_right_btn_wrapper">
                                                                            <ul>
                                                                                <li>
                                                                                    {{--<a href="#"><i class="fa fa-heart-o"></i></a>--}}
                                                                                </li>
                                                                                <li><a href="{{ lurl($post->uri, $attr) }}">Full Time</a></li>
                                                                                <li><a href="{{ lurl($post->uri, $attr) }}">Đăng kí</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{--<div class="jp_job_post_keyword_wrapper">--}}
                                                            {{--<ul>--}}
                                                            {{--<li><i class="fa fa-tags"></i>Keywords :</li>--}}
                                                            {{--<li><a href="#">ui designer,</a></li>--}}
                                                            {{--<li><a href="#">developer,</a></li>--}}
                                                            {{--<li><a href="#">senior</a></li>--}}
                                                            {{--<li><a href="#">it company,</a></li>--}}
                                                            {{--<li><a href="#">design,</a></li>--}}
                                                            {{--<li><a href="#">call center</a></li>--}}
                                                            {{--</ul>--}}
                                                            {{--</div>--}}
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="video_nav_img_wrapper">
                                        <div class="video_nav_img">
                                            <ul>
                                                <li><a class="button secondary url owl_nav" href="#zero">1</a></li>
                                                <li><a class="button secondary url owl_nav" href="#one">2</a></li>
                                                <li><a class="button secondary url owl_nav active" href="#two">3</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="jp_first_right_sidebar_main_wrapper">
                    <div class="row">
                        {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
                            {{--<div class="jp_add_resume_wrapper">--}}
                                {{--<div class="jp_add_resume_img_overlay"></div>--}}
                                {{--<div class="jp_add_resume_cont">--}}
                                    {{--<img src="refactor-theme/images/content/resume_logo.png" alt="logo" />--}}
                                    {{--<h4> HOTLINE TƯ VẤN DÀNH CHO NHÀ TUYỂN DỤNG</h4>--}}
                                    {{--<ul>--}}
                                        {{--<li><a href="#"><i class="fa fa-phone"></i> (024) 777.80.999 <p>(Trong giờ hành chính)</p></a></li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="jp_spotlight_main_wrapper" style="margin-top: 0px">
                                <div class="spotlight_header_wrapper">
                                    <h4>Tin nổi bật</h4>
                                </div>
                                <div class="jp_spotlight_slider_wrapper">
                                    <div class="owl-carousel owl-theme">

                                        @if (isset($vipJobs) and !empty($vipJobs))
                                            <?php $fgroups = collect($vipJobs)->take(20);
                                            for ($i = 0; $i < count($fgroups); $i+=1) { ?>
                                                <?php $post = $fgroups[$i]; ?>
                                                <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id];

                                                // Get the Post's City
                                                $cacheId = config('country.code') . '.city.' . $post->city_id;
                                                $city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                $city = \App\Models\City::find($post->city_id);
                                                return $city;
                                                });
                                                if (empty($city)) continue;

                                                // Get the Post's Type
                                                $cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
                                                $postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                $postType = \App\Models\PostType::findTrans($post->post_type_id);
                                                return $postType;
                                                });
                                                if (empty($postType)) continue;

                                                // Get the Post's Salary Type
                                                $cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
                                                $salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                                $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
                                                return $salaryType;
                                                });
                                                if (empty($salaryType)) continue;
                                                ?>

                                            <div class="item">
                                                <div class="jp_spotlight_slider_img_Wrapper">
                                                    <img src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="{{ $post->company_name }}" />
                                                </div>
                                                <div class="jp_spotlight_slider_cont_Wrapper">
                                                    <p>{{ $post->title }}</p>
                                                    <h4>{{ $post->company_name }}</h4>
                                                    <ul>
                                                        <li>
                                                            <i class="fa fa-cc-paypal"></i>&nbsp;
                                                            <?php
                                                            $money = '';
                                                            if ($post->salary_min > 0 or $post->salary_max > 0) {

                                                                $money .= \App\Helpers\Number::money($post->salary_min);
                                                                if ($post->salary_max > 0) {
                                                                    if ($post->salary_min > 0) {
                                                                        $money .= ' - ';
                                                                    }

                                                                    $money .= \App\Helpers\Number::money($post->salary_max);

                                                                    if (!empty($salaryType)) {
                                                                        $money .= t('per') . $salaryType->name;
                                                                    }
                                                                }
                                                            } else {
                                                                $money = 'Thương lượng';
                                                            }
                                                            echo $money;
                                                            ?>
                                                        </li>
                                                        <li><i class="fa fa-map-marker"></i>&nbsp;{{ $city->name }}</li>
                                                    </ul>
                                                </div>
                                                <div class="jp_spotlight_slider_btn_wrapper">
                                                    <div class="jp_spotlight_slider_btn">
                                                        <ul>
                                                            <li><a href="{{ lurl($post->uri, $attr) }}" title="{!! $post->title !!}"><i class="fa fa-plus-circle"></i> &nbsp;Chi tiết</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php } ?>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (isset($categoriesOptions) and isset($categoriesOptions['type_of_display']))
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="jp_rightside_job_categories_wrapper">
                                <div class="jp_rightside_job_categories_heading">
                                    <h4>{{ t('Browse by') }} {{ t('Category') }}</h4>
                                </div>
                                <div class="jp_rightside_job_categories_content">
                                    <?php
                                    $listTab = [
                                        'c_circle_list' => 'list-circle',
                                        'c_check_list'  => 'list-check',
                                        'c_border_list' => 'list-border',
                                    ];
                                    $catListClass = (isset($listTab[$categoriesOptions['type_of_display']])) ? 'list ' . $listTab[$categoriesOptions['type_of_display']] : 'list';
                                    ?>
                                    <?php $attr = ['countryCode' => config('country.icode')]; ?>
                                    @if (isset($categories) and $categories->count() > 0)
                                        <ul>
                                            @foreach ($categories as $key => $items)
                                                @foreach ($items as $k => $cat)

                                                    <li> <i class="fa fa-caret-right"></i>
                                                        @if (isset($categoriesOptions['show_icon']) and $categoriesOptions['show_icon'] == 1)
                                                            <i class="{{ $cat->icon_class ?? 'icon-ok' }}"></i>&nbsp;
                                                        @endif
                                                        <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $cat->slug]; ?>
                                                        <a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
                                                            {{ $cat->name }}
                                                        </a>
                                                    </li>

                                                @endforeach
                                            @endforeach
                                            <li><i class="fa fa-plus-circle"></i> <a href="{{ lurl(trans('routes.v-sitemap', $attr), $attr) }}">{{ t('View more') }}</a></li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- jp first sidebar Wrapper End -->

<!-- jp career Wrapper Start -->
<div class="jp_career_main_wrapper">
    <div class="container">

        @include('AAAAAAAA.home.inc.latest-articles')

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="jp_best_deal_slider_main_wrapper">
                    {{--<div class="jp_best_deal_heading_wrapper">--}}
                    {{--<h2>Offering the best Deals</h2>--}}
                    {{--</div>--}}
                    <div class="jp_best_deal_slider_wrapper">
                        <div class="">

                            <div class="">
                                <div class="owl-stage">
                                    <div class="owl-item active">
                                        <div class="item">
                                            <div class="row">

                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="jp_best_deal_main_cont_wrapper">
                                                        <div class="jp_best_deal_icon_sec">
                                                            <i class="flaticon-users"></i>
                                                        </div>
                                                        <div class="jp_best_deal_cont_sec">
                                                            <h4><a href="#">HOTLINE TƯ VẤN DÀNH CHO NHÀ TUYỂN DỤNG</a></h4>
                                                            <p>Tổng đài: <b>(024) 777.80.999</b> (trong giờ hành chính)</p>
                                                            <p>Hotline: <b>0935.780.999 </b>- Mr Biên</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="jp_best_deal_main_cont_wrapper jp_best_deal_main_cont_wrapper1">
                                                        <div class="jp_best_deal_icon_sec">
                                                            <i class="flaticon-magnifying-glass"></i>
                                                        </div>
                                                        <div class="jp_best_deal_cont_sec">
                                                            <h4><a href="#">HOTLINE TƯ VẤN DÀNH CHO NGƯỜI TÌM VIỆC</a></h4>
                                                            <p>Toàn quốc <b>(024) 66 625 256</b></p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jp career Wrapper End -->



@section('modal_location')
    @parent
    @include('layouts.inc.modal.send-by-email')
@endsection

@push('css-stack')

@endpush
@section('after_scripts')
    @parent
        <script>
            $(function () {
                $('.jp_hiring_slider_wrapper .item .jp_hiring_content_wrapper .wrap-matchHeight').matchHeight();
                // $('.jp_tittle_slider_wrapper .jp_tittle_slider_content_wrapper .jp_tittle_slides_one').matchHeight();
                $('.jp_tittle_slider_main_wrapper .match1').matchHeight();

            });
        </script>
@endsection
