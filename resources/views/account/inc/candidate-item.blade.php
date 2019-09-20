<div class="col-md-4">
    <div class="row candidate-item">
        <div class="col-md-12 col-lg-12 ">

            <a href="{!! route('search.view-profile',$candidate->hash) !!}"
               data-toggle="modal" data-target="#candidateModal" data-remote="false" data-hash="{!! $candidate->hash !!}"
               class="view-profile" >
                <div class="candidate_avatar">
                    <div class="img-background logo_box"
                         style="background-image: url(&quot;{!! $candidate->getAvatar(100,32) !!}&quot;);">

                    </div>
                </div>
                <div class="candidate_info">
                    <p class="user_name text_ellipsis">
                        <strong>{!! $candidate->name !!}</strong>
                    </p>
                    <p class="text_ellipsis"><strong>Kinh nghiệm: </strong>
                        <span class="text-danger">
                                        @if(optional($candidate->profile)->experience_years == 0 )
                                1 năm
                            @else
                                {!! optional($candidate->profile)->experience_years !!} năm
                            @endif

                                    </span>
                    </p>
                    @if(optional($candidate->profile)->category)
                        <p class="text-muted updated-date"><strong> Ngành nghề quan tâm: </strong>
                            {!! optional($candidate->profile)->category->name !!}
                        </p>
                    @endif
                </div>

            </a>
        </div>
    </div>
</div>
