<div class="col-md-12">
    <div class="breadcrumbs">
        <ol class="breadcrumb pull-left">
            <li><a href="{!! url('/') !!}"><i class="icon-home fa"></i></a></li>
            <li>
                <a href="{!! url('cam-nang') !!}">
                    Cẩm nang
                </a>
            </li>
            @if(isset($category) && $category != null)
            <li>
                <a href="{!! url('cam-nang/c-'.$category->slug) !!}">
                    {!! $category->name !!}
                </a>
            </li>
            @endif


            @if(isset($detail) && $detail != null)
                <li>
                    <a href="{!! url('cam-nang/d-'.$detail->slug) !!}">
                        {!! $detail->title !!}
                    </a>
                </li>
            @endif
        </ol>
    </div>
</div>
