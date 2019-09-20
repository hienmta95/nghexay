<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">Việc làm đã ứng tuyển</h4>
        <a class="label label-primary pull-right" href="/latest-jobs">Xem tất cả</a>
    </div>
    <div class="card-body">
        @if(count($appliedJobs) > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead class="bg-gray">
                    <tr>
                        <th>
                            Tin tuyển dụng
                        </th>
                        <th>
                            Ngày nộp
                        </th>
                    </tr>
                    </thead>
                    @foreach($appliedJobs as $appliedJob)
                        <?php
                        $post = \App\Models\Post::find($appliedJob->subject_id);
                        ?>
                        <tr>
                            <td>
                                <a href="{!! $post->getUrl() !!}"
                                   target="_blank">{!! str_limit($post->title,40) !!}</a>
                            </td>
                            <td>
                                {!! \Carbon\Carbon::parse($appliedJob->created_at)->format('d-m-Y') !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Bạn chưa ứng tuyển công việc nào
            </div>
        @endif
    </div>
</div>
