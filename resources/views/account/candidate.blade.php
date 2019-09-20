@extends('layouts.account')

@section('content')

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
    <div class="col-md-12">
        <div class="alert alert-warning">
            Bạn vui lòng hoàn thiện hồ sơ để nhà tuyển dụng có thể liên hệ với bạn
        </div>
    </div>
    <?php /*<div class="col-md-12">
        <div class="inner-box m-b-20" style="margin-bottom: 20px">
            <div class="row">

                <div class="col-md-5 col-xs-4 col-xxs-12">
                    <h3 class="no-padding text-center-480 useradmin">
                        <a href="">
                            <img class="userImg" src="{{ $user->getAvatar() }}" alt="user">&nbsp;
                            {{ $user->name }}
                        </a>
                    </h3>
                </div>

                <div class="col-md-7 col-xs-8 col-xxs-12">
                    <div class="header-data text-center-xs">
                    @if (isset($user) and in_array($user->user_type_id, [1]))
                        <!-- Traffic data -->
                            <div class="hdata">
                                <div class="mcol-left">
                                    <!-- Icon with red background -->
                                    <i class="fa fa-eye ln-shadow"></i>
                                </div>
                                <div class="mcol-right">
                                    <!-- Number of visitors -->
                                    <p>
                                        <a href="{{ lurl('account/my-posts') }}">
                                            <?php $totalPostsVisits = (isset($countPostsVisits) and $countPostsVisits->total_visits) ? $countPostsVisits->total_visits : 0 ?>
                                            {{ \App\Helpers\Number::short($totalPostsVisits) }}
                                            <em>{{ trans_choice('global.count_visits', getPlural($totalPostsVisits)) }}</em>
                                        </a>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <!-- Ads data -->
                            <div class="hdata">
                                <div class="mcol-left">
                                    <!-- Icon with green background -->
                                    <i class="icon-th-thumb ln-shadow"></i>
                                </div>
                                <div class="mcol-right">
                                    <!-- Number of ads -->
                                    <p>
                                        <a href="{{ lurl('account/my-posts') }}">
                                            {{ \App\Helpers\Number::short($countPosts) }}
                                            <em>{{ trans_choice('global.count_posts', getPlural($countPosts)) }}</em>
                                        </a>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                    @endif

                    @if (isset($user) and in_array($user->user_type_id, [2]))
                        <!-- Favorites data -->
                            <div class="hdata">
                                <div class="mcol-left">
                                    <!-- Icon with blue background -->
                                    <i class="fa fa-user ln-shadow"></i>
                                </div>
                                <div class="mcol-right">
                                    <!-- Number of favorites -->
                                    <p>
                                        <a href="{{ lurl('account/favourite') }}">
                                            {{ \App\Helpers\Number::short($countFavoritePosts) }}
                                            <em>{{ trans_choice('global.count_favorites', getPlural($countFavoritePosts)) }} </em>
                                        </a>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>*/?>
    <div class="col-md-3">
        <ul id="sticky" class="nav nav-pills nav-stacked">
            <li role="presentation" class="active"><a href="#step-1">Thông tin cá nhân</a></li>
            <li role="presentation"><a href="#step-2">Học vấn</a></li>
            <li role="presentation"><a href="#step-3">Kỹ năng</a></li>
            <li role="presentation"><a href="#step-4">Kinh nghiệm</a></li>
            <li role="presentation"><a href="#step-5">Nguyện vọng</a></li>
            <li role="presentation"><a href="#accordion">Mật khẩu</a></li>
        </ul>
    </div>
    <div class="col-md-9">

        @include('account.inc.step-1')
        @include('account.inc.step-2')
        @include('account.inc.step-3')
        @include('account.inc.step-4')
        @include('account.inc.step-5')

        <div class="panel-group" id="accordion">

            <!-- SETTINGS -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        {{ t('Settings') }}
                    </h4>
                </div>

                <div class="panel-body">
                    <form name="settings" class="form-horizontal" role="form" method="POST" id="passwordForm"
                          action="{{ lurl('account/settings') }}">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="PUT">
                        <input name="panel" type="hidden" value="settingsPanel">
                        <!-- password -->
                        <div class="form-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
                            <label class="col-sm-3 control-label">{{ t('New Password') }}</label>
                            <div class="col-sm-9">
                                <input id="password" name="password" type="password" class="form-control"
                                       placeholder="{{ t('Password') }}">
                            </div>
                        </div>

                        <!-- password_confirmation -->
                        <div class="form-group <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
                            <label class="col-sm-3 control-label">{{ t('Confirm Password') }}</label>
                            <div class="col-sm-9">
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                       class="form-control" placeholder="{{ t('Confirm Password') }}">
                            </div>
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
        <!--/.row-box End-->

    </div>



