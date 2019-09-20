@if (isset($featuredCompanies) and !empty($featuredCompanies))
    @if (isset($featuredCompanies->companies) and $featuredCompanies->companies->count() > 0)

        <div class="row row-featured row-featured-category row-featured-company" style="margin-right: 0">
            <div class="col-lg-12  box-title no-border">
                <div class="inner">
                    <h2>
                        <span class="title-3">{!! $featuredCompanies->title !!}</span>
                        <a class="sell-your-item" href="{{ $featuredCompanies->link }}">
                            {{ t('View more') }}
                            <i class="icon-th-list"></i>
                        </a>
                    </h2>
                </div>
            </div>

            @foreach($featuredCompanies->companies as $key => $iCompany)
                <?php
                // Company URL setting
                $attr = ['countryCode' => config('country.icode'), 'id' => $iCompany->id, 'companySlug' => $iCompany->slug];

                $companyUrl = lurl(trans('routes.v-search-company', $attr), $attr);
                ?>
                <div class="col-lg-6 f-category">
                    <a href="{{ $companyUrl }}">
                        <img alt="{{ $iCompany->name }}" class="img-responsive"
                             src="{{ resize(\App\Models\Company::getLogo($iCompany->logo), 'medium') }}">
                        <?php /* <h6>
                                    <span class="company-name">{{ $iCompany->name }}</span>
                                   <span class="jobs-count text-muted">({{ $iCompany->posts_count }})</span>
                                </h6>*/?>
                    </a>
                </div>
            @endforeach

        </div>
    @endif
@endif
