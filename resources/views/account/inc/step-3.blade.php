<?php

$tagItems = [];
if ($profile->skill_data != null) {
    $tagItems = explode(',', $profile->skill_data);
}

?>
@if(isset($viewonly) && $viewonly == true)
    @if($tagItems != null)
        <div class="panelx panel-default setup-content" id="step-4">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-bank"></i> Kỹ năng</h3>
            </div>
            <div class="panel-body">
                <div id="skill-holder" class="edu-holder">
                    @foreach($tagItems as $tagItem)
                        <span class="label label-default mr-5 label-skill">
                            {!! $tagItem !!}
                        </span>
                    @endforeach
                </div>

            </div>
        </div>
    @endif
@else
    <div class="panelx panel-default setup-content" id="step-3">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-fw fa-lightbulb-o"></i> Kỹ năng</h3>
        </div>
        <div class="panel-body">
            <p class="mb-10">
                Thêm kỹ năng nghề nghiệp đề nhận được những đề nghị công việc phù hợp hơn
            </p>
            <div id="skill-holder" class="skill-holder">

                <input name="profile[skill_data][school_name]"
                       autocomplete="off"
                       placeholder="Ví dụ: Word, Excel.."
                       type="text"
                       value="{!! $profile->skill_data !!}"
                       class="skill-selecter tm-input form-control-x" required>
            </div>

        </div>
    </div>


    @push('js-stack')
        <script>
            $(document).ready(function () {

                jQuery(".tm-input").tagsManager({
                    prefilled: {!! json_encode($tagItems) !!},
                    AjaxPush: '{!! route('account.update-profile-skill') !!}',
                    AjaxPushAllTags: true,
                    AjaxPushParameters: {'_token': '{!! csrf_token() !!}', 'method': 'put', 'type': 'skill_data'}
                });

                $('#skill-form').ajaxForm({
                    success: function (res) {
                        console.log(res);
                        if (res.success == true) {
                            $('#skillModal').modal('hide');
                            var data = res.data;
                            var $txt = '<div class="skill-item" data-user-id="3" data-key="0">\n' +
                                '                        <h4>\n' +
                                '                            ' + data.faculty_name + '\n' +
                                '                        </h4>\n' +
                                '                        <p>\n' +
                                '                            Trường: ' + data.school_name + '\n' +
                                '                        </p>\n' +
                                '                        <p>\n' +
                                '                            Xếp loại: ' + data.rating + '\n' +
                                '                        </p>\n' +
                                '                    </div>';

                            $('#skill-holder').append($txt);
                            $(this).clearForm();
                            toastr.success('Thông tin đã được cập nhật');
                        }

                    }
                });
            });

        </script>
    @endpush
@endif
