@extends('layouts.account')

@section('content')


    <div class="inner-box">
        <h2 class="title-2"><i class="icon-attach"></i> {{ t('Edit the resume') }} </h2>

        <div class="mb30" style="float: right; padding-right: 5px;">
            <a href="{{ lurl('account/resumes') }}">{{ t('My resumes') }}</a>
        </div>
        <div style="clear: both;"></div>

        <div class="panel-group" id="accordion">

            <!-- RESUME -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#resumePanel" data-toggle="collapse"
                                               data-parent="#accordion"> {{ t('Resume') }} </a></h4>
                </div>
                <div class="panel-collapse collapse in" id="resumePanel">
                    <div class="panel-body">
                        <form name="resume" class="form-horizontal" role="form" method="POST"
                              action="{{ lurl('account/resumes/' . $resume->id) }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="PUT">
                            <input name="panel" type="hidden" value="resumePanel">
                            <input name="resume_id" type="hidden" value="{{ $resume->id }}">

                            @include('account.resume._form')

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
