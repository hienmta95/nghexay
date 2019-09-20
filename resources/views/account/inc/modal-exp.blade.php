{!! Form::open(['route' => 'account.update-profile', 'method' => 'put','id'=>'exp-form','class'=>'mt-10']) !!}
<div class="modal-body">
    {!! Form::hidden('type','experience_data') !!}
    @if(isset($item))
        {!! Form::hidden('index',request()->get('index')) !!}
        {!! Form::hidden('method','update') !!}
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="form-group is-required">
                <label for="uni_name"
                       class="form-label">Công ty</label>

                <input name="profile[experience_data][company_name]"
                       autocomplete="off"
                       placeholder="Nhập tên công ty" value="{!! isset($item->company_name) ? $item->company_name : null !!}"
                       type="text" rows="2"
                       class="form-control" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group"><label class="form-label">Chức danh</label>
                <input name="profile[experience_data][position]" required  value="{!! isset($item->position) ? $item->position : null !!}"
                       autocomplete="off" placeholder="Ví dụ: UI/UX Designer"
                       type="text" rows="2" class="form-control"><!----><!---->

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group is-required">
                <label for="name"
                       class="form-label">Từ tháng</label>
                <input autocomplete="off" required  value="{!! isset($item->from_date) ? $item->from_date : null !!}"
                       type="text" rows="2"
                       name="profile[experience_data][from_date]"
                       class="form-control datepicker">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Đến tháng</label>
                <input autocomplete="off" required  value="{!! isset($item->to_date) ? $item->to_date : null !!}"
                       type="text" rows="2"
                       name="profile[experience_data][to_date]"
                       class="form-control datepicker">

            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="description" class="form-label">Thông tin bổ
                    sung</label><textarea
                        placeholder="Thông tin chi tiết quá trình học tập, hoạt động ngoại khóa... (nếu có)"
                        type="textarea" rows="2" autocomplete="off"
                        name="profile[experience_data][other]"
                        class="form-control ckeditor"
                        style="height: 117px;">{!! isset($item->other) ? $item->other : null !!}</textarea>

            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
    <button type="submit" class="btn btn-primary" id="add-experience"
            data-type="experience">Lưu
        lại
    </button>
</div>
{!! Form::close() !!}

<script>
    //$('.datepicker').datepicker();
    $('#exp-form textarea').each(function(){
        $(this).summernote({
            airMode: true,
            height:200,
            placeholder: $(this).attr('placeholder')
        });
    });
</script>