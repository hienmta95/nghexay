<?php
$fullUrl = url(\Illuminate\Support\Facades\Request::getRequestUri());
$tmpExplode = explode('?', $fullUrl);
$fullUrlNoParams = current($tmpExplode);
?>
@extends('layouts.master')

@section('search')
    @parent
    @include('search.inc.form')
    @include('layouts.inc.advertising.top')
@endsection

@section('content')
    @include('common.spacer')
    <div class="main-container">
        <div class="container">

            <div class="section-content">
                <div class="inner-box">
                    <div class="row">
                        <?php
                        $companyInfoExists = false;
                        $leftCol = 'col-sm-12';
                        if (
                            (isset($company->address) and !empty($company->address)) or
                            (isset($company->phone) and !empty($company->phone)) or
                            (isset($company->mobile) and !empty($company->mobile)) or
                            (isset($company->fax) and !empty($company->fax))
                        ) {
                            $companyInfoExists = true;
                            $leftCol = 'col-sm-8';
                            $rightCol = 'col-sm-4';
                        }
                        ?>
                        <div class="{{ $leftCol }}">
                            <div class="seller-info seller-profile">
                                <div class="seller-profile-img">
                                    <a>
                                        <img src="{{ resize(\App\Models\Company::getLogo($company->logo), 'medium') }}"
                                             class="img-responsive thumbnail" alt="img">
                                    </a>
                                </div>
                                <h3 class="no-margin no-padding link-color uppercase">
                                    {{ $company->name }}

                                    @if($company->verified)
                                        <i class="fa fa-check-circle verified"></i>
                                    @endif

                                    @if (auth()->check())
                                        @if (auth()->user()->id == $company->user_id)
                                            <a href="{{ lurl('account/companies/' . $company->id . '/edit') }}"
                                               class="btn btn-default">
                                                <i class="fa fa-pencil-square-o"></i> {{ t('Edit') }}
                                            </a>
                                        @endif
                                    @endif

                                </h3>

                                <div class="text-muted">
                                    {!! $company->description !!}
                                </div>

                                <div class="seller-social-list">
                                    <ul class="share-this-post">
                                        @if (isset($company->googleplus) and !empty($company->googleplus))
                                            <li><a class="google-plus" href="{{ $company->googleplus }}"
                                                   target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                        @endif
                                        @if (isset($company->linkedin) and !empty($company->linkedin))
                                            <li><a href="{{ $company->linkedin }}" target="_blank"><i
                                                            class="fa icon-linkedin-rect"></i></a></li>
                                        @endif
                                        @if (isset($company->facebook) and !empty($company->facebook))
                                            <li><a class="facebook" href="{{ $company->facebook }}" target="_blank"><i
                                                            class="fa fa-facebook"></i></a></li>
                                        @endif
                                        @if (isset($company->twitter) and !empty($company->twitter))
                                            <li><a href="{{ $company->twitter }}" target="_blank"><i
                                                            class="fa fa-twitter"></i></a></li>
                                        @endif
                                        @if (isset($company->pinterest) and !empty($company->pinterest))
                                            <li><a class="pinterest" href="{{ $company->pinterest }}" target="_blank"><i
                                                            class="fa fa-pinterest"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if ($companyInfoExists)
                            <div class="{{ $rightCol }}">
                                <div class="seller-contact-info mt5">
                                    <h3 class="no-margin"> {{ t('Contact Information') }} </h3>
                                    <dl class="contact-info">
                                        @if (isset($company->address) and !empty($company->address))
                                            {{ t('Address') }}: {!! $company->address !!}
                                        @endif

                                        <?php /*
                                        @if (isset($company->phone) and !empty($company->phone))
                                            <dt>{{ t('Phone') }}: {{ $company->phone }}</dd>
                                        @endif

                                        @if (isset($company->mobile) and !empty($company->mobile))
                                            <dt>{{ t('Mobile Phone') }}: {{ $company->mobile }}</dd>
                                        @endif

                                        @if (isset($company->fax) and !empty($company->fax))
                                            <dt>{{ t('Fax') }}: {{ $company->fax }}</dd>
                                        @endif
 */?>

                                        @if (isset($company->website) and !empty($company->website))
                                            <dt>{{ t('Website') }}:
                                                <a href="{!! $company->website !!}" target="_blank">
                                                    {!! $company->website !!}
                                                </a>
                                            </dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="section-block" style="margin-top: 20px;">
                    <div class="category-list">
                        <div class="tab-box clearfix">

                            <!-- Nav tabs -->
                            <div class="col-lg-12 box-title no-border">
                                <div class="inner">
                                    <h2>
                                        <small>{{ $count->get('all') }} {{ t('Jobs Found') }}</small>
                                    </h2>
                                </div>
                            </div>

                            <!-- Mobile Filter bar -->
                            <div class="mobile-filter-bar col-lg-12">

                            </div>
                            <div class="menu-overly-mask"></div>
                            <!-- Mobile Filter bar End-->


                            <div class="tab-filter hide-xs" style="padding-top: 6px; padding-right: 6px;">

                            </div>
                            <!--/.tab-filter-->

                        </div>
                        <!--/.tab-box-->

                       
                        <!--/.listing-filter-->

                        <div class="adds-wrapper jobs-list">
                            @include('search.inc.posts')
                        </div>
                        <!--/.adds-wrapper-->

                        <div class="tab-box save-search-bar text-center">
                            @if (Request::filled('q') and Request::get('q') != '' and $count->get('all') > 0)
                                <a name="{!! qsurl($fullUrlNoParams, Request::except(['_token', 'location'])) !!}"
                                   id="saveSearch" count="{{ $count->get('all') }}">
                                    <i class=" icon-star-empty"></i> {{ t('Save Search') }}
                                </a>
                            @else
                                <a href="#"> &nbsp; </a>
                            @endif
                        </div>
                    </div>

                    <div class="pagination-bar text-center">
                        {!! $paginator->appends(request()->query())->render() !!}
                    </div>
                    <!--/.pagination-bar -->
                </div>

                <div style="clear:both;"></div>

                <!-- Advertising -->
                @include('layouts.inc.advertising.bottom')
            </div>

        </div>
    </div>
@endsection
