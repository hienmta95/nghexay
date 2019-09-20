@extends('layouts.master')

@section('content')
    @include('common.spacer')
    <div class="main-container">
        <div class="container">
            <div class="row">

                @if (isset($errors) and $errors->any())
                    <div class="col-lg-12">
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5>
                                <strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong>
                            </h5>
                            <ul class="list list-check">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (Session::has('flash_notification'))
                    <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('flash::message')
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-6 reg-sidebar">
                    @include('auth.register.register-left')
                </div>
                <div class="col-md-6 page-content">
                    @include('auth.register.register-right')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: #3a7bd5;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #3a6073, #3a7bd5);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #3a6073, #3a7bd5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
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

    <script>
        var userType = '<?php echo old('user_type', request()->get('type')); ?>';

        $(document).ready(function () {
            /* Set user type */
            setUserType(userType);
            $('.user-type').click(function () {
                userType = $(this).val();
                setUserType(userType);
            });

            /* Submit Form */
            $("#signupBtn").click(function () {
                $("#signupForm").submit();
                return false;
            });
        });
    </script>
@endsection
