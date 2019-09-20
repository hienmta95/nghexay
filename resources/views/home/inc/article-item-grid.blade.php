<div class="blog-card-wrap bg-white mb-4">
    <div class="blog-card-img">
        <a href="{!! url('cam-nang/d-'.$post->slug) !!}" title="{!! $post->title !!}"><img
                    src="{{  resizeThumb(\App\Models\Article::getLogo($post->logo), 360,190,'false','true') }}"
                    class="img-responsive card-img"></a>
    </div>
    <div class="blog-info  p-3">
        <h5 class="text-dark">
            <a class="blog-title text-dark" href="{!! url('cam-nang/d-'.$post->slug) !!}" title="{!! $post->title !!}">
                {{ ucwords(mb_strtolower($post->title)) }}
            </a>
        </h5>
        <a href="{{  localUrl($post->country_code, 'cam-nang/d-'.$post->slug) }}" title="{!! $post->title !!}"><i
                    class="la la-book"></i> Chi tiết</a>
    </div>
</div>
