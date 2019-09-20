@extends('layouts.account')

@section('content')

    @include('flash::message')


    <div class="inner-box">
        <div class="panel-group" id="accordion">
            <!-- USER -->
            <div class="panelx panel-defaultx">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#userPanel" data-toggle="collapse"
                                               data-parent="#accordion"> {{ t('My details') }} </a></h4>
                </div>
                <div class="panel-collapse collapse {{ (old('panel')=='' or old('panel')=='userPanel') ? 'in' : '' }}"
                     id="userPanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form name="details" class="form-horizontal" role="form" method="POST"
                                      action="{{ url()->current() }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <input name="_method" type="hidden" value="PUT">
                                    <input name="panel" type="hidden" value="userPanel">

                                    @if (empty($user->user_type_id) or $user->user_type_id == 0)

                                    <!-- user_type_id -->
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('user_type_id')) ? 'has-error' : ''; ?>">
                                            <label class="col-sm-3 control-label">{{ t('You are a') }}
                                                <sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <select name="user_type_id" id="userTypeId"
                                                        class="form-control selecter">
                                                    <option value="0"
                                                            @if (old('user_type_id')=='' or old('user_type_id')==0)
                                                            selected="selected"
                                                            @endif
                                                    >
                                                        {{ t('Select') }}
                                                    </option>
                                                    @foreach ($userTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                                @if (old('user_type_id', $user->user_type_id)==$type->id)
                                                                selected="selected"
                                                                @endif
                                                        >
                                                            {{ t($type->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    @else

                                    <!-- gender_id -->
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('gender_id')) ? 'has-error' : ''; ?>">
                                            <label class="col-md-3 control-label">{{ t('Gender') }} <sup>*</sup></label>
                                            <div class="col-md-9">
                                                @if ($genders->count() > 0)
                                                    @foreach ($genders as $gender)
                                                        <label class="radio-inline" for="gender_id">
                                                            <input name="gender_id" id="gender_id-{{ $gender->tid }}"
                                                                   value="{{ $gender->tid }}"
                                                                   type="radio" {{ (old('gender_id', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }}>
                                                            {{ $gender->name }}
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- name -->
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                                            <label class="col-sm-3 control-label">{{ t('Name') }} <sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input name="name" type="text" class="form-control" placeholder=""
                                                       value="{{ old('name', $user->name) }}">
                                            </div>
                                        </div>

                                        <!-- username -->
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('username')) ? 'has-error' : ''; ?>">
                                            <label class="col-sm-3 control-label" for="email">{{ t('Username') }}
                                                <sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input id="username" name="username" type="text" class="form-control"
                                                       placeholder="{{ t('Username') }}"
                                                       value="{{ old('username', $user->username) }}">
                                            </div>
                                        </div>

                                        <!-- email -->
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                            <label class="col-sm-3 control-label">{{ t('Email') }} <sup>*</sup></label>
                                            <div class="col-sm-9">
                                                <input id="email" name="email" type="email" class="form-control"
                                                       placeholder="{{ t('Email') }}"
                                                       value="{{ old('email', $user->email) }}">
                                            </div>
                                        </div>

                                        <!-- country_code -->
                                        <?php
                                        /*
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('country_code')) ? 'has-error' : ''; ?>">
                                            <label class="col-md-3 control-label" for="country_code">{{ t('Your Country') }} <sup>*</sup></label>
                                            <div class="col-md-9">
                                                <select name="country_code" class="form-control">
                                                    <option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>
                                                        {{ t('Select a country') }}
                                                    </option>
                                                    @foreach ($countries as $item)
                                                        <option value="{{ $item->get('code') }}" {{ (old('country_code', $user->country_code)==$item->get('code')) ? 'selected="selected"' : '' }}>
                                                            {{ $item->get('name') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        */
                                        ?>
                                        <input name="country_code" type="hidden" value="{{ $user->country_code }}">

                                        <!-- phone -->
                                        <div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                            <label for="phone" class="col-sm-3 control-label">{{ t('Phone') }}
                                                <sup>*</sup></label>
                                            <div class="col-sm-7">

                                                <input id="phone" name="phone" type="text" class="form-control"
                                                       placeholder="{{ (!isEnabledField('email')) ? t('Mobile Phone Number') : t('Phone Number') }}"
                                                       value="{{ phoneFormat(old('phone', $user->phone), old('country_code', $user->country_code)) }}">

                                                <input name="phone_hidden" id="phoneHidden" type="hidden"
                                                       value="1" {{ (old('phone_hidden', $user->phone_hidden)=='1') ? 'checked="checked"' : '' }}>
                                            </div>
                                        </div>


                                @endif

                                <!-- Button -->
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="avatar-wrap">
                                    <h4>Ảnh đại diện</h4>
                                    <div id="avatar-holder">
                                        <img src="{!! $user->getAvatar() !!}" alt=""
                                             class="img-fluid img-responsive img-thumbnail">
                                    </div>
                                    <label class="btn btn-primary mt-20" for="avatar">
                                        <input id="avatar" type="file" style="display:none;">
                                        Đổi ảnh đại diện
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- SETTINGS -->
            <div class="panelx panel-defaultx">
                <div class="panel-heading">
                    <h4 class="panel-title"><a href="#settingsPanel" data-toggle="collapse"
                                               data-parent="#accordion"> {{ t('Settings') }} </a></h4>
                </div>
                <div class="panel-collapse collapse in"
                     id="settingsPanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form name="settings" class="form-horizontal" role="form" method="POST"
                                      action="{{ lurl('account/settings') }}">
                                    {!! csrf_field() !!}
                                    <input name="_method" type="hidden" value="PUT">
                                    <input name="panel" type="hidden" value="settingsPanel">

                                    <!-- disable_comments -->
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input id="disable_comments" name="disable_comments" value="1"
                                                           type="checkbox" {{ ($user->disable_comments==1) ? 'checked' : '' }}>
                                                    {{ t('Disable comments on my ads') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

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
                                            <input id="password_confirmation" name="password_confirmation"
                                                   type="password"
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
                </div>
            </div>

        </div>
        <!--/.row-box End-->

    </div>

@endsection

@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" />
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">

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
    </style>
@endsection

@section('after_scripts')


    <script>
        $(document).ready(function () {

            $('textarea').each(function(){
               $(this).summernote({
                   airMode: true,
                   height:200,
                   placeholder: $(this).attr('placeholder')
               });
            });
            $('input[type=file]').change(function () {
                $(this).simpleUpload("/ajax/account/upload-avatar", {
                    start: function (file) {},
                    progress: function (progress) {},
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
        });
    </script>


@endsection
