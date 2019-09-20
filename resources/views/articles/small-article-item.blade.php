<div class="item-list article-item">
    <div class="row">
        <div class="col-md-3 no-padding photobox">
            <div class="add-image">
                <a href="{!! url('cam-nang/d-'.$article->slug) !!}">
                    <img alt="{{ $article->title }}"
                         src="{{ resize(\App\Models\Post::getLogo($article->logo), 'large') }}"
                         class="thumbnail no-margin">
                </a>
            </div>
        </div>
        <div class="col-md-9  add-desc-box">
            <div class="add-details jobs-item">
                <h5 class="job-title">
                    <a href="{!! url('cam-nang/d-'.$article->slug) !!}">
                        {{ $article->title }}
                    </a>
                </h5>
                <span class="info-row">
                    {!! str_limit(strip_tags($article->description),100) !!}
                </span>
            </div>
        </div>

        <!--/.add-desc-box-->
    </div>
</div>
