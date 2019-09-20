function checkAll(bx) {
    var chkinput = document.getElementsByTagName('input');
    for (var i = 0; i < chkinput.length; i++) {
        if (chkinput[i].type == 'checkbox') {
            chkinput[i].checked = bx.checked;
        }
    }
}


$(document).ready(function () {
    $("#candidateModal").on("show.bs.modal", function (e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-content").load(link.attr("href"));
    });

    function saveProfile(id) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/ajax/candidate/save',
            data: {id: id},
            dataType: 'JSON',
            method: 'POST',
            success: function (res) {
                //$('#candidateModal').modal('hide');
                if (typeof res.logged == "undefined") {
                    return false;
                }

                /* Guest Users - Need to Log In */
                if (res.logged == '0') {
                    $('#quickLogin').modal();
                    return false;
                }

                if (res.status == 1) {
                    toastr.success(res.msg);
                    if (res.action == 'drop') {
                        $('.save-profile').removeClass('btn-danger').addClass('btn-success').html('Lưu hồ sơ');
                    } else {
                        $('.save-profile').removeClass('btn-success').addClass('btn-danger').html('Bỏ lưu hồ sơ');
                    }
                } else {
                    toastr.error('Có lỗi xảy ra, bạn vui lòng thử lại');
                }
            }

        });
    }

    $(document).on('click', '.save-profile', function (e) {
        var id = $(this).data('id');
        saveProfile(id);
    });

    $(document).on('click', '.paid-profile', function (e) {
        var id = $(this).data('id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/ajax/candidate/pay',
            data: {id: id},
            dataType: 'JSON',
            method: 'POST',
            success: function (res) {
                //$('#candidateModal').modal('hide');
                if (typeof res.logged == "undefined") {
                    return false;
                }

                /* Guest Users - Need to Log In */
                if (res.logged == '0') {
                    $('#quickLogin').modal();
                    return false;
                }
                if (res.status == 1) {
                    toastr.success(res.msg);
                    $('#contact-info').html(res.content);
                } else {
                    toastr.error(res.msg);
                }
            }

        });
    });
});
