<?php
// From Company's Form
$classLeftCol = 'col-sm-3';
$classRightCol = 'col-sm-9';

if (isset($originForm)) {
    // From User's Form
    if ($originForm == 'user') {
        $classLeftCol = 'col-md-3';
        $classRightCol = 'col-md-7';
    }

    // From Post's Form
    if ($originForm == 'post') {
        $classLeftCol = 'col-md-3';
        $classRightCol = 'col-md-8';
    }
}

//$provinces = \App\Models\SubAdmin1::where('country_code','VN')->orderBy('position','desc')->get();
$cities = \App\Models\City::currentCountry()->where('feature_class','P')
    ->orderBy('name')->get();
?>
<div id="companyFields">
    <!-- name -->
    <div class="form-group required <?php echo (isset($errors) and $errors->has('company.name')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.name">{{ t('Company Name') }} <sup>*</sup></label>
        <div class="{{ $classRightCol }}">
            <input name="company[name]"
                   placeholder="{{ t('Company Name') }}"
                   class="form-control input-md"
                   type="text"
                   value="{{ old('company.name', (isset($company->name) ? $company->name : '')) }}" required>
        </div>
    </div>

    <div class="form-group required <?php echo (isset($errors) and $errors->has('company.address')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.address">{{ t('Company Address') }}
            <sup>*</sup></label>
        <div class="{{ $classRightCol }}">
            <input name="company[address]"
                   placeholder="{{ t('Company Address') }}"
                   class="form-control input-md"
                   type="text"
                   value="{{ old('company.address', (isset($company->address) ? $company->address : '')) }}"
                   required>
        </div>
    </div>
    <div class="form-group required <?php echo (isset($errors) and $errors->has('company.phone')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.address">{{ t('Company Phone') }}
            <sup>*</sup></label>
        <div class="{{ $classRightCol }}">
            <input name="company[phone]"
                   placeholder="{{ t('Company Phone') }}"
                   class="form-control input-md"
                   type="text"
                   value="{{ old('company.phone', (isset($company->phone) ? $company->phone : '')) }}" required>
        </div>
    </div>
    <div class="form-group required <?php echo (isset($errors) and $errors->has('company.size')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.size">{{ t('Company Size') }} <sup>*</sup></label>
        <div class="{{ $classRightCol }}">
            {!! Form::select('company[size]',['<10','10-50','50-150','150-500','>500'], (isset($company->size) ? $company->size : '<10'),['class'=>'form-control']) !!}
        </div>
    </div>
    <!-- logo -->
    @if(isset($originForm) && $originForm != 'register')
    <div class="form-group <?php echo (isset($errors) and $errors->has('company.logo')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.logo"> {{ t('Logo') }} </label>
        <div class="{{ $classRightCol }}">
            <div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
                <input id="logo" name="company[logo]" type="file" class="file">
            </div>
            <p class="help-block">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
        </div>
    </div>
    <div class="form-group <?php echo (isset($errors) and $errors->has('company.business_license')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.business_license"> {{ t('Business License') }} </label>
        <div class="{{ $classRightCol }}">
            <div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
                <input id="business_license" name="company[business_license]" type="file" class="file">
            </div>
            <p class="help-block">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
        </div>
    </div>

    <div class="form-group <?php echo (isset($errors) and $errors->has('company.website')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.website">{{ t('Company Website') }} <sup>*</sup></label>
        <div class="{{ $classRightCol }}">
            <input name="company[website]"
                   placeholder="{{ t('Company Website') }}"
                   class="form-control input-md"
                   type="text"
                   value="{{ old('company.website', (isset($company->website) ? $company->website : '')) }}">
        </div>
    </div>

    <!-- description -->
    <div class="form-group required <?php echo (isset($errors) and $errors->has('company.description')) ? 'has-error' : ''; ?>">
        <label class="{{ $classLeftCol }} control-label" for="company.description">{{ t('Company Description') }}
            <sup>*</sup></label>
        <div class="{{ $classRightCol }}">
            <textarea class="form-control" name="company[description]"
                      rows="10">{{ old('company.description', (isset($company->description) ? $company->description : '')) }}</textarea>
            <p class="help-block">{{ t('Describe the company') }} -
                ({{ t(':number characters maximum', ['number' => 1000]) }})</p>
        </div>
    </div>
    @endif
