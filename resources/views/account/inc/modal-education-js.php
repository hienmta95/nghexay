<script id="edu-template" type="text/x-handlebars-template">
    <div>
        <div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group is-required">
                        <label for="uni_name"
                               class="form-label">Trường, cơ sở, trung tâm đào tạo</label>

                        <input name="profile[education_data][{{i}}][school_name]"
                               autocomplete="off"
                               placeholder="Nhập tên trường"
                               type="text" rows="2"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label class="form-label">Khoa đào tạo</label>
                        <input name="profile[education_data][{{i}}][faculty_name]"
                               autocomplete="off" placeholder="Vui lòng nhập tên khoa"
                               type="text" rows="2" class="form-control"><!----><!---->

                    </div>
                </div>
            </div>
        </div>
        <div class="el-col el-col-24">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group is-required">
                        <label for="name"
                               class="form-label">Tên bằng cấp chứng chỉ</label>
                        <input autocomplete="off"
                               placeholder="VD: Cử nhân luật, Kỹ sư CNTT, Chứng chỉ nghề điện dân dụng..."
                               type="text" rows="2"
                               name="profile[education_data][{{i}}][degree_name]"
                               class="form-control">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Chuyên ngành đào tạo</label>
                        <input autocomplete="off"
                               placeholder="VD: Công nghệ thông tin, Kế toán..."
                               type="text" rows="2"
                               name="profile[education_data][{{i}}][specialized]"
                               class="form-control">

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"><label for="begin" class="form-label">Khóa học</label>
                        <input type="number" min="1970" max="2025" class="form-control"
                               name="profile[education_data][{{i}}][year]">
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group is-required">
                        <label for="type"
                               class="form-label">Xếp loại</label>
                        <select name="profile[education_data][{{i}}][rating]" class="form-control">
                            <option value="Yếu">Yếu</option>
                            <option value="Trung bình">Trung bình</option>
                            <option value="Khá">Khá</option>
                            <option value="Giỏi">Giỏi</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="el-col el-col-24">
                <div class="form-group">
                    <label for="description" class="form-label">Thông tin bổ sung</label><textarea
                            placeholder="Thông tin chi tiết quá trình học tập, hoạt động ngoại khóa... (nếu có)"
                            type="textarea" rows="2" autocomplete="off"
                            name="profile[education_data][{{i}}][other]"
                            class="form-control"
                            style="height: 117px;"></textarea>

                </div>
            </div>
        </div>
    </div>
</script>
