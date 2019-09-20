@extends('layouts.account')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
    </ol>
    @include('flash::message')

    @if (isset($errors) and $errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
            <ul class="list list-check">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        @if (isset($user) and in_array($user->user_type_id, [1]))
            <div class="col-md-3">
                <a href="{{ lurl('account/my-posts') }}">
                    <div class="content-top-1 bg-green text-white">
                        <div class="col-md-12 top-content">

                            <?php $totalPostsVisits = (isset($countPostsVisits) and $countPostsVisits->total_visits) ? $countPostsVisits->total_visits : 0 ?>
                            <h5 class="text-white">Lượt xem hồ sơ</h5>
                            <label>   {{ \App\Helpers\Number::short($totalPostsVisits) }}</label>

                        </div>
                        <div class="col-md-12 top-content1">
                            <div id="demo-pie-1" class="pie-title-center" data-percent="25"><span
                                        class="pie-value"></span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <div class="content-top-1 bg-blue">
                    <a href="{{ lurl('account/my-posts') }}" class="text-white">
                        <div class="col-md-12 top-content ">

                            <h5 class="text-white">
                                Tin tuyển dụng
                            </h5>
                            <label class="text-white">
                                {{ \App\Helpers\Number::short($countPosts) }}
                            </label>

                        </div>

                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-top-1 bg-yellow">
                    <a href="{{ lurl('account/pending-approval') }}" class="text-white">
                        <div class="col-md-12 top-content">
                            <h5>
                                Chờ duyệt
                            </h5>
                            <label>
                                {{ \App\Helpers\Number::short($countPosts) }}
                            </label>

                        </div>

                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="content-top-1 bg-red">
                    <a href="{{ lurl('account/pending-approval') }}" class="text-white">
                        <div class="col-md-12 top-content">
                            <h5>
                                Tin nhắn ứng tuyển
                            </h5>
                            <label>
                                {{ isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0 }}
                            </label>
                        </div>

                        <div class="clearfix"></div>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            @include('account.dashboard.inc.latest-post')
        </div>
        <div class="col-md-6">
            @include('account.dashboard.inc.paid-candidate')
        </div>

    </div>

    <div class="row mt-30">
        <div class="col-md-6">
            @include('account.dashboard.inc.latest-transactions')
        </div>
        <div class="col-md-6">
            @include('account.dashboard.inc.latest-candidates')
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row mt-30">
        <div class="col-md-12">
            @include('account.dashboard.inc.stats')
        </div>
    </div>



@endsection

@section('after_styles')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">

    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
        <script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}"
                type="text/javascript"></script>
    @endif
@endsection
