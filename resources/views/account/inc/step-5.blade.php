@if(isset($viewonly) && $viewonly == true)

        <div class="panelx panel-default setup-content" id="step-4">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-fw fa-shopping-bag"></i> Công việc mong muốn</h3>
            </div>
            <div class="panel-body">
                <div id="edu-holder" class="edu-holder">
                    <div id="expected-holder" class="expected-holder">

                        @include('account.inc.expected_item')
                    </div>
                </div>

            </div>
        </div>

@else
    <div class="panelx panel-default setup-content" id="step-5">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-fw fa-bank"></i> Công việc mong muốn</h3>
        </div>
        <div class="panel-body">
            <div id="expected-holder" class="expected-holder">
                   @include('account.inc.expected_item')
            </div>

            <div class="modal fade" id="expectedModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-center">
                    <div class="modal-dialog .modal-align-center">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="expectedModalLabel">
                                    Công việc mong muốn của bạn
                                </h4>
                                <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span><span class="sr-only">Đóng</span>

                                </button>


                            </div>
                            {!! Form::open(['route' => 'account.update-profile-expected-job', 'method' => 'put','id'=>'expected-form','class'=>'mt-10']) !!}
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label for="uni_name"
                                                   class="form-label">Tiêu đề công việc</label>
                                            {!! Form::text('profile[expected_job_title]',$profile->expected_job_title,['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label for="uni_name"
                                                   class="form-label">Nơi làm việc </label>
                                            {!! Form::select('profile[expected_job_city_id]',$cities->pluck('name','id')->toArray(),optional($profile)->expected_job_city_id,['class'=>'form-control ']) !!}
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group"><label class="form-label">Ngành nghề</label>
                                            {!! Form::select('profile[expected_job_category_id]',$categories->pluck('name','id')->toArray(),optional($profile)->expected_job_category_id,['class'=>'form-control ']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label for="name"
                                                   class="form-label">Loại hình làm việc</label>
                                            {!! Form::select('profile[expected_job_post_type_id]',$postTypes->pluck('name','id')->toArray(),optional($profile)->expected_job_post_type_id,['class'=>'form-control ']) !!}

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group is-required">
                                            <label for="name"
                                                   class="form-label">Cấp bậc mong muốn</label>

                                            {!! Form::select('profile[expected_job_position_id]',$positionTypes->pluck('name','id')->toArray(),optional($profile)->expected_job_position_id,['class'=>'form-control ']) !!}

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Mức lương mong muốn</label>

                                            <div class="input-group my-group">
                                                <input autocomplete="off" required
                                                       value="{!! optional($profile)->expected_job_salary !!}"
                                                       type="number"
                                                       name="profile[expected_job_salary]"
                                                       class="form-control">
                                                <span class="input-group-addon">VND</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Mô tả mục tiêu nghề
                                                nghiệp</label><textarea
                                                    placeholder="Mô tả, giới thiệu về định hướng công việc của bản thân trong tương lai ngắn hạn hoặc dài hạn."
                                                    type="textarea" rows="2" autocomplete="off"
                                                    name="profile[other]"
                                                    class="form-control"
                                                    style="height: 117px;">{!! $profile->other !!}</textarea>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" id="add-expected_job"
                                        data-type="expected_job_data">Lưu
                                    lại
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#expectedModal">
                <i class="fa fa-plus"></i> Cập nhật thông tin
            </button>
            <div class="clearfix"></div>
        </div>
    </div>


    @push('js-stack')
        <script>
            $(document).ready(function () {

                $('.datepicker').datepicker();
                $('#expected-form').ajaxForm({
                    success: function (res) {
                        console.log(res);
                        if (res.success == true) {
                            $('#expectedModal').modal('hide');
                            var data = res.data;
                            var $txt = '';

                            $('#expected-holder').append($txt);
                            $(this).clearForm();
                            toastr.success('Thông tin đã được cập nhật');
                        } else {
                            toastr.success('Có lỗi xảy ra, bạn vui lòng thử lại');
                        }

                    }
                });
            });

        </script>
    @endpush
@endif
