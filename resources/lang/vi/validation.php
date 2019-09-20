<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'active_url' => 'Trường :attribute is not a valid URL.',
    'after' => 'Trường :attribute phải  là một ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải a date after or equal to :date.',
    'alpha' => 'Trường :attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ có thể chứa các chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ có thể chứa các chữ cái và số.',
    'array' => 'Trường :attribute phải an array.',
    'before' => 'Trường :attribute phải là một ngày trước ngày :date.',
    'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng ngày :date.',
    'between' => [
        'numeric' => 'Trường :attribute phải có từ :min tới :max.',
        'file' => 'Trường :attribute phải nằm trong khoảng :min và :max kilobytes.',
        'string' => 'Trường :attribute phải nằm trong khoảng :min và :max ký tự.',
        'array' => 'Trường :attribute phải nằm trong khoảng :min và :max items.',
    ],
    'boolean' => 'Trường :attribute field phải true or false.',
    'confirmed' => 'Trường :attribute confirmation does not match.',
    'date' => 'Trường :attribute không phải ngày hợp lệ.',
    'date_format' => 'Trường :attribute không đúng format :format.',
    'different' => 'Trường :attribute và :other phải khác nhau.',
    'digits' => 'Trường :attribute phải :digits số.',
    'digits_between' => 'Trường :attribute phải nằm trong khoảng :min và :max digits.',
    'dimensions' => 'Trường :attribute có kích thước không hợp lệ.',
    'distinct' => 'Trường :attribute bị trùng lặp giá trị.',
    'email' => 'Trường :attribute phải là địa chỉ email hợp lệ.',
    'exists' => 'Trường :attribute đã chọn không hợp lệ.',
    'file' => 'Trường :attribute phải là một file.',
    'filled' => 'Trường :attribute phải có giá trị.',
    'image' => 'Trường :attribute phải là hình ảnh.',
    'in' => 'Trường :attribute đã chọn không hợp lệ.',
    'in_array' => 'Trường :attribute không tồn tại trong :other.',
    'integer' => 'Trường :attribute phải an integer.',
    'ip' => 'Trường :attribute phải là một IP address  hợp lệ.',
    'ipv4' => 'Trường :attribute phải là IPv4 address hợp lệ.',
    'ipv6' => 'Trường :attribute phải là IPv6 address  hợp lệ.',
    'json' => 'Trường :attribute phải là một chuỗi hợp lệ.',
    'max' => [
        'numeric' => 'Trường :attribute có thể không lớn hơn :max.',
        'file' => 'Trường :attribute có thể không lớn hơn :max kilobytes.',
        'string' => 'Trường :attribute có thể không lớn hơn :max ký tự.',
        'array' => 'Trường :attribute có thể không có nhiều hơn :max items.',
    ],
    'mimes' => 'Trường :attribute phải a file of type: :values.',
    'mimetypes' => 'Trường :attribute phải a file of type: :values.',
    'min' => [
        'numeric' => 'Trường :attribute phải ít nhất :min.',
        'file' => 'Trường :attribute phải ít nhất :min kilobytes.',
        'string' => 'Trường :attribute phải ít nhất :min ký tự.',
        'array' => 'Trường :attribute phải có ít nhất :min items.',
    ],
    'not_in' => 'Thuộc tính :attribute đã chọn không hợp lệ.',
    'not_regex' => 'Định dạng :attribute không hợp lệ.',
    'numeric' => 'Thuộc tính: phải là số.',
    'present' => 'Trường :attribute phải có.',
    'regex' => 'Định dạng :attribute không hợp lệ.',
    'required' => 'Trường :attribute là bắt buộc.',
    'required_if' => 'Trường :attribute được yêu cầu khi :other là :value.',
    'required_unless' => 'Trường :attribute được yêu cầu trừ khi :other có mặt trong :values.',
    'required_with' => 'Trường :attribute được yêu cầu khi giá trị trong :values  hiện diện.',
    'required_with_all' => 'Trường :attribute được yêu cầu khi: giá trị hiện diện.',
    'required_without' => 'Trường :attribute được yêu cầu khi không có giá trị nào trong :values .',
    'required_without_all' => 'Trường :attribute là bắt buộc khi không có giá trị nào của :values hiển thị.',
    'same' => 'Trường :attribute và trường :other phải khớp.',
    'size' => [
        'numeric' => 'Trường :attribute phải :size.',
        'file' => 'Trường :attribute phải :size kilobytes.',
        'string' => 'Trường :attribute phải :size ký tự.',
        'array' => 'Trường :attribute phải chứa :size items.',
    ],
    'string' => 'Trường :attribute phải là một chuỗi.',
    'timezone' => 'Trường :attribute phải đúng timezone.',
    'unique' => 'Trường :attribute đã được sử dụng.',
    'uploaded' => 'Trường :attribute không thể upload.',
    'url' => 'Trường :attribute không đúng định dạng.',

    // Blacklist - Whitelist
    'whitelist_email' => 'Địa chỉ email này bị liệt vào danh sách đen.',
    'whitelist_domain' => 'Tên miền của địa chỉ email của bạn bị liệt vào danh sách đen.',
    'whitelist_word' => 'Trường :attribute  chứa một từ hoặc cụm từ bị cấm',
    'whitelist_word_title' => 'Trường :attribute  chứa một từ hoặc cụm từ bị cấm',
    // Custom Rules
    'mb_between' => 'Trường :attribute phải nằm trong khoảng :min và :max ký tự.',
    'recaptcha' => 'Trường :attribute field is not correct.',
    'phone' => 'Trường :attribute field contains an invalid number.',
    'dumbpwd' => 'Mật khẩu của bạn quá đơn giản, vui lòng chọn một mật khẩu khác!',
    'phone_number' => 'Số điện thoại bạn nhập không hợp lệ.',
    'valid_username' => 'Trường :attribute field phải an alphanumeric string.',
    'allowed_username' => 'Trường :attribute is not allowed.',
    'language_check_locale' => 'Trường :attribute field không hợp lệ.',
    'country_check_locale' => 'Trường :attribute field không hợp lệ.',
    'check_currencies' => 'Trường :attribute field không hợp lệ.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [

        'database_connection' => [
            'required' => 'Can\'t connect to MySQL server',
        ],
        'database_not_empty' => [
            'required' => 'The database is not empty',
        ],
        'promo_code_not_valid' => [
            'required' => 'Mã khuyến mãi không hợp lệ',
        ],
        'smtp_valid' => [
            'required' => 'Can\'t connect to SMTP server',
        ],
        'yaml_parse_error' => [
            'required' => 'Can\'t parse yaml. Please check the syntax',
        ],
        'file_not_found' => [
            'required' => 'File not found.',
        ],
        'not_zip_archive' => [
            'required' => 'The file is not a zip package.',
        ],
        'zip_archive_unvalid' => [
            'required' => 'Cannot read the package.',
        ],
        'custom_criteria_empty' => [
            'required' => 'Custom criteria cannot be empty',
        ],
        'php_bin_path_invalid' => [
            'required' => 'Invalid PHP executable. Please check again.',
        ],
        'can_not_empty_database' => [
            'required' => 'Cannot DROP certain tables, please cleanup your database manually and try again.',
        ],
        'recaptcha_invalid' => [
            'required' => 'Invalid reCAPTCHA check.',
        ],
        'payment_method_not_valid' => [
            'required' => 'Something went wrong with payment method setting. Please check again.',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [

        'gender' => 'giới tính',
        'gender_id' => 'giới tính',
        'name' => 'tên',
        'first_name' => 'Tên',
        'last_name' => 'Họ',
        'user_type' => 'user type',
        'user_type_id' => 'user type',
        'country' => 'country',
        'country_code' => 'country',
        'phone' => 'điện thoại',
        'address' => 'địa chỉ',
        'mobile' => 'di động',
        'sex' => 'giới tính',
        'year' => 'năm',
        'month' => 'tháng',
        'day' => 'ngày',
        'hour' => 'giờ',
        'minute' => 'phút',
        'second' => 'giây',
        'username' => 'username',
        'email' => 'email',
        'password' => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu',
        'g-recaptcha-response' => 'captcha',
        'term' => 'điều khoản',
        'category' => 'danh mục',
        'category_id' => 'danh mục',
        'post_type' => 'post type',
        'post_type_id' => 'post type',
        'title' => 'tiêu đề',
        'body' => 'body',
        'description' => 'nội dung',
        'excerpt' => 'excerpt',
        'date' => 'ngày',
        'time' => 'thời gian',
        'available' => 'available',
        'size' => 'kích thước',
        'price' => 'giá',
        'salary' => 'lương',
        'contact_name' => 'name',
        'location' => 'địa điểm',
        'admin_code' => 'location',
        'city' => 'thành phố',
        'city_id' => 'thành phố',
        'package' => 'gói',
        'package_id' => 'gói',
        'payment_method' => 'phương thức thanh toán',
        'payment_method_id' => 'phương thức thanh toán',
        'sender_name' => 'tên',
        'subject' => 'tiêu đề',
        'message' => 'nội dung',
        'report_type' => 'report type',
        'report_type_id' => 'report type',
        'file' => 'file',
        'filename' => 'filename',
        'picture' => 'picture',
        'resume' => 'resume',
        'login' => 'đăng nhập',
        'code' => 'code',
        'token' => 'token',
        'comment' => 'bình luận',
        'rating' => 'rating',
        'logo' => 'logo',
        'business_license' => 'giấy phép kinh doanh',
        'company_id' => 'công ty',
        'resume_id' => 'resume',
        'company.logo' => 'logo',
        'company.business_license' => 'giấy phép kinh doanh',
        'company.name' => 'tên doanh nghiệp',
        'company.description' => 'thông tin doanh nghiệp',
        'company.country_code' => 'quốc gia',
        'company.city_id' => 'thành phố',
        'company.address' => 'địa chỉ',
        'company.phone' => 'điện thoại',
        'company.fax' => 'company fax',
        'company.email' => 'email',
        'company.website' => 'website',
        'resume.filename' => 'resume file',
        'locale' => 'locale',
        'currencies' => 'tiền tệ',

    ],

];
