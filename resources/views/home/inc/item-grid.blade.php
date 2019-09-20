<div class="item-grid job-item ">
    <div class="row">
        <div class="col-sm-3 col-xs-2 no-padding photobox">
            <div class="add-image">
                <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                <a href="{{ lurl($post->uri, $attr) }}" title="{!! $post->title !!}" target="_blank">
                    <img alt="{{ $post->company_name }}"
                         src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}"
                         class="thumbnail no-margin">
                </a>
            </div>
        </div>
        <!--/.photobox-->
        <div class="col-sm-9 col-xs-10  add-desc-box">
            <div class="add-details jobs-item">
                <h5 class="job-title">
                    <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                    <a href="{{ lurl($post->uri, $attr) }}" title="{!! $post->title !!}" class="text-dark">
                        {{ ucfirst(str_limit($post->title,30)) }}
                    </a>
                </h5>
                <div class="company-title ">
                    @if (!empty($post->company_id))

                        <?php $attr = ['countryCode' => config('country.icode'), 'id' => $post->company_id,'companySlug'=> str_slug($post->company_name)]; ?>
                        <a class="text-gray" href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}">
                            {{ ucfirst(str_limit($post->company_name,30)) }}
                        </a>
                    @else
                        {{ ucfirst(str_limit($post->company_name,30)) }}
                    @endif
                </div>

                <span class="info-row ">
                     @if (!empty($post->city_name))
                        <span class="date">  <i class="icon-location"> </i>
                            {{ $post->city_name }}
                                            </span>

                    @endif</br>
                    <span class="salary">
                                                <i class="icon-money"> </i>
                       <?php
                        $money = '';
                        if ($post->salary_min > 0 or $post->salary_max > 0) {
                            if($post->salary_min > 0){
                                $money .= \App\Helpers\Number::money($post->salary_min);
                            }
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
                    <?php /*
 <span class="date">
                                                <i class="icon-clock"> </i>
     {{ \Carbon\Carbon::parse($post->deadline)->format('d/m/Y') }}
                                            </span>
 <span class="date">
                                                <i class="icon-clock"> </i>
                                                {{ $post->created_at }}
                                            </span>
 <span class="item-location">
                                                <i class="fa fa-map-marker"></i>
                                                {{ $city->name }}
                                            </span>
                                            <span class="date">
                                                <i class="icon-clock"> </i>
                                                {{ $postType->name }}
                                            </span>*/?>

                                        </span>

                <?php /*<div class="jobs-desc">
                    {!! str_limit(strCleaner($post->description), 180) !!}
                </div>

               <div class="job-actions">
                    <ul class="list-unstyled list-inline">
                        @if (auth()->check())
                            @if (\App\Models\SavedPost::where('user_id', auth()->user()->id)->where('post_id', $post->id)->count() <= 0)
                                <li id="{{ $post->id }}">
                                    <a class="save-job" id="save-{{ $post->id }}">
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
                        <li>
                            <a class="email-job" data-toggle="modal" data-id="{{ $post->id }}" href="#sendByEmail"
                               id="email-{{ $post->id }}">
                                <i class="fa fa-envelope"></i>
                                {{ t('Email Job') }}
                            </a>
                        </li>
                    </ul>
                </div> */?>

            </div>
        </div>
        <!--/.add-desc-box-->

        <!--/.add-desc-box-->
    </div>
</div>
