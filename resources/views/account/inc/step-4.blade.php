<?php
$expData = json_decode($profile->experience_data);
?>




@if(isset($viewonly) && $viewonly == true)
    @if($expData != null)
        <div class="panelx panel-default setup-content" id="step-4">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-bank"></i> Kinh nghiệm</h3>
            </div>
            <div class="panel-body">
                <div id="exp-holder" class="exp-holder">

                    @foreach ($expData as $key => $exp)
                        <div class="exp-item" data-user-id="{!! $profile->user_id !!}" data-key="{!! $key !!}">
                            <h4>
                                {!! $exp->position !!}
                            </h4>
                            <p>
                                <strong>Công ty:</strong> {!! $exp->company_name !!}
                            </p>
                            <p>
                                <strong>Thời gian:</strong> {!! $exp->from_date !!} - {!! $exp->to_date !!}
                            </p>
                            <div>
                                <p><strong>Chi tiết công việc</strong></p>
                                <p>
                                    {!! $exp->other !!}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @endif
@else
    <div class="panelx panel-default setup-content" id="step-4">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-fw fa-magic"></i> Kinh nghiệm</h3>
        </div>
        <div class="panel-body">
            <p class="mb-10">
                Mô tả kinh nghiệm làm việc của bạn càng chi tiết càng tốt
            </p>
            <div id="exp-holder" class="exp-holder">
                @if($expData != null)
                    @foreach ($expData as $key => $exp)
                        @include('account.inc.profile-exp-item')
                    @endforeach
                @endif
            </div>

            <div class="modal fade" id="expModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-center">
                    <div class="modal-dialog .modal-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="expModalLabel">
                                    Thêm kinh nghiệm làm việc
                                </h4>
                                <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span><span class="sr-only">Close</span>

                                </button>


                            </div>
                            @include('account.inc.modal-exp')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#expModal">
                <i class="fa fa-plus"></i> Thêm thông tin
            </button>
            <div class="clearfix"></div>
        </div>
    </div>


    @push('js-stack')

        <script>
            $(document).ready(function () {
                $('#exp-form').ajaxForm({
                    clearForm: true,        // clear all form fields after successful submit
                    //resetForm: true,
                    success: function (res) {
                        console.log(res);
                        if (res.success == true) {
                            $('#expModal').modal('hide');
                            var data = res.data;
                            var $txt = '<div class="exp-item" data-user-id="3" data-key="0">\n' +
                                '                        <h4>\n' +
                                '                            ' + data.position + '\n' +
                                '                        </h4>\n' +
                                '                        <p>\n' +
                                '                            Công ty : ' + data.company_name + '\n' +
                                '                        </p>\n' +
                                '                        <p>\n' +
                                '                            Thời gian: ' + data.from_date + ' - ' + data.to_date + '\n' +
                                '                        </p>\n' +
                                '                    </div>';

                            $('#exp-holder').append($txt);
                            $(this).clearForm();
                            toastr.success('Thông tin đã được cập nhật');
                        }

                    }
                });
            });

        </script>
    @endpush
@endif
