<div class="modal-header">
    <a class="close" data-dismiss="modal" style="margin-top: 0">&times;</a>
    Hồ sơ của {!! $candidate->name !!}
</div>
<div class="modal-body">
    <div class="candidate-detail">
        @include('account.inc.candidate-info')
    </div>

</div>
<div class="modal-footer">
    @if(isset($savedCheck) && $savedCheck == 0)
        <a class="btn btn-success save-profile" data-id="{!! $candidate->id !!}" data-hash="{!! $candidate->hash !!}"><i
                    class="fa fa-file"></i> Lưu hồ sơ</a>
    @else
        <a class="btn btn-danger save-profile" data-id="{!! $candidate->id !!}" data-hash="{!! $candidate->hash !!}"><i
                    class="fa fa-file"></i> Bỏ lưu hồ sơ</a>
    @endif
    <a class="btn btn-default" data-dismiss="modal"> <i class="fa fa-close"></i> Đóng</a>
</div>
