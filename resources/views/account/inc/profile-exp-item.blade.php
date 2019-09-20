<div class="edu-item" data-user-id="{!! $profile->user_id !!}" data-key="{!! $key !!}">
    @if(isset($viewonly) && $viewonly == true)

    @else
    <button type="button" class="close edit-profile-entry"
            data-index="{!! $key !!}"
            data-user-id="{!! $profile->user_id !!}"
            data-type="experience_data"
            data-method="update"><span
                aria-hidden="true"><i class="fa fa-pencil"></i></span><span class="sr-only">Close</span>

    </button>
    <button type="button" class="close remove-profile-entry"
            data-index="{!! $key !!}"
            data-user-id="{!! $profile->user_id !!}"
            data-type="experience_data"
            data-method="delete"><span
                aria-hidden="true"><i class="fa fa-remove"></i></span><span class="sr-only">Close</span>

    </button>
    @endif
        <h4>
            {!! $exp->position !!}
        </h4>
        <p>
            <strong>Công ty:</strong> {!! $exp->company_name !!}
        </p>
        <p>
            <strong>Thời gian:</strong> {!! $exp->from_date !!} - {!! $exp->to_date !!}
        </p>
        <div>
            <p><strong>Chi tiết công việc</strong></p>
            <p>
                {!! ($exp->other) !!}
            </p>
        </div>
</div>