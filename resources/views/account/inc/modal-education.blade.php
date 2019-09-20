
                {!! Form::open(['route' => 'account.update-profile', 'method' => 'put','id'=>'edu-form','class'=>'mt-10']) !!}
                @if(isset($item))
                    {!! Form::hidden('index',request()->get('index')) !!}
                    {!! Form::hidden('method','update') !!}
                @endif
                <div class="modal-body">
                    {!! Form::hidden('type','education_data') !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group is-required">
                                <label for="uni_name"
                                       class="form-label">Loại hình đào tạo</label>
                                {!! Form::select('profile[education_data][edu_type]',$educationTypes->pluck('name','id')->toArray(),isset($item->edu_type) ? $item->edu_type : null,['class'=>'form-control ','placeholder'=>'Chọn loại hình đào tạo']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group is-required">
                                <label for="uni_name"
                                       class="form-label">Trường, cơ sở, trung tâm đào tạo</label>

                                <input name="profile[education_data][school_name]"
                                       autocomplete="off"
                                       placeholder="Nhập tên trường" value="{!! isset($item->school_name) ? $item->school_name : null  !!}"
                                       type="text" rows="2"
                                       class="form-control" required>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"><label class="form-label">Khoa đào tạo</label>
                                <input name="profile[education_data][faculty_name]" required
                                       autocomplete="off" placeholder="Vui lòng nhập tên khoa"  value="{!! isset($item->faculty_name) ? $item->faculty_name : null  !!}"
                                       type="text" rows="2" class="form-control"><!----><!---->

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group is-required">
                                <label for="name"
                                       class="form-label">Tên bằng cấp chứng chỉ</label>
                                <input autocomplete="off" required  value="{!! isset($item->degree_name) ? $item->degree_name : null  !!}"
                                       placeholder="VD: Cử nhân luật, Kỹ sư CNTT, Chứng chỉ nghề điện dân dụng..."
                                       type="text" rows="2"
                                       name="profile[education_data][degree_name]"
                                       class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Chuyên ngành đào tạo</label>
                                <input autocomplete="off" required  value="{!! isset($item->specialized) ? $item->specialized : null  !!}"
                                       placeholder="VD: Công nghệ thông tin, Kế toán..."
                                       type="text" rows="2"
                                       name="profile[education_data][specialized]"
                                       class="form-control">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label for="begin" class="form-label">Khóa học</label>

                                <input type="number" min="1970" max="2025" class="form-control" required  value="{!! isset($item->year) ? $item->year : null  !!}"
                                       name="profile[education_data][year]">
                            </div>

                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group is-required">
                                <label for="type"
                                       class="form-label">Xếp loại</label>
                                <?php
                                    $rates = [
                                        'Yếu','Trung bình','Khá','Giỏi'
                                    ]
                                ?>
                                <select name="profile[education_data][rating]" class="form-control sselecter"
                                        required>
                                    @foreach($rates as $key => $rate)
                                        <option value="{!! $rate !!}" @if(isset($item->rating) && $item->rating == $rate) selected @endif >{!! $rate !!}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Thông tin bổ
                                    sung</label><textarea
                                        placeholder="Thông tin chi tiết quá trình học tập, hoạt động ngoại khóa... (nếu có)"
                                        type="textarea" rows="2" autocomplete="off"
                                        name="profile[education_data][other]"
                                        class="form-control"
                                        style="height: 117px;">{!! isset($item->other) ? $item->other : null  !!}</textarea>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="add-education" data-type="education">Lưu lại</button>
                </div>
                {!! Form::close() !!}

                <script>
                    $('textarea').each(function(){
                        $(this).summernote({
                            airMode: true,
                            height:200,
                            placeholder: $(this).attr('placeholder')
                        });
                    });
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