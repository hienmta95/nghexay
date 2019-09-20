@extends('layouts.account')

@section('content')

    <ol class="breadcrumb">
        <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Việc làm phù hợp</li>
    </ol>

    <div class="inner-box">
        <h2 class="title-2">
            Việc làm phù hợp
        </h2>
        <?php
        if (isset($posts) && $posts->count() > 0):
        ?>
        <div class="table-responsive">
            <table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo"
                   data-filter="#filter" data-filter-text-only="true">
                <thead>
                <tr>
                    <th data-sort-ignore="true"> Vị trí - công ty </th>
                    <th data-sort-ignore="true"> Địa điểm làm việc </th>
                    <th data-type="numeric" class="text-center"> Lương</th>
                    <th style="width: 200px">Hạn nộp</th>
                </tr>
                </thead>
                <tbody>

                <?php

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

                    <td style="width:40%" class="ads-details-td">
                        <div>
                            <p>
                                <strong>
                                    <a href="{{ $postUrl }}"
                                       title="{{ $post->title }}">{{ str_limit($post->title, 60) }}</a>
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
                    <td class="text-center">
                        {!! $post->city->name !!}
                    </td>

                    <td style="width:16%" class="text-center">
                        <div>
                            @if ($post->salary_min > 0)
                                {!! \App\Helpers\Number::money($post->salary_min) !!}
                            @else
                                {!! \App\Helpers\Number::money(' --') !!}
                            @endif
                        </div>
                    </td>
                    <td style="width: 20%" class="text-center">
                            {!! \Carbon\Carbon::parse($post->deadline)->format('d/m/Y') !!}
                    </td>
                </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>

        <div class="pagination-bar text-center">
            {{ (isset($posts)) ? $posts->links() : '' }}
        </div>
        @else
            <div class="alert alert-info">
                Bạn vui lòng cập nhật hồ sơ cá nhân để biết được việc làm phù hợp với bạn nhất
            </div>

        <?php endif; ?>
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
        });
    </script>
    <!-- include custom script for ads table [select all checkbox]  -->

@endsection
