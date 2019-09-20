<div class="edu-item" data-user-id="{!! $profile->user_id !!}" data-key="{!! $key !!}">
    @if(isset($viewonly) && $viewonly == true)

        @else
    <button type="button" class="close edit-profile-entry"
            data-index="{!! $key !!}"
            data-user-id="{!! $profile->user_id !!}"
            data-type="education_data"
            data-method="edit"><span
                aria-hidden="true"><i class="fa fa-pencil"></i></span><span class="sr-only">Close</span>

    </button>
    <button type="button" class="close remove-profile-entry"
            data-index="{!! $key !!}"
            data-user-id="{!! $profile->user_id !!}"
            data-type="education_data"
            data-method="delete"><span
                aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span>

    </button>
    @endif
    <h4>
        {!! $edu->specialized !!} - {!! $edu->faculty_name !!}
    </h4>

    <p>
        <strong>Trường:</strong> {!! $edu->school_name !!}
    </p>
    <p>
        <strong>Bằng cấp/chứng chỉ:</strong> {!! $edu->degree_name !!}
    </p>
    <p>
        <strong>Xếp loại:</strong> {!! $edu->rating !!}
    </p>
</div>
