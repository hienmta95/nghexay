<?php
$eLocation = isset($profile->expected_job_city_id) ? \App\Models\City::where('id', (int)$profile->expected_job_city_id)->first() : null;
$eCat = isset($profile->expected_job_category_id) ? \App\Models\Category::where('id', (int)$profile->expected_job_category_id)->first() : null;
$eJob = isset($profile->expected_job_post_type_id) ? \App\Models\PostType::trans()->where('id', (int)$profile->expected_job_post_type_id)->first() : null;
$ePos = isset($profile->expected_job_position_id) ? \App\Models\PositionType::trans()->where('id', (int)$profile->expected_job_position_id)->first() : null;
?>
<div class="expected-item">
    @if(!isset($is_print) || $is_print !== true )
    <button type="button" class="close remove-profile-entry"
            data-user-id="{!! $profile->user_id !!}"
            data-type="expected_job_data"
            data-method="delete"><span
                aria-hidden="true">×</span><span class="sr-only">Close</span>

    </button>
    @endif
    @if(isset($eLocation->name) && optional($eLocation)->name != '')
    <p>
        <strong>Địa điểm:</strong> <span>{!! optional($eLocation)->name !!}</span>
    </p>
    @endif
    @if(isset($eJob->name) && optional($eJob)->name != '')
    <p>
        <strong>Hình thức:</strong> {!! optional($eJob)->name !!}
    </p>
    @endif
    @if(isset($eCat->name) && optional($eCat)->name != '')
    <p>
        <strong> Ngành nghề:</strong> {!! optional($eCat)->name !!}
    </p>
    @endif
    @if(isset($ePos->name) && optional($ePos)->name != '')
    <p>
        <strong>Vị trí:</strong> {!! optional($ePos)->name !!}
    </p>
    @endif
    @if(isset($profile->expected_job_salary) && optional($profile)->expected_job_salary != '')
    <p>
        <strong>Mức lương:</strong> {!! number_format(optional($profile)->expected_job_salary) !!}
    </p>
    @endif
    @if(isset($profile->other) && optional($profile)->other != '')
    <p>
        <strong>Khác:</strong> {!! optional($profile)->other !!}
    </p>
        @endif
</div>