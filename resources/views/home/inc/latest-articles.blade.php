@if (isset($latestArticles) and !empty($latestArticles))
    <?php
    //dd($latestArticles);
    ?>
    @include('home.inc.spacer')
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 page-content col-thin-right">
                    <h2 class="section-title text-center mt-20 mb-20">
                        {!! $latestArticles->title !!}
                    </h2>

                    <div class="row articles-list">
                        <?php
                        foreach($latestArticles->posts as $key => $post):
                        $post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
                        $post->created_at = $post->created_at->ago();
                        ?>
                        <div class="col-md-3">
                            @include('home.inc.article-item-grid')
                        </div>
                        <!--/.job-item-->
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
