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
                <div class="col-sm-9 page-content">
                    <div class="card">
                        <div class="card-body">
                            <div class="category-list">
                                @foreach($articles as $article)
                                    @include('articles.article-item', ['article' =>$article])
                                @endforeach

                                <div class="text-center">
                                    {!! $articles->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-lg-12  box-title no-border">
                            <div class="inner">
                                <h2>
                                    <span class="title-3">Nổi bật</span>
                                </h2>
                            </div>
                        </div>
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
