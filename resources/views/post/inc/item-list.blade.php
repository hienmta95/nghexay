<?php

// Convert the created_at date to Carbon object
        //dd($post->created_at);
/*$post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
$post->created_at = $post->created_at->ago();*/

//$post->created_at = $post->created_at != null ? \Carbon\Carbon::parse($post->created_at)->format('d-m-Y') : '';
$cats = collect([]);
// Category
$cacheId = 'category.' . $post->category_id . '.' . config('app.locale');
$liveCat = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
    $liveCat = \App\Models\Category::find($post->category_id);
    return $liveCat;
});

// Check parent
if (empty($liveCat->parent_id)) {
    $liveCatParentId = $liveCat->id;
} else {
    $liveCatParentId = $liveCat->parent_id;
}

// Check translation
if ($cats->has($liveCatParentId)) {
    $liveCatName = $cats->get($liveCatParentId)->name;
} else {
    $liveCatName = $liveCat->name;
}

// Get the Post's Type
$cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
$postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
    $postType = \App\Models\PostType::findTrans($post->post_type_id);
    return $postType;
});

// Get the Post's Salary Type
$cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
$salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
    $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
    return $salaryType;
});

// Get the Post's City
$cacheId = config('country.code') . '.city.' . $post->city_id;
$city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
    $city = \App\Models\City::find($post->city_id);
    return $city;
});
?>
<div class="item-list job-item">
    <div class="col-sm-1 col-xs-2 no-padding photobox">
        <div class="add-image">
            <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
            <a href="{{ lurl($post->uri, $attr) }}">
                <img class="thumbnail no-margin"
                     src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}"
                     alt="{{ $post->company_name }}">
            </a>
        </div>
    </div>
    <!--/.photobox-->
    <div class="col-sm-10 col-xs-10 add-desc-box">
        <div class="add-details jobs-item">
            <h4 class="job-title">
                <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                <a href="{{ lurl($post->uri, $attr) }}"> {{ str_limit($post->title, 70) }} </a>
            </h4>
            <h5 class="company-title">
                @if (!empty($post->company_id))
                    <?php
                    $company = \App\Models\Company::where('id',$post->company_id)->first();
                    $attr = ['countryCode' => config('country.icode'), 'companySlug' => ($company != null) ? $company->getSlug() : '']; ?>
                    <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}" title="{{ $post->company_name }}">
                        {{ $post->company_name }}
                    </a>
                @else
                    {{ $post->company_name }}
                @endif
            </h5>
            <span class="info-row">
						<span class="date">
							<i class="icon-clock"> </i>
                            {{ $post->created_at }}
						</span>
						<span class="item-location">
							<i class="fa fa-map-marker"></i>
							<a href="{!! qsurl(trans('routes.v-search', ['countryCode' => config('country.icode')]), array_merge(request()->except(['l', 'location']), ['l'=>$post->city_id])) !!}">
								{{ $city->name }}
							</a>
                            {{ (isset($post->distance)) ? '- ' . round(lengthPrecision($post->distance), 2) . unitOfLength() : '' }}
						</span>
						<span class="post_type">
							<i class="icon-tag"> </i>
                            {{ $postType->name }}
						</span>
						<span class="salary">
							<i class="icon-money"> </i>
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

						</span>
					</span>

            <?php /*<div class="jobs-desc">
						{!! str_limit(strCleaner($post->description), 180) !!}
					</div>*/?>

            <div class="job-actions">
                <ul class="list-unstyled list-inline">
                    @if (auth()->check())
                        @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() <= 0)
                            <li id="{{ $post->id }}">
                                <a class="save-job m-r-5" id="save-{{ $post->id }}" data-id="{{ $post->id }}">
                                    <span class="fa fa-heart-o"></span>
                                    {{ t('Save Job') }}
                                </a>
                            </li>
                        @else
                            <li class="saved-job" id="{{ $post->id }}">
                                <a class="saved-job" id="saved-{{ $post->id }}">
                                    <span class="fa fa-heart"></span>
                                    {{ t('Saved Job') }}
                                </a>
                            </li>
                        @endif
                    @else
                        <li id="{{ $post->id }}">
                            <a class="save-job" id="save-{{ $post->id }}">
                                <span class="fa fa-heart-o"></span>
                                {{ t('Save Job') }}
                            </a>
                        </li>
                    @endif

                </ul>
            </div>

        </div>
    </div>
    <!--/.add-desc-box-->

    <!--/.add-desc-box-->
</div>