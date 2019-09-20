<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">Việc làm phù hợp</h4>
        <a class="label label-primary pull-right" href="/latest-jobs">Xem tất cả</a>
    </div>
    <div class="card-body">
        @if(count($suitableJobs) >0)
            <div class="row">
            @foreach($suitableJobs as $suitableJob)
                <div class="col-md-4">
                @include('home.inc.item-grid',['post'=>$suitableJob])
                </div>
            @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Bạn vui lòng cập nhật hồ sơ để được giới thiệu việc làm phù hợp với bạn
            </div>
        @endif
    </div>
</div>
