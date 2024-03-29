@extends('layouts.account')

@section('content')
    <div class="page-content">
        @if (Session::has('flash_notification'))
            <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
                <div class="row">
                    <div class="col-lg-12">
                        @include('flash::message')
                    </div>
                </div>
            </div>
        @endif
        <div class="inner-box">
            <h2 class="title-2">
                <i class="icon-mail"></i> Tin nhắn ứng tuyển
            </h2>
            <div id="reloadBtn" class="mb30" style="display: none;">
                <a href="" class="btn btn-primary" class="tooltipHere" title=""
                   data-placement="{{ (config('lang.direction')=='rtl') ? 'left' : 'right' }}"
                   data-toggle="tooltip"
                   data-original-title="{{ t('Reload to see New Messages') }}"><i
                            class="icon-arrows-cw"></i> {{ t('Reload') }}</a>
                <br><br>
            </div>

            <div style="clear:both"></div>

            <div class="table-responsive">
                <form name="listForm" method="POST" action="{{ lurl('account/'.$pagePath.'/delete') }}">
                    {!! csrf_field() !!}
                    <div class="table-action">
                        <label for="checkAll">
                            <input type="checkbox" id="checkAll">
                            {{ t('Select') }}: {{ t('All') }} |
                            <button type="submit" class="btn btn-sm btn-default delete-action">
                                <i class="fa fa-trash"></i> {{ t('Delete') }}
                            </button>
                        </label>
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
                            <th style="width:2%" data-type="numeric" data-sort-initial="true"></th>
                            <th style="width:88%" data-sort-ignore="true">{{ t('Conversations') }}</th>
                            <th style="width:10%">{{ t('Option') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($conversations) && $conversations->count() > 0):
                        foreach($conversations as $key => $conversation):
                        ?>
                        <tr>
                            <td class="add-img-selector">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="entries[]"
                                                  value="{{ $conversation->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <div style="word-break:break-all;">
                                    <strong>{{ t('Received at') }}:</strong>
                                    {{ $conversation->created_at->formatLocalized(config('settings.app.default_datetime_format')) }}
                                    @if (\App\Models\Message::conversationHasNewMessages($conversation))
                                        <i class="icon-flag text-primary"></i>
                                    @endif
                                    <br>
                                    <strong>{{ t('Subject') }}:</strong>&nbsp;{{ $conversation->subject }}<br>
                                    <strong>{{ t('Created by') }}
                                        :</strong>&nbsp;{{ str_limit($conversation->from_name, 50) }}
                                    {!! (!empty($conversation->filename) and \Storage::exists($conversation->filename)) ? ' <i class="icon-attach-2"></i> ' : '' !!}
                                    &nbsp;|&nbsp;
                                    <a href="{{ lurl('account/conversations/' . $conversation->id . '/messages') }}">
                                        {{ t('Click here to read the messages') }}
                                    </a>
                                </div>
                            </td>
                            <td class="action-td">
                                <div>
                                    <p>
                                        <a class="btn btn-default btn-sm"
                                           href="{{ lurl('account/conversations/' . $conversation->id . '/messages') }}">
                                            <i class="icon-eye"></i> {{ t('View') }}
                                        </a>
                                        <a class="btn btn-danger btn-sm delete-action"
                                           href="{{ lurl('account/conversations/' . $conversation->id . '/delete') }}">
                                            <i class="fa fa-trash"></i> {{ t('Delete') }}
                                        </a>
                                    </p>
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
                {{ (isset($conversations)) ? $conversations->links() : '' }}
            </div>

            <div style="clear:both"></div>

        </div>
    </div>
    <!--/.page-content-->


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
