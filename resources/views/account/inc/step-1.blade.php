<div class="panel panel-default" id="step-1">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-fw fa-user"></i> {{ t('My details') }}</h3>

        @if($user->user_type_id == 2)
        <span class="pull-right">
            <a href="{!! $user->getUrl() !!}" target="_blank">Xem hồ sơ</a>
        </span>
            @endif
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                <form name="details" class="form-horizontal" role="form" method="POST" id="infoForm"
                      action="{{ url()->current() }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input name="_method" type="hidden" value="PUT">
                    <input name="panel" type="hidden" value="userPanel">

                    @if (empty($user->user_type_id) or $user->user_type_id == 0)

                    <!-- user_type_id -->
                        <div class="form-group-x required <?php echo (isset($errors) and $errors->has('user_type_id')) ? 'has-error' : ''; ?>">
                            <label class=" control-label">{{ t('You are a') }} <sup>*</sup></label>

                            <select name="user_type_id" id="userTypeId" class="form-control selecter">
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

                    @else

                    <!-- gender_id -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- username -->
                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('username')) ? 'has-error' : ''; ?>">

                                    <label class=" control-label" for="email">{{ t('Username') }}
                                        <sup>*</sup></label>

                                    <input id="username" name="username" type="text" class="form-control"
                                           placeholder="{{ t('Username') }}"
                                           value="{{ old('username', $user->username) }}">
                                </div>
                                <!-- phone -->
                            </div>
                            <div class="col-md-6">
                                <!-- name -->
                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                                    <label class=" control-label">{{ t('Name') }} <sup>*</sup></label>

                                    <input name="name" type="text" class="form-control" placeholder=""
                                           value="{{ old('name', $user->name) }}">

                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- email -->
                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                    <label class=" control-label">{{ t('Email') }} <sup>*</sup></label>
                                    <input id="email" name="email" type="email" class="form-control"
                                           placeholder="{{ t('Email') }}" class="disabled"
                                           value="{{ old('email', $user->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                    <label for="phone" class=" control-label">{{ t('Phone') }}
                                        <sup>*</sup></label>

                                    <input id="phone" name="phone" type="text" class="form-control"
                                           placeholder="{{ (!isEnabledField('email')) ? t('Mobile Phone Number') : t('Phone Number') }}"
                                           value="{{ phoneFormat(old('phone', $user->phone), old('country_code', $user->country_code)) }}">
                                    <input name="phone_hidden" id="phoneHidden" type="hidden"
                                           value="1"/>
                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                    <label for="phone" class=" control-label"> Ngành nghề chính của bạn
                                        <sup>*</sup></label>

                                    {!! Form::select('profile[expected_job_category_id]',$categories->pluck('name','id'),$profile->expected_job_category_id,['class'=>'form-control selecter']) !!}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- email -->
                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                    <label class=" control-label">Số năm kinh nghiệm <sup>*</sup></label>
                                    <input id="experience_years" name="profile[experience_years]" type="number"
                                           class="form-control"
                                           placeholder="Số năm kinh nghiệm, để 0 nếu bạn mới hoặc chưa ra trường"
                                           value="{{ old('profile[experience_years]', $profile->experience_years) }}">
                                    {!! Form::hidden('method','put') !!}
                                    {!! Form::hidden('check','false') !!}
                                    {!! Form::hidden('profile[type]','default') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-x required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                    <label for="phone" class=" control-label"> Bằng cấp cao nhất của bạn
                                        <sup>*</sup></label>

                                    {!! Form::select('profile[edu_type_id]',$educationTypes->pluck('name','id'),$profile->edu_type_id,['class'=>'form-control selecter']) !!}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group required <?php echo (isset($errors) and $errors->has('gender_id')) ? 'has-error' : ''; ?>">
                                    <label class=" control-label" style="margin: 20px 0 0 20px;"> {{ t('Gender') }}
                                        <sup>*</sup></label>

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
                        </div>





                        <input name="country_code" type="hidden" value="{{ $user->country_code }}">


                        <button type="submit" class="btn btn-primary nextBtn pull-right" type="button">Cập nhật</button>


                    @endif
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
