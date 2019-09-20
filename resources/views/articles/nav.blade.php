<nav class="navbar navbar-default navbar-blog">
    <div class="container">
        <div class="collapse navbar-collapse" id="blog-navbar">
            <ul class="nav navbar-nav">
                <li><a href="{!! url('cam-nang') !!}"><i class="fa fa-home"></i></a></li>
                @foreach($categories as $category)
                    <li><a href="{!! url('cam-nang/c-'.$category->slug) !!}">{!! $category->name !!}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

