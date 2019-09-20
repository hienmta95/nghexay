<div class="col-md-4">
    <div class="cpGrid-div">
        <a class="cpGrid-bg cpGrid-block" style="background-image: url('{!! $images[array_rand($images)] !!}')"></a>

        <div>
            <a title="{{ $iCompany->name }}" href="{!! $iCompany->getUrl() !!}" class="cpGrid-avatarLink">
                <img alt="{{ $iCompany->name }}"
                     src="{{ resize(\App\Models\Company::getLogo($iCompany->logo), 'medium') }}"
                     class="cpGrid-avatarImg img-responsive">
            </a>

            <div class="cpGrid-divUser">
                <div class="cpGrid-divName">
                    <a href="{!! $iCompany->getUrl() !!}">{{ App\Helpers\Tool::ucwords($iCompany->name) }}</a>
                </div>
                <span>
                     <span class="cpGrid-StatValues"> Đang tuyển {{ $iCompany->posts_count }}</span>
                </span>
            </div>
        </div>
    </div>
</div>
