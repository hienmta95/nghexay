@extends('layouts.account')

@section('content')

    <ol class="breadcrumb">
        <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Tin tuyển dụng</li>
    </ol>

    <div class="inner-box">
        <h2 class="title-2">
            @if ($pagePath=='my-posts')
                <i class="icon-docs"></i> Tin đã đăng
            @elseif ($pagePath=='archived')
                <i class="icon-folder-close"></i> {{ t('Archived ads') }}
            @elseif ($pagePath=='suitable')
                <i class="icon-briefcase"></i> {{ t('Suitable jobs') }}
            @elseif ($pagePath=='favourite')
                <i class="icon-heart-1"></i> {{ t('Favourite jobs') }}
            @elseif ($pagePath=='pending-approval')
                <i class="icon-hourglass"></i> {{ t('Pending approval') }}
            @else
                <i class="icon-docs"></i> {{ t('Posts') }}
            @endif

            @if (in_array($user->user_type_id, [1]))
                <div class="pull-right small">
                    <a{!! ($pagePath=='my-posts') ? ' class="active"' : '' !!} href="{{ lurl('account/my-posts') }}
                    ">
                    <i class="icon-docs"></i> Tin đã đăng
                    <span class="badge">
											{{ isset($countMyPosts) ? \App\Helpers\Number::short($countMyPosts) : 0 }}
										</span>
                    </a>
                    <a{!! ($pagePath=='pending-approval') ? ' class="active"' : '' !!} href="{{ lurl('account/pending-approval') }}
                    ">
                    <i class="icon-hourglass"></i> {{ t('Pending approval') }}&nbsp;
                    <span class="badge">
											{{ isset($countPendingPosts) ? \App\Helpers\Number::short($countPendingPosts) : 0 }}
										</span>
                    </a>

                    <a{!! ($pagePath=='archived') ? ' class="active"' : '' !!} href="{{ lurl('account/archived') }}
                    ">
                    <i class="icon-folder-close"></i> {{ t('Archived ads') }}&nbsp;
                    <span class="badge">
											{{ isset($countArchivedPosts) ? \App\Helpers\Number::short($countArchivedPosts) : 0 }}
										</span>
                    </a>
                </div>
            @endif
        </h2>

        <div class="table-responsive">
            <form name="listForm" method="POST" action="{{ lurl('account/'.$pagePath.'/delete') }}">
                {!! csrf_field() !!}
                <div class="table-action">
                    @if (in_array($user->user_type_id, [1]))
                    <label for="checkAll">
                        <input type="checkbox" id="checkAll">
                        {{ t('Select') }}: {{ t('All') }} |
                        <button type="submit" class="btn btn-sm btn-default delete-action">
                            <i class="fa fa-trash"></i> {{ t('Delete') }}
                        </button>
                    </label>
                    @endif
                    <div class="table-search pull-right col-xs-7">
                        <div class="form-group">
                            <label class="col-xs-5 control-label text-right">{{ t('Search') }} <br>
                                <a title="clear filter" class="clear-filter" href="#clear">[{{ t('clear') }}]</a>
                            </label>
                            <div class="col-xs-7 searchpan">
                                <input type="text" class="form-control" id="filter">
                            </div>
                        </div>
                    </div>
                </div>
                <table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo"
                       data-filter="#filter" data-filter-text-only="true">
                    <thead>
                    <tr>
                        <th data-type="numeric" data-sort-initial="true"></th>
                        <th> {{ t('Photo') }}</th>
                        <th data-sort-ignore="true"> {{ t('Ads Details') }} </th>
                        <th data-type="numeric" class="text-center"> Lương</th>
                        <th data-type="numeric" class="text-center"> Tổng lượt xem</th>
                        <th data-type="numeric" class="text-center"> UV xem</th>
                        <th style="width: 200px"> {{ t('Option') }}</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if (isset($posts) && $posts->count() > 0):
                    foreach($posts as $key => $post):
                    // Fixed 1
                    if ($pagePath == 'favourite') {
                        if (isset($post->post)) {
                            if (!empty($post->post)) {
                                $post = $post->post;
                            } else {
                                continue;
                            }
                        } else {
                            continue;
                        }
                    }

                    // Fixed 2
                    if (!$countries->has($post->country_code)) continue;

                    // Get Post's URL
                    $attr = ['slug' => slugify($post->title), 'id' => $post->id];
                    $postUrl = lurl($post->uri, $attr);
                    if (in_array($pagePath, ['pending-approval', 'archived'])) {
                        $postUrl = $postUrl . '?preview=1';
                    }

                    // Get country flag
                    $countryFlagPath = 'images/flags/16/' . strtolower($post->country_code) . '.png';
                    ?>
                    <tr>
                        <td style="width:2%" class="add-img-selector">
                            <div class="checkbox">
                                <label><input type="checkbox" name="entries[]" value="{{ $post->id }}"></label>
                            </div>
                        </td>
                        <td style="width:14%" class="add-img-td">
                            <a href="{{ $postUrl }}">
                                <img class="thumbnail img-responsive"
                                     src="{{ resize(\App\Models\Post::getLogo($post->logo), 'medium') }}" alt="img">
                            </a>
                        </td>
                        <td style="width:40%" class="ads-details-td">
                            <div>
                                <p>
                                    <strong>
                                        <a href="{{ $postUrl }}"
                                           title="{{ $post->title }}">{{ str_limit($post->title, 40) }}</a>
                                    </strong>
                                    @if (in_array($pagePath, ['my-posts', 'archived', 'pending-approval']))
                                        @if (isset($post->latestPayment) and !empty($post->latestPayment))
                                            @if (isset($post->latestPayment->package) and !empty($post->latestPayment->package))
                                                <?php
                                                if ($post->featured == 1) {
                                                    $color = $post->latestPayment->package->ribbon;
                                                    $packageInfo = '';
                                                } else {
                                                    $color = '#ddd';
                                                    $packageInfo = ' (' . t('Expired') . ')';
                                                }
                                                ?>
                                                <i class="fa fa-check-circle tooltipHere" style="color: {{ $color }};"
                                                   title="" data-placement="bottom"
                                                   data-toggle="tooltip"
                                                   data-original-title="{{ $post->latestPayment->package->short_name . $packageInfo }}"></i>
                                            @endif
                                        @endif
                                    @endif
                                </p>
                                <p>
                                    <strong><i class="icon-clock" title="{{ t('Posted On') }}"></i></strong>&nbsp;
                                    {{ $post->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}
                                </p>
                                <p>
                                    <strong><i class="fa fa-map-marker"
                                               title="{{ t('Located In') }}"></i></strong> {{ !empty($post->city) ? $post->city->name : '-' }}
                                    @if (file_exists(public_path($countryFlagPath)))
                                        <img src="{{ url($countryFlagPath) }}" data-toggle="tooltip"
                                             title="{{ $post->country_code }}">
                                    @endif
                                </p>
                            </div>
                        </td>

                        <td style="width:16%" class="price-td">
                            <div>
                                @if ($post->salary_min > 0)
                                    {!! \App\Helpers\Number::money($post->salary_min) !!}
                                @else
                                    {!! \App\Helpers\Number::money(' --') !!}
                                @endif
                            </div>
                        </td>
                        <td style="width:10%" class="text-center">
                            <div>
                                {!! number_format($post->visits) !!}
                            </div>
                        </td>
                        <td style="width:10%" class="text-center">
                            <div>
                                {!! number_format($post->member_visits) !!}
                            </div>
                        </td>
                        <td style="width: 20%" class="action-td">
                            <div class="btn-groupx" role="group">
                                @if ($post->user_id==$user->id and $post->archived==0)

                                    <a class="btn btn-primary btn-sm" title=" {{ t('Edit') }}"
                                       href="{{ lurl('posts/' . $post->id . '/edit') }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endif
                                @if (isVerifiedPost($post) and $post->archived==0)
                                <!--<p>
														<a class="btn btn-info btn-sm"> <i class="fa fa-mail-forward"></i> {{ t('Share') }} </a>
													</p>-->
                                @endif
                                @if ($post->user_id==$user->id and $post->archived==1)
                                    <a class="btn btn-info btn-sm" title="{{ t('Repost') }}"
                                       data-title="{{ t('Repost') }}"
                                       href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/repost') }}">
                                        <i class="fa fa-recycle"></i>
                                    </a>
                                @endif
                                <a class="btn btn-danger btn-sm delete-action" title=" {{ t('Delete') }}"
                                   data-tooltip=" {{ t('Delete') }}"
                                   href="{{ lurl('account/'.$pagePath.'/'.$post->id.'/delete') }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </form>
        </div>

        <div class="pagination-bar text-center">
            {{ (isset($posts)) ? $posts->links() : '' }}
        </div>

    </div>

@endsection

@section('after_scripts')
    <script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#addManageTable').footable().bind('footable_filtering', function (e) {
                var selected = $('.filter-status').find(':selected').text();
                if (selected && selected.length > 0) {
                    e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                    e.clear = !e.filter;
                }
            });

            $('.clear-filter').click(function (e) {
                e.preventDefault();
                $('.filter-status').val('');
                $('table.demo').trigger('footable_clear_filter');
            });

            $('#checkAll').click(function () {
                checkAll(this);
            });

            $('a.delete-action, button.delete-action').click(function (e) {
                e.preventDefault();
                /* prevents the submit or reload */
                var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");

                if (confirmation) {
                    if ($(this).is('a')) {
                        var url = $(this).attr('href');
                        if (url !== 'undefined') {
                            redirect(url);
                        }
                    } else {
                        $('form[name=listForm]').submit();
                    }

                }

                return false;
            });
        });
    </script>
    <!-- include custom script for ads table [select all checkbox]  -->
    <script>
        function checkAll(bx) {
            var chkinput = document.getElementsByTagName('input');
            for (var i = 0; i < chkinput.length; i++) {
                if (chkinput[i].type == 'checkbox') {
                    chkinput[i].checked = bx.checked;
                }
            }
        }
    </script>
@endsection
