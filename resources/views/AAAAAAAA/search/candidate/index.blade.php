@extends('layouts.master')

@section('search')
    @parent
    @include('search.candidate.inc.search')
@endsection

@section('content')
    @include('common.spacer')
    <div class="main-container">
        <div class="container">

            <div class="col-lg-12 content-box">
                <div class="row row-featured row-featured-category row-featured-candidate">
                    <div class="col-lg-12 box-title no-border mb-15">
                        <div class="inner">
                            <h2>
                                <span class="title-3">Danh sách ứng viên</span>
                                <?php $attr = ['countryCode' => config('country.icode')]; ?>
                            </h2>
                        </div>
                    </div>

                    @if (isset($candidates) and $candidates->count() > 0)
                        @foreach($candidates as $key => $candidate)
                            <div class="col-md-4 mb-15">
                            @include('search.candidate.inc.item')
                            </div>
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
                {{ (isset($candidates)) ? $candidates->appends(request()->except('page'))->links() : '' }}
            </div>

        </div>
    </div>
@endsection
