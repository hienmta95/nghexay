<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">Tin tuyển dụng mới nhất</h4>
        <a class="label label-success pull-right" href="/account/my-posts">Xem tất cả</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table">
            <thead class="bg-gray">
            <tr>
                <th>
                    Tiêu đề
                </th>
                <th>
                    Ngày đăng
                </th>
            </tr>
            </thead>
            @foreach($latestPosts as $latestPost)
                <tr>
                    <td>
                        <a href="{!! $latestPost->getUrl() !!}"
                           target="_blank">{!! str_limit($latestPost->title,40) !!}</a>
                    </td>
                    <td>
                        {!! \Carbon\Carbon::parse($latestPost->created_at)->format('d-m-Y') !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    </div>
</div>
