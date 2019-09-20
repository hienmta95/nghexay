<?php
$eduData = json_decode($profile->education_data);
?>
@if(isset($viewonly) && $viewonly == true)
    @if($eduData != null)
        <div class="panelx panel-default setup-content" id="step-4">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-bank"></i> Học vấn</h3>
            </div>
            <div class="panel-body">
                <div id="edu-holder" class="edu-holder">
                    @if($eduData != null)
                        @foreach ($eduData as $key => $edu)
                            @include('account.inc.profile-edu-item')
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    @endif
@else
    <div class="panelx panel-default setup-content" id="step-2">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-fw fa-bank"></i> Học vấn</h3>
        </div>
        <div class="panel-body">
            <p class="mb-10">
                Mô tả toàn bộ quá trình học vấn của bạn, cũng như các bằng cấp bạn đã được và các khóa huấn luyện bạn đã
                tham gia
            </p>
            <div id="edu-holder" class="edu-holder">
                @if($eduData != null)
                    @foreach ($eduData as $key => $edu)
                        @include('account.inc.profile-edu-item')
                    @endforeach
                @endif
            </div>
            <div class="modal fade" id="eduModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-center">
                    <div class="modal-dialog .modal-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="eduModalLabel">
                                    Thêm thông tin học vấn
                                </h4>
                                <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span><span class="sr-only">Close</span>

                                </button>


                            </div>
            @include('account.inc.modal-education')

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#eduModal">
                <i class="fa fa-plus"></i> Thêm thông tin
            </button>
            <div class="clearfix"></div>
        </div>
    </div>


    @push('js-stack')

        @include('account.inc.modal-education-js')
        <script>
            $(document).ready(function () {
                var eduSource = document.getElementById("edu-template").innerHTML;
                var eduTemplate = Handlebars.compile(eduSource);


                $('#edu-form').ajaxForm({
                    clearForm: true,
                    success: function (res) {
                        console.log(res);
                        if (res.success == true) {
                            $('#eduModal').modal('hide');
                            var data = res.data;
                            var $txt = '<div class="edu-item" data-user-id="3" data-key="0">\n' +
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

                            $('#edu-holder').append($txt);
                            $(this).clearForm();
                            toastr.success('Thông tin đã được cập nhật');
                        }

                    }
                });


            });

        </script>
    @endpush
@endif
