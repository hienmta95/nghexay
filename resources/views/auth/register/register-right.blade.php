<div class="inner-box category-content">
    <h4 class="title-2 text-dark">
        <i class="icon-user-add"></i> Đăng ký tài khoản nhà tuyển dụng
    </h4>
    <div class="row">

        <?php /*@if (config('settings.social_auth.social_login_activation'))
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center mb30">
                                    <div class="row row-centered">
                                        <div class="col-md-9 col-xs-12 mb5">
                                            <a href="{{ lurl('auth/facebook') }}" class="btn-fb"><i
                                                        class="icon-facebook"></i> {!! t('Connect with Facebook') !!}
                                            </a>
                                        </div>
                                        <div class="col-md-9 col-xs-12 mb5">
                                            <a href="{{ lurl('auth/google') }}" class="btn-danger"><i
                                                        class="icon-googleplus-rect"></i> {!! t('Connect with Google') !!}
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row row-centered loginOr">
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 col-centered mb5">
                                            <hr class="hrOr">
                                            <span class="spanOr rounded">{{ t('or') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif*/?>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form id="signupForm" class="form-horizontal" method="POST"
                  action="{{ url()->current() }}" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <fieldset>
                <?php
                /*
                <!-- gender_id -->
                <div class="form-group required <?php echo (isset($errors) and $errors->has('gender_id')) ? 'has-error' : ''; ?>">
                    <label class="col-md-3 control-label">{{ t('Gender') }} <sup>*</sup></label>
                    <div class="col-md-7">
                        <select name="gender_id" id="genderId" class="form-control selecter">
                            <option value="0"
                                    @if (old('gender_id')=='' or old('gender_id')==0)
                                        selected="selected"
                                    @endif
                            > {{ t('Select') }} </option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->tid }}"
                                        @if (old('gender_id')==$gender->tid)
                                            selected="selected"
                                        @endif
                                >
                                    {{ $gender->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                */
                ?>

                <!-- name -->
                    <div class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
                        <label class="col-md-3 control-label">Tên người liên hệ <sup>*</sup></label>
                        <div class="col-md-9">
                            <input name="name" placeholder="{{ t('Name') }}"
                                   class="form-control input-md" type="text"
                                   value="{{ old('name') }}">
                        </div>
                    </div>

                {!! Form::hidden('user_type_id',1) !!}

                <!-- country_code -->
                    @if (empty(config('country.code')))
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('country_code')) ? 'has-error' : ''; ?>">
                            <label class="col-md-3 control-label"
                                   for="country_code">{{ t('Your Country') }} <sup>*</sup></label>
                            <div class="col-md-9">
                                <select id="countryCode" name="country_code"
                                        class="form-control sselecter">
                                    <option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>{{ t('Select') }}</option>
                                    @foreach ($countries as $code => $item)
                                        <option value="{{ $code }}" {{ (old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$code) ? 'selected="selected"' : '' }}>
                                            {{ $item->get('name') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <input id="countryCode" name="country_code" type="hidden"
                               value="{{ config('country.code') }}">
                @endif

                @if (isEnabledField('phone'))
                    <!-- phone -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                            <label class="col-md-3 control-label">{{ t('Phone') }}
                                @if (!isEnabledField('email'))
                                    <sup>*</sup>
                                @endif
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                                        <span id="phoneCountry"
                                                              class="input-group-addon">{!! getPhoneIcon(old('country', config('country.code'))) !!}</span>

                                    <input name="phone"
                                           placeholder="{{ (!isEnabledField('email')) ? t('Mobile Phone Number') : t('Phone Number') }}"
                                           class="form-control input-md" type="text"
                                           value="{{ phoneFormat(old('phone'), old('country', config('country.code'))) }}">

                                    <label class="input-group-addon" class="tooltipHere"
                                           data-placement="top"
                                           data-toggle="tooltip"
                                           data-original-title="{{ t('Hide the phone number on the ads.') }}">
                                        <input name="phone_hidden" id="phoneHidden" type="checkbox"
                                               value="1" {{ (old('phone_hidden')=='1') ? 'checked="checked"' : '' }}>
                                        {{ t('Hide') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                @endif

                @if (isEnabledField('email'))
                    <!-- email -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                            <label class="col-md-3 control-label" for="email">{{ t('Email') }}
                                @if (!isEnabledField('phone'))
                                    <sup>*</sup>
                                @endif
                            </label>
                            <div class="col-md-9">
                                <input id="email" name="email" type="email" class="form-control"
                                       placeholder="{{ t('Email') }}"
                                       value="{{ old('email') }}">

                            </div>
                        </div>
                @endif

                @if (isEnabledField('username'))
                    <!-- username -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('username')) ? 'has-error' : ''; ?>">
                            <label class="col-md-3 control-label"
                                   for="email">{{ t('Username') }}</label>
                            <div class="col-md-9">
                                <input id="username" name="username" type="text"
                                       class="form-control" placeholder="{{ t('Username') }}"
                                       value="{{ old('username') }}">

                            </div>
                        </div>
                @endif

                <!-- password -->
                    <div class="form-group required <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
                        <label class="col-md-3 control-label" for="password">{{ t('Password') }}
                            <sup>*</sup></label>
                        <div class="col-md-9">
                            <input id="password" name="password" type="password"
                                   class="form-control" placeholder="{{ t('Password') }}">
                            <br>
                            <input id="password_confirmation" name="password_confirmation"
                                   type="password" class="form-control"
                                   placeholder="{{ t('Password Confirmation') }}">
                            <p class="help-block">{{ t('At least 5 characters') }}</p>
                        </div>
                    </div>
                    <div id="companyBlocx">
                        <div class="content-subheading">
                            <i class="icon-town-hall fa"></i>
                            {{ t('Company Information') }}
                        </div>

                        @include('account.company._form', ['originForm' => 'register'])
                    </div>

                @if (config('settings.security.recaptcha_activation'))
                    <!-- g-recaptcha-response -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
                            <label class="col-md-3 control-label"
                                   for="g-recaptcha-response"></label>
                            <div class="col-md-9">
                                {!! Recaptcha::render(['lang' => config('app.locale')]) !!}
                            </div>
                        </div>
                @endif

                <!-- term -->
                    <div class="form-group required <?php echo (isset($errors) and $errors->has('term')) ? 'has-error' : ''; ?>"
                         style="margin-top: -10px;">
                        <div class="col-md-9 col-md-offset-3">
                            <div class="termbox mb10">
                                <label class="checkbox-inline" for="term">
                                    <input name="term" id="term" value="1"
                                           type="checkbox" {{ (old('term')=='1') ? 'checked="checked"' : '' }}>
                                    {!! t('I have read and agree to the <a :attributes>Terms & Conditions</a>', ['attributes' => getUrlPageByType('terms')]) !!}
                                </label>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>

                    <!-- Button  -->


                </fieldset>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button id="signupBtn"
                                class="btn btn-success btn-block"> {{ t('Register') }} </button>
                    </div>
                </div>

                <div style="margin-bottom: 30px;"></div>
            </form>
        </div>
    </div>
</div>
