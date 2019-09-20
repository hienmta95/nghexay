<?php
?>
@if (isset($latestArticles) and !empty($latestArticles))

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="jp_hiring_slider_main_wrapper">
                <div class="jp_career_slider_heading_wrapper">
                    <h2>{!! $latestArticles->title !!}</h2>
                </div>
                <div class="jp_career_slider_wrapper">
                    <div class="owl-carousel owl-theme">

                        <?php
                        foreach($latestArticles->posts as $key => $post):
                        $post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
                        $post->created_at = $post->created_at->ago();
                        ?>
                        <div class="item jp_recent_main">
                            <div class="jp_career_main_box_wrapper">
                                <div class="jp_career_img_wrapper">
                                    <img src="{{ resizeThumb(\App\Models\Article::getLogo($post->logo), 360,190,'false','true') }}" alt="{!! $post->title !!}" style="max-height: 190px" />
                                </div>
                                <div class="jp_career_cont_wrapper">
                                    {{--<p><i class="fa fa-calendar"></i>&nbsp;&nbsp; <a href="{!! url('cam-nang/d-'.$post->slug) !!}">20 OCT, 2017</a></p>--}}
                                    <h3><a href="{!! url('cam-nang/d-'.$post->slug) !!}">                {{ ucwords(mb_strtolower($post->title)) }}
                                        </a></h3>
                                    {{--<p>Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat.</p>--}}
                                    <a href="{{ localUrl($post->country_code, 'cam-nang/d-'.$post->slug) }}" title="{!! $post->title !!}"><i
                                                class="la la-book"></i> Chi tiết</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif