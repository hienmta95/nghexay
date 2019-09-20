@extends('layouts.account')

@section('content')

    <ol class="breadcrumb">
        <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Doanh nghiệp của bạn</li>
    </ol>
    <div class="inner-box">
        <h2 class="title-2"><i class="icon-town-hall"></i> {{ t('Edit the Company') }} </h2>

        <div class="mb30" style="float: right; padding-right: 5px;">
            <a href="{{ lurl('account/companies') }}">{{ t('My companies') }}</a>
        </div>
        <div style="clear: both;"></div>


        <form name="company" class="form-horizontal" role="form" method="POST"
              action="{{ lurl('account/companies/' . $company->id) }}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input name="_method" type="hidden" value="PUT">
            <input name="panel" type="hidden" value="companyPanel">
            <input name="company_id" type="hidden" value="{{ $company->id }}">

            @include('account.company._form',['originForm'=>'update'])

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9"></div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
                </div>
            </div>
        </form>


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
