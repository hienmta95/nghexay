@extends('layouts.master')

@section('search')
    @parent
@endsection

@section('content')
    <div class="main-container" id="articles">
        @include('articles.nav')
        <div class="container">
            <div class="row">
                @include('articles.breadcrumb')
                <div class="col-sm-8 page-content">
                    <div class="card">
                        <div class="card-body">
                            <div class="article-detail">
                                <h1>
                                    {!! $article->title !!}
                                </h1>
                                {!! $article->description !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="box-title no-border">
                            <div class="inner">
                                <h2>
                                    <span class="title-3">Mới nhất</span>
                                </h2>
                            </div>
                        </div>
                        <div class="bg-white pd-5">
                            @foreach($latestArticles as $larticle)
                                @include('articles.small-article-item', ['article' =>$larticle])
                            @endforeach
                        </div>
                        <div class="col-lg-12  box-title no-border">
                            <div class="inner">
                                <h2>
                                    <span class="title-3">Nổi bật</span>
                                </h2>
                            </div>
                        </div>
                        <div class="bg-white pd-5">
                        @foreach($featuredArticles as $farticle)
                            @include('articles.small-article-item', ['article' =>$farticle])
                        @endforeach
                        </div>


                </div>
            </div>
        </div>


    </div>
@endsection

@section('after_scripts')
@endsection