@endsection

@section('after_styles')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css"/>

    <link rel="stylesheet" href="{!! url('/js/tagmanager/tagmanager.css') !!}"/>
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }

        #avatar-holder {
            width: 200px;
            height: 200px;
            position: relative;
            margin: 0 auto;
        }
        .note-editor {
            border:1px solid #E6E6E6;
            padding: 15px;
        }
        .remove-profile-entry .fa, .edit-profile-entry .fa {
            font-size: 12px;
            margin-left: 5px;
        }
    </style>
@endsection

@section('after_scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.12/handlebars.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/eModal/1.2.67/eModal.min.js"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ url('/js/jquery.form.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/jquery.sticky.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/tagmanager/tagmanager.js') }}" type="text/javascript"></script>
    <script src="{{ url('/js/tagmanager/typeahead.bundle.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
        <script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}"
                type="text/javascript"></script>
    @endif
    <script src="/js/simpleUpload.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajaxPrefilter(function(options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });

            $('textarea').each(function(){
                $(this).summernote({
                    airMode: true,
                    height:200,
                    placeholder: $(this).attr('placeholder')
                });
            });
            $('input#avatar').change(function () {
                $(this).simpleUpload("/ajax/account/upload-avatar", {
                    start: function (file) {
                    },
                    progress: function (progress) {
                    },
                    success: function (data) {
                        if (data.success) {
                            $('#avatar-holder').html('<img src="' + data.url + '" class="img-responsive img-thumbnail"/> ');
                        } else {
                            toastr.error(data.msg.file[0]);
                        }

                    },
                    error: function (error) {
                        toastr.error(+error.name + ": " + error.message);
                    }

                });

            });
            $('#sticky a').click(function (e) {
                e.preventDefault();
                $('#sticky a').parent().removeClass('active');
                $(this).parent().addClass('active');
            });
            $('a[href*="#"]')
            // Remove links that don't actually link to anything
                .not('[href="#"]')
                .not('[href="#0"]')
                .click(function (event) {
                    // On-page links
                    if (
                        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                        &&
                        location.hostname == this.hostname
                    ) {
                        // Figure out element to scroll to
                        var target = $(this.hash);
                        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                        // Does a scroll target exist?
                        if (target.length) {
                            // Only prevent default if animation is actually gonna happen
                            event.preventDefault();
                            $('html, body').animate({
                                scrollTop: target.offset().top - 100
                            }, 500, function () {
                                // Callback after animation
                                // Must change focus!
                                var $target = $(target);
                                $target.focus();
                                if ($target.is(":focus")) { // Checking if the target was focused
                                    return false;
                                } else {
                                    $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                                    $target.focus(); // Set focus again
                                }
                                ;
                            });
                        }
                    }
                });


            $("#sticky").sticky({topSpacing: 80});
            $('#infoForm').ajaxForm({
                success: function (res) {
                    console.log(res);
                    if(res.success == true){
                        toastr.success('Thông tin đã được cập nhật');
                    }else{
                        var msg = '';
                        $.each(res.data,function (k,v) {
                            msg = v;
                            toastr.error(msg);
                        });


                    }
                },
                error: function(jqXhr, json, errorThrown){// this are default for ajax errors
                    var errors = jqXhr.responseJSON;
                    var errorsHtml = '';
                    console.log(errors);
                    $.each(errors.data, function (index, value) {
                        toastr.error(value[0]);
                    });

                }
            });

            $(document).on('click', '.remove-profile-entry', function (e) {
                e.preventDefault();
                var $this = $(this), $method = $this.data('method'), $index = $this.data('index'),
                    $type = $this.data('type');
                $.ajax({
                    url: '{!! route('account.update-profile') !!}',
                    method: 'PUT',
                    data: {profile: null, method: $method, type: $type, index: $index},
                    success: function (res) {
                        if (res.success) {
                            $this.parent().remove();
                        } else {
                            toastr.error('Có lỗi xảy ra, bạn vui lòng thử lại');
                        }
                    },
                    error: function () {
                        toastr.error('Có lỗi xảy ra, bạn vui lòng thử lại');
                    }
                });

            });
            $(document).on('click', '.edit-profile-entry', function (e) {
                e.preventDefault();
                var $this = $(this), $method = $this.data('method'), $index = $this.data('index'),
                    $type = $this.data('type');

                var options = {
                    url: "{!! route('account.update-profile-item') !!}?type="+$type+"&index="+$index,
                    title:'Cập nhật thông tin',
                    size: eModal.size.md,
                    buttons: [],
                    callback:function(){

                    }
                };

                eModal.ajax(options).then(function(){

                    },function(){

                    });
                });

        });
    </script>
@endsection
