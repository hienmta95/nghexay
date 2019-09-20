<div class="cpGrid-div candidate-item">
    <div>
        <a title="{{ $candidate->name }}" href="{!! $candidate->getUrl() !!}" class="cpGrid-avatarLink">
            <img alt="{{ $candidate->name }}"
                 src="{{$candidate->getAvatar() }}"
                 class="cpGrid-avatarImg img-responsive">
        </a>

        <div class="cpGrid-divUser">
            <div class="cpGrid-divName">
                <a title="{{ optional($candidate->profile)->expected_job_title }}" href="{!! $candidate->getUrl() !!}">
                    {!! \App\Helpers\Tool::ucwords(str_limit(optional($candidate->profile)->expected_job_title,30)) !!}
                </a>
            </div>
            <p>
                <a href="{!! $candidate->getUrl() !!}" title="{{ $candidate->name }}">
                    <strong>{{ \App\Helpers\Tool::ucwords($candidate->name) }}</strong>
                </a>
            </p>

            @if($candidate->profile)
            <p class="text-gray">Kinh nghiệm: {!! optional($candidate->profile)->experience_years > 0 ? optional($candidate->profile)->experience_years : 'Dưới 1'  !!}
                năm
            </p>
            <?php
                $today = \Carbon\Carbon::today();
                $updated = \Carbon\Carbon::parse(optional($candidate->profile)->updated_at);
                $diff = $updated->diffInDays($today,false);


            ?>
            @if($diff <= 7)
                <small class="small text-danger">Cập nhật {!! $candidate->profile->updated_at->format('d/m/Y') !!}</small>
                @endif
                @endif
        </div>
    </div>
</div>
