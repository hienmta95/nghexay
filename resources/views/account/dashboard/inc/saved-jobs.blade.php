<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">Việc làm đã lưu</h4>
        <a class="label label-primary pull-right" href="/account/favorite">Xem tất cả</a>
    </div>
    <div class="card-body">
        @if(count($savedJobs) > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-gray">
                    <tr>
                        <th>
                            Việc làm - Vị trí
                        </th>
                        <th>
                            Hạn nộp
                        </th>
                    </tr>
                    </thead>
                    @foreach($savedJobs as $post)
                        <?php
                        //$post = \App\Models\Post::find($appliedJob->subject_id);
                        ?>
                        <tr>
                            <td>
                                <a href="{!! $post->getUrl() !!}"
                                   target="_blank">{!! str_limit($post->title,40) !!}</a>
                            </td>
                            <td>
                                {!! \Carbon\Carbon::parse($post->deadline)->format('d-m-Y') !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Bạn chưa lưu công việc nào
            </div>
        @endif
    </div>
</div>
