@extends('layouts.account')

@section('wizard')

@endsection

<?php
// Category
if ($post->category) {
    if ($post->category->parent_id == 0) {
        $postCatParentId = $post->category->id;
    } else {
        $postCatParentId = $post->category->parent_id;
    }
} else {
    $postCatParentId = 0;
}
?>
@section('content')
    @include('post.inc.wizard')
    <div class="col-md-12 page-content">

        <div class="inner-box category-content">
            <h2 class="title-2" style="border-bottom: 0;">
                <strong> <i class="icon-docs"></i> {{ t('Update My Ad') }}</strong> -&nbsp;
                <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                <a href="{{ lurl($post->uri, $attr) }}" class="tooltipHere" title="" data-placement="top"
                   data-toggle="tooltip"
                   data-original-title="{!! $post->title !!}">
                    {!! str_limit($post->title, 45) !!}
                </a>
            </h2>
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" novalidate
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input name="_method" type="hidden" value="PUT">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <fieldset>
                            <!-- COMPANY -->
                            <div class="content-subheading" style="margin-top: 0;">
                                <i class="icon-town-hall fa"></i>
                                <strong>{{ t('Company Information') }}</strong>
                            </div>

                            <!-- company_id -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('category_id')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label">{{ t('Select a Company') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <select id="companyId" name="company_id" class="form-control selecter">
                                        <option value="0" data-logo=""
                                                @if (old('company_id', 0)==0)
                                                selected="selected"
                                                @endif
                                        >
                                            [+] {{ t('New Company') }}
                                        </option>
                                        @if (isset($companies) and $companies->count() > 0)
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->id }}"
                                                        data-logo="{{ resize($item->logo, 'small') }}"
                                                        @if (old('company_id', (isset($postCompany) ? $postCompany->id : 0))==$item->id)
                                                        selected="selected"
                                                        @endif
                                                >
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- logo -->
                            <div id="logoField" class="form-group">
                                <label class="col-md-3 control-label">&nbsp;</label>
                                <div class="col-md-8">
                                    <div class="mb10">
                                        <div id="logoFieldValue"></div>
                                    </div>
                                    <p class="help-block">
                                        <a id="companyFormLink" href="{{ lurl('account/companies/0/edit') }}"
                                           class="btn btn-default">
                                            <i class="fa fa-pencil-square-o"></i>
                                            {{ t('Edit the Company') }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                        @include('account.company._form', ['originForm' => 'post'])


                        <!-- POST -->
                            <div class="content-subheading">
                                <i class="icon-town-hall fa"></i>
                                <strong>{{ t('Job Details') }}</strong>
                            </div>

                            <!-- parent_id -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('parent_id')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <select name="parent_id" id="parentId" class="form-control selecter">
                                        <option value="0" data-type=""
                                                @if (old('parent_id', $postCatParentId)=='' or old('parent_id', $postCatParentId)==0)
                                                selected="selected"
                                                @endif
                                        >
                                            {{ t('Select a category') }}
                                        </option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
                                                    @if (old('parent_id', $postCatParentId)==$cat->tid)
                                                    selected="selected"
                                                    @endif
                                            >
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="parent_type" id="parentType"
                                           value="{{ old('parent_type') }}">
                                </div>
                            </div>

                            <!-- category_id -->
                            <div id="subCatBloc"
                                 class="form-group required <?php echo (isset($errors) and $errors->has('category_id')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label">{{ t('Sub-Category') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <select name="category_id" id="categoryId" class="form-control selecter">
                                        <option value="0"
                                                @if (old('category_id', $post->category_id)=='' or old('category_id', $post->category_id)==0)
                                                selected="selected"
                                                @endif
                                        >
                                            {{ t('Select a sub-category') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- title -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('title')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="title">{{ t('Title') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <input id="title" name="title" placeholder="{{ t('Job title') }}"
                                           class="form-control input-md"
                                           type="text" value="{{ old('title', $post->title) }}">
                                    <span class="help-block">{{ t('A great title needs at least 60 characters.') }} </span>
                                </div>
                            </div>

                            <!-- description -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('description')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="description">{{ t('Description') }}
                                    <sup>*</sup></label>
                                <div class="col-md-9" style="position: relative; float: right; padding-top: 10px;">
                                    <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
                                    <textarea class="form-control {{ $ckeditorClass }}" id="description"
                                              name="description" rows="10"
                                              required="">{{ old('description', $post->description) }}</textarea>
                                    <p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
                                </div>
                            </div>
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('benefit')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="benefit">{{ t('Benefit') }}
                                    <sup>*</sup></label>
                                <div class="col-md-9" style="position: relative; float: right; padding-top: 10px;">
                                    <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
                                    <textarea class="form-control {{ $ckeditorClass }}" id="benefit" name="benefit"
                                              rows="10" required="">{{ old('benefit', $post->benefit) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('requirement')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="benefit">{{ t('Requirement') }} <sup>*</sup></label>
                                <div class="col-md-9" style="position: relative; float: right; padding-top: 10px;">
                                    <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
                                    <textarea class="form-control {{ $ckeditorClass }}" id="requirement"
                                              name="requirement" rows="10"
                                              required="">{{ old('requirement', $post->requirement) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('document')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="document">{{ t('Document') }}
                                    <sup>*</sup></label>
                                <div class="col-md-9" style="position: relative; float: right; padding-top: 10px;">
                                    <?php $ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : ''; ?>
                                    <textarea class="form-control {{ $ckeditorClass }}" id="document" name="document"
                                              rows="10" required="">{{ (old('document', $post->document)) }}</textarea>
                                </div>
                            </div>
                            <!-- post_type_id -->
                            <div id="postTypeBloc"
                                 class="form-group required <?php echo (isset($errors) and $errors->has('post_type_id')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label">{{ t('Job Type') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <select name="post_type_id" id="postTypeId" class="form-control selecter">
                                        @foreach ($postTypes as $postType)
                                            <option value="{{ $postType->tid }}"
                                                    @if (old('post_type_id', $post->post_type_id)==$postType->tid)
                                                    selected="selected"
                                                    @endif
                                            >
                                                {{ $postType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- salary_min & salary_max -->
                            <div id="salaryBloc"
                                 class="form-group <?php echo (isset($errors) and $errors->has('salary_max')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="salary_max">{{ t('Salary') }}</label>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        @if (config('currency')['in_left'] == 1)
                                            <span class="input-group-addon">{!! config('currency')['symbol'] !!}</span>
                                        @endif
                                        <input id="salary_min" name="salary_min" class="form-control"
                                               placeholder="{{ t('Salary (min)') }}" type="text"
                                               value="{{ old('salary_min', $post->salary_min) }}">
                                        <input id="salary_max" name="salary_max" class="form-control"
                                               placeholder="{{ t('Salary (max)') }}" type="text"
                                               value="{{ old('salary_max', $post->salary_max) }}">
                                        @if (config('currency')['in_left'] == 0)
                                            <span class="input-group-addon">{!! config('currency')['symbol'] !!}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- salary_type_id -->
                                <div class="col-md-4">
                                    <select name="salary_type_id" id="salaryTypeId" class="form-control selecter">
                                        @foreach ($salaryTypes as $salaryType)
                                            <option value="{{ $salaryType->tid }}"
                                                    @if (old('salary_type_id', $post->salary_type_id)==$salaryType->tid)
                                                    selected="selected"
                                                    @endif
                                            >
                                                {{ t('per').' '.$salaryType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="checkbox">
                                        <label>
                                            <input id="negotiable" name="negotiable" type="checkbox"
                                                   value="1" {{ (old('negotiable', $post->negotiable)=='1') ? 'checked="checked"' : '' }}>
                                            {{ t('Negotiable') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- start_date -->
                            <div class="form-group <?php echo (isset($errors) and $errors->has('start_date')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="start_date">{{ t('Start Date') }} </label>
                                <div class="col-md-8">
                                    <input id="start_date" name="start_date" placeholder="{{ t('Start Date') }}"
                                           class="form-control input-md datepicker"
                                           type="text" value="{{ old('start_date', $post->start_date) }}">
                                </div>
                            </div>
                            <div class="form-group <?php echo (isset($errors) and $errors->has('deadline')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="deadline">{{ t('Deadline') }} </label>
                                <div class="col-md-8">
                                    <input id="deadline" name="deadline" placeholder="{{ t('Deadline') }}"
                                           class="form-control input-md datepicker"
                                           type="text" value="{{ old('deadline', $post->deadline) }}">
                                </div>
                            </div>
                            <!-- contact_name -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('contact_name')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="contact_name">{{ t('Contact Name') }}
                                    <sup>*</sup></label>
                                <div class="col-md-8">
                                    <input id="contact_name" name="contact_name"
                                           placeholder="{{ t('Contact Name') }}"
                                           class="form-control input-md" type="text"
                                           value="{{ old('contact_name', $post->contact_name) }}">
                                </div>
                            </div>

                            <!-- email -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="email"> {{ t('Contact Email') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <input id="email" name="email" class="form-control"
                                           placeholder="{{ t('Email') }}" type="text"
                                           value="{{ old('email', $post->email) }}">

                                </div>
                            </div>

                            <!-- phone -->
                            <div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="phone">{{ t('Phone Number') }}</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span id="phoneCountry"
                                              class="input-group-addon">{!! getPhoneIcon($post->country_code) !!}</span>

                                        <input id="phone" name="phone"
                                               placeholder="{{ t('Phone Number') }}" class="form-control input-md"
                                               type="text"
                                               value="{{ phoneFormat(old('phone', $post->phone), $post->country_code) }}"
                                        >

                                        <label class="input-group-addon">
                                            <input name="phone_hidden" id="phoneHidden" type="checkbox"
                                                   value="1" {{ (old('phone_hidden', $post->phone_hidden)=='1') ? 'checked="checked"' : '' }}>
                                            {{ t('Hide') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- country_code -->
                            <input id="countryCode" name="country_code" type="hidden"
                                   value="{{ !empty($post->country_code) ? $post->country_code : config('country.code') }}">

                        @if (config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2']))
                            <!-- admin_code -->
                                <div id="locationBox"
                                     class="form-group required <?php echo (isset($errors) and $errors->has('admin_code')) ? 'has-error' : ''; ?>">
                                    <label class="col-md-3 control-label" for="admin_code">{{ t('Location') }}
                                        <sup>*</sup></label>
                                    <div class="col-md-8">
                                        <select id="adminCode" name="admin_code" class="form-control sselecter">
                                            <option value="0" {{ (!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : '' }}>
                                                {{ t('Select your Location') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                        @endif

                        <!-- city_id -->
                            <div id="cityBox"
                                 class="form-group required <?php echo (isset($errors) and $errors->has('city_id')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="city_id">{{ t('City') }} <sup>*</sup></label>
                                <div class="col-md-8">
                                    <select id="cityId" name="city_id" class="form-control sselecter">
                                        <option value="0" {{ (!old('city_id') or old('city_id')==0) ? 'selected="selected"' : '' }}>
                                            {{ t('Select a city') }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- application_url -->
                            <div class="form-group <?php echo (isset($errors) and $errors->has('application_url')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="title">{{ t('Application URL') }}</label>
                                <div class="col-md-8">
                                    <input id="application_url" name="application_url"
                                           placeholder="{{ t('Application URL') }}" class="form-control input-md"
                                           type="text"
                                           value="{{ old('application_url', $post->application_url) }}">
                                    <span class="help-block">{{ t('Candidates will follow this URL address to apply for the job.') }}</span>
                                </div>
                            </div>

                            <!-- tags -->
                            <div class="form-group <?php echo (isset($errors) and $errors->has('tags')) ? 'has-error' : ''; ?>">
                                <label class="col-md-3 control-label" for="title">{{ t('Tags') }}</label>
                                <div class="col-md-8">
                                    <input id="tags" name="tags" placeholder="{{ t('Tags') }}"
                                           class="form-control input-md" type="text"
                                           value="{{ old('tags', $post->tags) }}">
                                    <span class="help-block">{{ t('Enter the tags separated by commas.') }}</span>
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="form-group">
                                <div class="col-md-12" style="text-align: center;">
                                    <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                                    <a href="{{ lurl($post->uri, $attr) }}"
                                       class="btn btn-default btn-lg"> {{ t('Back') }}</a>
                                    <button id="nextStepBtn"
                                            class="btn btn-success btn-lg submitPostForm"> {{ t('Update') }} </button>
                                </div>
                            </div>

                            <div style="margin-bottom: 30px;"></div>

                        </fieldset>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /.page-content -->

    <div class="col-md-3 reg-sidebar">
        <?php /*
        <div class="reg-sidebar-inner text-center">

            @if (getSegment(2) != 'create' && auth()->check())
                @if (auth()->user()->id == $post->user_id)
                    <div class="panel sidebar-panel panel-contact-seller">
                        <div class="panel-heading">{{ t('Author\'s Actions') }}</div>
                        <div class="panel-content user-info">
                            <div class="panel-body text-center">
                                <?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                                <a href="{{ lurl($post->uri, $attr) }}" data-toggle="modal"
                                   class="btn btn-default btn-block">
                                    <i class="icon-right-hand"></i> {{ t('Return to the Ad') }}
                                </a>
                                @if (isset($countPackages) and isset($countPaymentMethods) and $countPackages > 0 and $countPaymentMethods > 0)
                                    <a href="{{ lurl('posts/' . $post->id . '/payment') }}" data-toggle="modal"
                                       class="btn btn-success btn-block">
                                        <i class="icon-ok-circled2"></i> {{ t('Make It Premium') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            <div class="panel sidebar-panel">
                <div class="panel-heading uppercase">
                    <small><strong>{{ t('How to find quickly a candidate?') }}</strong></small>
                </div>
                <div class="panel-content">
                    <div class="panel-body text-left">
                        <ul class="list-check">
                            <li> {{ t('Use a brief title and description of the ad') }} </li>
                            <li> {{ t('Make sure you post in the correct category') }}</li>
                            <li> {{ t('Add a logo to your ad') }}</li>
                            <li> {{ t('Put a min and max salary') }}</li>
                            <li> {{ t('Check the ad before publish') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    */?>
    </div>

@endsection

@section('after_styles')
    @include('layouts.inc.tools.wysiwyg.css')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css"/>

    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
    </style>
@endsection

@section('after_scripts')
    @include('layouts.inc.tools.wysiwyg.js')

    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
        <script src="{{ url('assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}"
                type="text/javascript"></script>
    @endif

    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
        <script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}"
                type="text/javascript"></script>
    @endif

    <script>
        /* Translation */
        var lang = {
            'select': {
                'category': "{{ t('Select a category') }}",
                'subCategory': "{{ t('Select a sub-category') }}",
                'country': "{{ t('Select a country') }}",
                'admin': "{{ t('Select a location') }}",
                'city': "{{ t('Select a city') }}"
            },
            'price': "{{ t('Price') }}",
            'salary': "{{ t('Salary') }}",
            'nextStepBtnLabel': {
                'next': "{{ t('Next') }}",
                'submit': "{{ t('Update') }}"
            }
        };

        var stepParam = 0;

        /* Company */
        var postCompanyId = {{ old('company_id', (isset($postCompany) ? $postCompany->id : 0)) }};
        getCompany(postCompanyId);

        /* Categories */
        var category = {{ old('parent_id', (int)$postCatParentId) }};
        var categoryType = '{{ old('parent_type') }}';
        if (categoryType == '') {
            var selectedCat = $('select[name=parent_id]').find('option:selected');
            categoryType = selectedCat.data('type');
        }
        var subCategory = {{ old('category_id', (int)$post->category_id) }};

        /* Locations */
        var countryCode = '{{ old('country_code', !empty($post->country_code) ? $post->country_code : config('country.code')) }}';
        var adminType = '{{ config('country.admin_type', 0) }}';
        var selectedAdminCode = '{{ old('admin_code', ((isset($admin) and !empty($admin)) ? $admin->code : 0)) }}';
        var cityId = '{{ old('city_id', (int)$post->city_id) }}';

        /* Packages */
        var packageIsEnabled = false;
        @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
            packageIsEnabled = true;
        @endif
        {{--  var benefit = new Simditor({
                  textarea: $('#benefit')
              });
          var document = new Simditor({
              textarea: $('#document')
          });
          var requirement = new Simditor({
              textarea: $('#requirement')
          });--}}
        /*  var description = new Simditor({
              textarea: $('#description')
          });*/

        $(document).ready(function () {
            $('#start_date').datepicker();
            $('#deadline').datepicker();
            /* Company */
            $('#companyId').bind('click, change', function () {
                postCompanyId = $(this).val();
                getCompany(postCompanyId);
            });

            $('#tags').tagit({
                fieldName: 'tags',
                placeholderText: '{{ t('add a tag') }}',
                caseSensitive: true,
                allowDuplicates: false,
                allowSpaces: false,
                tagLimit: {{ (int)config('settings.single.tags_limit', 15) }},
                singleFieldDelimiter: ','
            });
        });
    </script>
    <script src="{{ url('assets/js/app/d.select.category.js') . vTime() }}"></script>
    <script src="{{ url('assets/js/app/d.select.location.js') . vTime() }}"></script>
@endsection
