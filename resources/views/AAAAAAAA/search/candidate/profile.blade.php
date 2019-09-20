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
        <div class="container candidate-detail">
            <div class="row">
                <?php
                $leftCol = 'col-sm-8';
                $rightCol = 'col-sm-4';
                $savedCheck = auth()->check() ?  \App\Models\SavedCandidate::where('candidate_id',$candidate->id)->where('user_id',auth()->id())->count() : false;
                ?>
                <div class="{{ $leftCol }}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @include('account.inc.candidate-info',['profile'=>$candidate->profile,'savedCheck'=>$savedCheck])
                        </div>
                    </div>
                </div>

                <div class="{{ $rightCol }}">
                    <div class="card">
                        <div class="card-heading mb-10">
                            <h3 class="mb-0 pb-0">Ứng viên liên quan</h3>
                        </div>

                        <div class="card-body cpGrid-div-list">
                            @if(count($relatedCandidates))
                                @foreach ($relatedCandidates as $relatedCandidate)
                                    @include('search.candidate.inc.item',['candidate'=>$relatedCandidate])
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!-- Advertising -->
        @include('layouts.inc.advertising.bottom')
    </div>

@endsection

@push('css-stack')

@endpush
@push('js-stack')
    <script src="{{ url('js/jspdf.min.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('js/employer.js?v=2-0-1') }}" type="text/javascript"></script>
@endpush
