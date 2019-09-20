<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">Hồ sơ mới xem</h4>
        <a class="label label-primary pull-right" href="/account/viewed-candidates">Xem tất cả</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">

                <thead class="bg-gray">
                <tr>
                    <th class="text-center" style="width: 100px">
                        ID
                    </th>
                    <th class="text-center">
                        Tên ứng viên
                    </th>
                    <th class="text-center">Ngày xem</th>
                </tr>

                </thead>
                @foreach($latestViewedCandidates as $latestViewedCandidate)
                    <tr>
                        <td class="text-center">
                            {!! $latestViewedCandidate->hash !!}
                        </td>
                        <td class="text-left">
                            {!! $latestViewedCandidate->name !!}
                        </td>
                        <td class="text-center">
                            {!! \Carbon\Carbon::parse($latestViewedCandidate->created_at)->format('d-m-Y') !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
