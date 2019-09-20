@if (isset($featuredCompanies) and !empty($featuredCompanies))
    @if (isset($featuredCompanies->companies) and $featuredCompanies->companies->count() > 0)
        @include('home.inc.spacer')


        <div class="section featured-companies">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ $featuredCompanies->link }}">
                            <h2 class="section-title text-center">
                                {!! $featuredCompanies->title !!}
                            </h2>
                        </a>
                        <div class="row no-gutter">
                            @foreach($featuredCompanies->companies as $key => $iCompany)
                                <?php
                                // Company URL setting
                                $attr = ['countryCode' => config('country.icode'), 'id' => $iCompany->id, 'companySlug' => $iCompany->slug];
                                $companyUrl = lurl(trans('routes.v-search-company', $attr), $attr);
                                ?>
                                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-4">
                                    <a class="ft-company" href="{{ $companyUrl }}">
                                        <img alt="{{ $iCompany->name }}" class="img-responsive"
                                             src="{{ resizeThumb(\App\Models\Company::getLogo($iCompany->logo), 185,90,'true','false') }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
