<?php

$viewable = false;
if (auth()->check()) {
    $paidCandidate = \App\Models\PaidCandidate::where('user_id', auth()->user()->id)->where('candidate_id', $candidate->id)->count();
    //dd($paidCandidate);
    if ($paidCandidate > 0) {
        $viewable = true;
    }
}
if(!isset($is_print) || $is_print == false ){
    $avatarUrl = $candidate->getAvatar(100,32);
}else{
    $type = pathinfo(\Storage::path($candidate->avatar), PATHINFO_EXTENSION);
    $avatarData = file_get_contents(\Storage::path($candidate->avatar), false);
    $avatarBase64Data = base64_encode($avatarData);
    $avatarUrl = 'data:image/' . $type . ';base64,' . $avatarBase64Data;
}
?>
<div class="inner-box mb-20 well">
    <div class="mw-box-item detail-header">
        <table style="width: 100%">
            <tr>
                <td style="width: 160px">
                    <div class="picture">
                        <img style="width: 160px; height: 160px;"
                             src="{!! $avatarUrl !!}"></div>
                </td>
                <td style="vertical-align: top">
                    <div class="info">
                                <h1 class="title">{!! $candidate->name !!}</h1>
                                @if($profile->expected_job_category_id != null)
                                    <p class="cv-title ">
                                        <strong>Ngành nghề quan tâm: </strong>
                                        {!! optional($profile->category)->name !!}
                                    </p>
                                @endif
                                <p><strong>Mã hồ sơ: </strong>{!! $candidate->profile->getProfileCode() !!}</p>
                                <p>
                                    <strong>Số năm kinh nghiệm: </strong>
                                    @if($profile->experience_years == 0 )
                                        1 năm
                                    @else
                                        {!! $profile->experience_years !!} năm
                                    @endif
                                </p>
                                <p><strong>Số lượt xem: </strong><span
                                            class="text_red">{!! $profile->visits !!}</span></p><!---->
                            </div>

                </td>
            </tr>
        </table>


    </div>
</div>

@if($viewable == false && !isset($is_print))
    <div class="alert alert-warning">
        Bạn cần <strong>{!! $profile->point !!} điểm</strong> để xem hồ sơ ứng viên này
    </div>
@endif


@if(!isset($is_print))


<div class="profile-actions mb-20">


    @if(isset($viewable) && $viewable == false)
        <a href="#" class="paid-profile btn btn-danger" data-id="{!! $candidate->id !!}"
           data-hash="{!! $candidate->hash !!}">
            <i class="fa fa-eye"></i> Xem hồ sơ
        </a>
    @endif
    @if(isset($savedCheck) && $savedCheck == 0)
        <a class="btn btn-success save-profile" data-id="{!! $candidate->id !!}"
           data-hash="{!! $candidate->hash !!}"><i
                    class="fa fa-file"></i> Lưu hồ sơ</a>
    @else
        <a class="btn btn-danger save-profile" data-id="{!! $candidate->id !!}"
           data-hash="{!! $candidate->hash !!}"><i
                    class="fa fa-file"></i> Bỏ lưu hồ sơ</a>
    @endif

    <a class="btn btn-info download-profile" href="{!! route('search.candidate.download-pdf',$candidate->hash) !!}"
       data-hash="{!! $candidate->hash !!}"><i
                class="fa fa-download"></i> Download PDF</a>
        @if($viewable == true)
    @if(isset($resume) && $resume != null)
            <a class="btn btn-default" href="{{ \Storage::url($resume->filename) }}" target="_blank">
                <i class="icon-attach-2"></i> {{ t('Download') }}
            </a>
        @endif
        @endif

</div>
@endif

<div class="panelx panel-default">
    <div class="panel-heading">
       <h3 class="panel-title"> <i class="fa fa-user"></i> Thông tin cá nhân</h3>
    </div>
    <div class="panel-body" id="contact-info">
        @if($viewable == true)
            <p><strong>Họ tên </strong>: {!! $candidate->name !!} </p>
            <p><strong>Giới tính</strong>: {!! optional($candidate->gender)->name !!}</p>
            <p><strong>Số điện thoại</strong>: {!! $candidate->phone !!}</p>
            <p><strong>Email</strong>: {!! $candidate->email !!}</p>
            <p><strong>Địa chỉ</strong>: {!! $candidate->address !!}</p>
        @else
            <div class="alert alert-info">
                Bạn cần {!! $candidate->profile->getPoint() !!} điểm để xem hồ sơ ứng viên này
            </div>
        @endif
    </div>
</div>


@include('account.inc.step-2',['viewonly' => true])
@include('account.inc.step-3',['viewonly' => true])
@include('account.inc.step-4',['viewonly' => true])
@include('account.inc.step-5',['viewonly' => true])

