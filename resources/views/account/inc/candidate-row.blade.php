<table class="table">

    <thead class="bg-gray">
    <tr>
        <th class="text-center" style="width: 100px">
            ID
        </th>
        <th class="text-center">
            Tên ứng viên
        </th>
        <th class="text-center">
            Email
        </th>
        <th class="text-center">
            Số điện thoại
        </th>
        <th class="text-center">
            Số điểm
        </th>
        <th class="text-center">Ngày xem</th>
        <th class="text-center">
            Thao tác
        </th>
    </tr>

    </thead>
    @foreach($candidates as $candidate)
        <tr>
            <td class="text-center">
                <a href="{!! route('search.view-profile',$candidate->hash) !!}"
                   data-toggle="modal" data-target="#candidateModal" data-remote="false"
                   data-hash="{!! $candidate->hash !!}"
                   class="view-profile">
                    {!! $candidate->hash !!}
                </a>
            </td>
            <td class="text-left">
                <a href="{!! route('search.view-profile',$candidate->hash) !!}"
                   data-toggle="modal" data-target="#candidateModal" data-remote="false"
                   data-hash="{!! $candidate->hash !!}"
                   class="view-profile">
                    {!! $candidate->name !!}
                </a>
            </td>
            <td class="text-center">
                {!! $candidate->email !!}
            </td>
            <td class="text-center">
                {!! $candidate->phone !!}
            </td>
            <td class="text-center">
                {!! optional($candidate->profile)->getPoint() !!}
            </td>
            <td class="text-center">
                {!! \Carbon\Carbon::parse($candidate->created_at)->format('d-m-Y') !!}
            </td>
            <td class="text-center">
                <a href="{!! route('search.view-profile',$candidate->hash) !!}"
                   data-toggle="modal" data-target="#candidateModal" data-remote="false"
                   data-hash="{!! $candidate->hash !!}"
                   class="btn btn-primary btn-sm view-profile">
                    <i class="fa fa-eye"></i>
                </a>
            </td>
        </tr>
    @endforeach
</table>
<div class="clearfix"></div>
<div class="pull-right">
    {!! $candidates->links() !!}
</div>
