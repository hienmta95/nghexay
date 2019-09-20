@extends('layouts.master')

@section('search')
    @parent
    @include('search.company.inc.search')
@endsection

@section('content')
    @include('common.spacer')
    <div class="main-container">
        <div class="container">

            <div class="col-lg-12 content-box">
                <div class="row row-featured row-featured-category row-featured-company">
                    <div class="col-lg-12 box-title no-border">
                        <div class="inner">
                            <h2>
                                <span class="title-3">{{ t('Companies List') }}</span>
                                <?php $attr = ['countryCode' => config('country.icode')]; ?>
                                <a class="sell-your-item" href="{{ lurl(trans('routes.v-search', $attr), $attr) }}">
                                    {{ t('Browse Jobs') }}
                                    <i class="icon-th-list"></i>
                                </a>
                            </h2>
                        </div>
                    </div>

                    <?php
                    $images = [
                        '/images/background-1.jpg',
                        '/images/background-2.jpg',
                        '/images/background-3.jpg',
                        '/images/background-4.jpg',
                        /*'/images/background-5.jpg',
                        '/images/background-6.jpg',
                        '/images/background-7.jpg',*/
                    ];
                    ?>

                    @if (isset($companies) and $companies->count() > 0)
                        @foreach($companies as $key => $iCompany)
                            @include('search.company.inc.item')
                        @endforeach
                    @else
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 f-category" style="width: 100%;">
                            {{ t('No result. Refine your search using other criteria.') }}
                        </div>
                    @endif

                </div>
            </div>

            <div style="clear: both"></div>

            <div class="pagination-bar text-center">
                {{ (isset($companies)) ? $companies->links() : '' }}
            </div>

        </div>
    </div>
@endsection
