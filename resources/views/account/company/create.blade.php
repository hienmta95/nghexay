@extends('layouts.account')

@section('content')

    <ol class="breadcrumb">
        <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Doanh nghiệp của bạn</li>
    </ol>
    <div class="inner-box">
        <h2 class="title-2"><i class="icon-town-hall"></i> {{ t('Create a new company') }} </h2>

        <div class="mb30" style="float: right; padding-right: 5px;">
            <a href="{{ lurl('account/companies') }}">{{ t('My companies') }}</a>
        </div>
        <div style="clear: both;"></div>

        <div class="panel-group" id="accordion">

            <!-- COMPANY -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#companyPanel" data-toggle="collapse"
                                               data-parent="#accordion"> {{ t('Company Information') }} </a></h4>
                </div>
                <div class="panel-collapse collapse in" id="companyPanel">
                    <div class="panel-body">
                        <form name="company" class="form-horizontal" role="form" method="POST"
                              action="{{ lurl('account/companies') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input name="panel" type="hidden" value="companyPanel">

                            @include('account.company._form',['originForm'=>'create'])

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9"></div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-primary">{{ t('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!--/.row-box End-->

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
