<div class="job-view-lead-head bg-white py-4 mb-4">

    <div class="container">
        <ol class="breadcrumb mt-20  pull-left">
            <li><a href="{{ lurl('/') }}"><i class="icon-home fa"></i></a></li>
            <li><a href="{{ lurl('/') }}">{{ config('country.name') }}</a></li>
            @if (!empty($post->category->parent))
                <li>
                    <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $post->category->parent->slug]; ?>
                    <a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
                        {{ $post->category->parent->name }}
                    </a>
                </li>
                @if ($post->category->parent->id != $post->category->id)
                    <li>
                        <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $post->category->parent->slug, 'subCatSlug' => $post->category->slug]; ?>
                        <a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}">
                            {{ $post->category->name }}
                        </a>
                    </li>
                @endif
            @else
                <li>
                    <?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $post->category->slug]; ?>
                    <a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}">
                        {{ $post->category->name }}
                    </a>
                </li>
            @endif
            <li class="active">{{ str_limit($post->title, 70) }}</li>
        </ol>
        <div class="row ">
            <div class="col-md-12">
                <div class="inner ads-details-wrapper  mb-20">
                    <div class="row post-heading">
                        <?php /*<div class="col-md-2">
            <div class="heading-logo-thumb mb20">
                @if (isset($post->company) and !empty($post->company))
                    <?php $attr = ['countryCode' => config('country.icode'), 'id' => $post->company->id, 'companySlug' => $post->company->slug]; ?>
                    <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}">
                        <img alt="Logo {{ $post->company_name }}"
                             class="img-responsive"
                             src="{{ resize($post->logo, 'big') }}">
                    </a>
                @else
                    <img alt="Logo {{ $post->company_name }}" class=""
                         src="{{ resize($post->logo, 'big') }}">
                @endif
            </div>
        </div>*/?>
                        <div class="col-md-8">
                            <h1 class="text-dark enable-long-words">
                                <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id, 'companySlug' => $post->company->slug]; ?>
                                {{ $post->title }}
                            </h1>
                            <h3>
                                <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}">
                                    <i class="fa fa-building"></i> {!! $post->company_name  !!}
                                </a>
                            </h3>

                            <div class="ads-action mt-20 mb-20">
                                    <span id="{{ $post->id }}">
                                                @if (auth()->check())
                                            @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() > 0)
                                                    <a class="make-favorite btn btn-success" data-id="{!! $post->id !!}">
                                                        <i class="fa fa-heart"></i> Đã lưu
                                                </a>
                                            @else
                                                <a class="make-favorite btn btn-danger" data-id="{!! $post->id !!}">
                                                        <i class="fa fa-heart-o"></i> Lưu công việc
                                                </a>
                                            @endif
                                        @else
                                            <a class="make-favorite btn btn-success" data-id="{!! $post->id !!}">
                                                    <i class="fa fa-heart-o"></i> {{ t('Save Job') }}
                                            </a>
                                            @endif
                                            </a>
                                        </span>
                                @if (auth()->check())
                                    @if (auth()->user()->id == $post->user_id)
                                        <a class="btn btn-success" href="{{ lurl('posts/'.$post->id.'/edit') }}">
                                            <i class="fa fa-pencil-square-o"></i> {{ t('Edit') }}
                                        </a>
                                    @else
                                        @if ($post->email != '' and in_array(auth()->user()->user_type_id, [2]))
                                            <a class="btn btn-primary"
                                               {!! $applyLinkAttr !!} href="{{ $applyJobURL }}">
                                                <i class="icon-mail-2"></i> {{ t('Apply Online') }}
                                            </a>
                                        @endif
                                    @endif
                                @else
                                    @if ($post->email != '')
                                        <a class="btn btn-primary" {!! $applyLinkAttr !!} href="{{ $applyJobURL }}">
                                            <i class="icon-mail-2"></i> {{ t('Apply Online') }}
                                        </a>
                                    @endif
                                @endif
                                <br/>
                                <div class="clearfix mt-5"></div>
                                @if (isset($post->company) and !empty($post->company))
                                    <span class="mr-5">
                                                <?php $attr = ['countryCode' => config('country.icode'), 'id' => $post->company->id,'companySlug' =>  $post->company->slug]; ?>
                                        <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}">
                                                    <i class="fa icon-town-hall"></i> {{ t('More jobs by :company', ['company' => $post->company->name]) }}
                                                </a>
                                            </span>
                                @endif

                                <?php /*

                                @if (isset($post->user) and !empty($post->user))
                                    <span class="mr-5">
                                                <?php $attr = ['countryCode' => config('country.icode'), 'id' => $post->user->id]; ?>
                                        <a href="{{ lurl(trans('routes.v-search-user', $attr), $attr) }}">
                                                    <i class="fa fa-user"></i> {{ t('More jobs by :user', ['user' => $post->user->name]) }}
                                                </a>
                                            </span>
                                @endif */?>
                                <span class="mr-5">
                                            <a href="{{ lurl('posts/' . $post->id . '/report') }}"
                                               class="">
                                                <i class="fa icon-info-circled-alt"></i> {{ t('Report abuse') }}
                                            </a>
                                        </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="post-info text-left">

                                <li>
                                    <p class="no-margin">
                                        <i class="fa fa-dollar"></i>&nbsp;{{ t('Salary') }}:
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

                                        <?php /*
                                        @if ($post->negotiable == 1)
                                            <small class="label label-success"> {{ t('Negotiable') }}</small>
                                        @endif */?>
                                    </p>
                                </li>
                                @if($post->deadline != '')
                                <li class="date">
                                    <span><i class=" icon-clock"> </i></span> Hạn
                                    nộp: {{ \Carbon\Carbon::parse($post->deadline)->format('d/m/Y') }}
                                </li>
                                @endif
                                {{--<li class="category">{{ (!empty($post->category->parent)) ? $post->category->parent->name : $post->category->name }}</li>--}}

                                <li class="item-location">
                                    <span><i class="fa fa-map-marker"></i> </span> Địa
                                    điểm: {{  $post->city_id != null ? $post->city->name : 'Toàn quốc' }}
                                </li>
                                <li class="category">
                                    <span><i class="icon-eye-3"></i></span>
                                    {{ \App\Helpers\Number::short($post->visits) }} {{ trans_choice('global.count_views', getPlural($post->visits)) }}
                                </li>
                                <li>
                                    <?php
                                    $postType = \App\Models\PostType::findTrans($post->post_type_id);
                                    ?>
                                    @if (!empty($postType))
                                        <p class="no-margin">
                                            <span><i class="fa fa-shopping-bag"></i> </span> {{ t('Job Type') }}:
                                            <?php $attr = ['countryCode' => config('country.icode')]; ?>
                                            <a href="{{ lurl(trans('routes.v-search', $attr), $attr) . '?type[]=' . $post->post_type_id }}">
                                                {{ $postType->name }}
                                            </a>
                                        </p>
                                    @endif
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div> <!--Post heading-->
        </div>
    </div>
</div>


<!--Post heading-->