@if (isset($company) and !empty($company))
    <!-- country_code -->
        <div class="form-group required <?php echo (isset($errors) and $errors->has('company.country_code')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.country_code">{{ t('Country') }}</label>
            <div class="{{ $classRightCol }}">
                <select id="countryCode" name="company[country_code]" class="form-control sselecter">
                    <option value="0" {{ (!old('company.country_code') or old('company.country_code')==0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
                    @foreach ($countries as $item)
                        <option value="{{ $item->get('code') }}"
                                {{ (old('company.country_code',
                                (isset($company->country_code) ? $company->country_code : ((!empty(config('country.code'))) ? config('country.code') : 0)))==$item->get('code')) ? 'selected="selected"' : '' }}>
                            {{ $item->get('name') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- city_id -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.city_id')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.city_id">{{ t('City') }}</label>
            <div class="{{ $classRightCol }}">
                <select id="cityIds" name="company[city_id]" class="form-control sselecter">
                    <option value="0" {{ (!old('company.city_id') or old('company.city_id')==0) ? 'selected="selected"' : '' }}>
                        {{ t('Select a city') }}
                    </option>
                    @foreach($cities as $city)
                        <option value="{!! $city->id !!}"  @if(old('company.city_id',$company->city_id) == $city->id) selected @endif>{!! $city->name !!}</option>
                        @endforeach
                </select>
            </div>
        </div>

        <!-- address -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.address')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.address">{{ t('Address') }}</label>
            <div class="{{ $classRightCol }}">
                    <input name="company[address]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.address', (isset($company->address) ? $company->address : '')) }}">
                </div>
        </div>

        <!-- phone -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.phone')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.phone">{{ t('Phone') }}</label>
            <div class="{{ $classRightCol }}">

                    <input name="company[phone]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.phone', (isset($company->phone) ? $company->phone : '')) }}">

            </div>
        </div>

        <!-- fax -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.fax')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.fax">{{ t('Fax') }}</label>
            <div class="{{ $classRightCol }}">

                    <input name="company[fax]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.fax', (isset($company->fax) ? $company->fax : '')) }}">

            </div>
        </div>

        <!-- email -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.email')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.email">{{ t('Email') }}</label>
            <div class="{{ $classRightCol }}">

                    <input name="company[email]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.email', (isset($company->email) ? $company->email : '')) }}">

            </div>
        </div>

        <!-- website -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.website')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.website">{{ t('Website') }}</label>
            <div class="{{ $classRightCol }}">

                    <input name="company[website]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.website', (isset($company->website) ? $company->website : '')) }}">

            </div>
        </div>

        <!-- facebook -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.facebook')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.facebook">Facebook</label>
            <div class="{{ $classRightCol }}">

                    <input name="company[facebook]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.facebook', (isset($company->facebook) ? $company->facebook : '')) }}">

            </div>
        </div>


        <!-- linkedin -->
        <div class="form-group <?php echo (isset($errors) and $errors->has('company.linkedin')) ? 'has-error' : ''; ?>">
            <label class="{{ $classLeftCol }} control-label" for="company.linkedin">Linkedin</label>
            <div class="{{ $classRightCol }}">

                    <input name="company[linkedin]" type="text"
                           class="form-control" placeholder=""
                           value="{{ old('company.linkedin', (isset($company->linkedin) ? $company->linkedin : '')) }}">

            </div>
        </div>

    @endif
    <div class="clearfix"></div>
</div>

@section('after_styles')
    @parent
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" />
    <style>
        #companyFields .select2-container {
            width: 100% !important;
        }

        .file-loading:before {
            content: " {{ t('Loading') }}...";
        }
        .note-editor {
            border:1px solid #E6E6E6;
            padding: 15px;
        }
    </style>
@endsection

@section('after_scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script>
        /* Initialize with defaults (logo) */
        $('#logo').fileinput(
            {
                language: '{{ config('app.locale') }}',
                @if (config('lang.direction') == 'rtl')
                rtl: true,
                @endif
                showPreview: true,
                allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
                showUpload: false,
                showRemove: false,
                maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
                @if (isset($company) and !empty($company->logo) and \Storage::exists($company->logo))
                initialPreview: [
                    '{{ resize($company->logo, 'medium') }}'
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                /* Initial preview configuration */
                initialPreviewConfig: [
                    {
                        width: '120px'
                    }
                ],
                initialPreviewShowDelete: false
                @endif
            });
        $('#business_license').fileinput(
            {
                language: '{{ config('app.locale') }}',
                @if (config('lang.direction') == 'rtl')
                rtl: true,
                @endif
                showPreview: true,
                allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
                showUpload: false,
                showRemove: false,
                maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
                @if (isset($company) and !empty($company->business_license) and \Storage::exists($company->business_license))
                initialPreview: [
                    '{{ resize($company->business_license, 'medium') }}'
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                /* Initial preview configuration */
                initialPreviewConfig: [
                    {
                        width: '120px'
                    }
                ],
                initialPreviewShowDelete: false
                @endif
            });
    </script>
    @if (isset($company) and !empty($company))
        <script>
            /* Translation */
            var lang = {
                'select': {
                    'country': "{{ t('Select a country') }}",
                    'admin': "{{ t('Select a location') }}",
                    'city': "{{ t('Select a city') }}"
                }
            };

            /* Locations */
            var countryCode = '{{ old('company.country_code', (isset($company) ? $company->country_code : 0)) }}';
            var adminType = 0;
            var selectedAdminCode = 0;
            var cityId = '{{ old('company.city_id', (isset($company) ? $company->city_id : 0)) }}';
            $('textarea').each(function(){
                $(this).summernote({
                    airMode: true,
                    height:200,
                    placeholder: $(this).attr('placeholder')
                });
            });
        </script>
        <script src="{{ url('assets/js/app/d.select.location.js') . vTime() }}"></script>
    @endif
@endsection
