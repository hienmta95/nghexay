@extends('layouts.master')

@section('search')
    @parent
@endsection

@section('content')
    <div class="main-container" id="homepage">
        @include('common.alert')
        @if (isset($sections) and $sections->count() > 0)
            @foreach($sections as $section)
                @if (view()->exists($section->view))
                    @include($section->view, ['firstSection' => $loop->first])
                @endif
            @endforeach
        @endif

    </div>
@endsection

@section('after_scripts')
@endsection
