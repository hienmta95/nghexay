@extends('layouts.master')

@push('css-stack')
    <link rel="stylesheet" href="{!! url('/css/landing.css') !!}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
    <script src="https://unpkg.com/ionicons@4.4.7/dist/ionicons.js"></script>
@endpush

@section('content')
    <div class="main-container" id="landing">

        @if (Session::has('message'))
            @include('common.spacer')
            <?php $paddingTopExists = true; ?>
            <div class="container">
                <div class="row">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        @endif

        @if (Session::has('flash_notification'))
            @include('common.spacer')
            <?php $paddingTopExists = true; ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        @include('flash::message')
                    </div>
                </div>
            </div>
    @endif


    <!-- Start: Header Section
        ================================ -->
        <section class="header-section-1 header-js" id="header">
            <div class="overlay-color">
                <div class="container">
                    <div class="row section-separator">

                        <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                            <div class="part-inner text-center">

                                <!--  Header SubTitle Goes here -->
                                <h1 class="title">
                                    Đồng hành cùng sự phát triển doanh nghiệp của bạn
                                </h1>

                                <div class="detail">
                                    <p>
                                        Tìm kiếm hồ sơ ứng viên tiềm năng
                                    </p>
                                    <p>
                                        Đăng tin tuyển dụng nhanh chóng
                                    </p>
                                    <p>
                                        Quản lý hồ sơ trực tuyến của bạn dễ dàng.
                                    </p>
                                </div>

                                <!-- Button Area -->
                                <div class="btn-form btn-scroll">
                                    <a href="#pricing" class="btn btn-fill right-icon">
                                        Tìm hiểu <i class="fa fa-advance"></i></a>
                                </div>

                            </div>
                        </div> <!-- End: .part-1 -->

                    </div> <!-- End: .row -->
                </div> <!-- End: .container -->
            </div> <!-- End: .overlay-color -->
        </section>
        <!-- End: Header Section
        ================================ -->


        <!-- Start: Features Section 7
        ====================================== -->
        <section class="features-section-7 content-half background-light">

            <div class="container-half container-half-left background-light"></div>
            <div class="container-half container-half-right cover"
                 style="background-image: url(/images/background-4.jpg);"></div>

            <div class="container">
                <div class="row section-separator text-left">

                    <div class="col-md-6">
                        <div class="inner">

                            <h2 class="section-heading">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed
                                diam notincidunt.</h2>
                            <div class="detail">
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
                                    euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>

                                <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit
                                    lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in
                                    he.</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End: Features Section 7
        ================================ -->


        <!-- Start: Features Section 1
        ====================================== -->
        <section class="features-section-1 relative background-semi-dark" id="features">
            <div class="container">
                <div class="row section-separator">

                    <!-- Start: Section Header -->
                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                        <h2 class="section-heading">Tại sao chọn {!! config('settings.app.app_name')  !!}</h2>
                        {{--<p class="sub-heading">Lorem ipsum dolor sit amet, consectetuer elit, sed diam nonummy nibh
                            euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>--}}

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>

                    <div class="col-xs-12 features-item">
                        <div class="row">

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">

                                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                                    <div class="detail">
                                        <p>
                                            Đăng tin tuyển dụng và tìm kiếm ứng viên phù hợp với yêu cầu của bạn
                                        </p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">

                                    <ion-icon name="briefcase"></ion-icon>
                                    <div class="detail">
                                        <p>
                                            Quản lý hồ sơ ứng viên dễ dàng
                                        </p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">

                                    <ion-icon name="chatboxes"></ion-icon>
                                    <div class="detail">
                                        <p>
                                            Tương tác với ứng viên qua hệ thống nhắn tin nội bộ
                                        </p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">

                                    <ion-icon name="contacts"></ion-icon>
                                    <div class="detail">
                                        <p>Đội ngũ tư vấn tuyển dụng tận tâm.</p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">

                                    <ion-icon name="alert"></ion-icon>
                                    <div class="detail">
                                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
                                            nibh euismod tincidunt ut laoreet.</p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                            <div class="each-features text-center col-md-4 col-sm-6 col-xs-12">
                                <div class="inner background-light">
                                    <ion-icon name="cube"></ion-icon>
                                    <div class="detail">
                                        <p>
                                            Quảng cáo thông minh giúp tin tuyển dụng được phủ rộng trên toàn hệ thống
                                        </p>
                                    </div>

                                </div> <!-- End: .inner -->
                            </div> <!-- End: .each-features -->

                        </div>
                    </div>

                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>
        <!-- End: Features Section 1
        ======================================-->


        <!-- Start: Features Section 3
        ================================== -->
        <section class="features-section-3 relative background-light" id="testimnial">
            <div class="container">
                <div class="row section-separator">

                    <!-- Start: Section Header -->
                    <div class="section-header col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">

                        <h2 class="section-heading">Khách hàng nói gì về chúng tôi?</h2>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>

                    <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <div class="testimonial-container">
                            <div class="testimonial-wrapper owl-carousel">

                                <div class="item text-center">

                                    <div class="image-outer">
                                        <img src="/images/testimonial/1.jpg">
                                    </div>

                                    <p class="name">Dung Nguyen</p>

                                    <div class="text-outer">
                                        <blockquote>Hồ sơ ứng viên phong phú, đa dạng nhiều ngành nghề. Đội ngũ nhân
                                            viên năng động & hỗ trợ nhiệt tình.
                                        </blockquote>
                                    </div>

                                </div> <!-- End: .item -->

                                <div class="item text-center">

                                    <div class="image-outer">
                                        <img src="/images/testimonial/3.jpg">
                                    </div>

                                    <p class="name">Yến Doãn - Nhà hàng Nét Huế</p>

                                    <div class="text-outer">
                                        <blockquote>
                                            Chất lượng dịch vụ khá tốt, lượng hồ sơ ứng tuyển khá ổn và Chăm sóc khách hàng khá nhiệt tình . Hệ thống thường xuyên nâng cấp cập nhật, giao diện tiện ích
                                        </blockquote>
                                    </div>

                                </div> <!-- End: .item -->

                                <div class="item text-center">

                                    <div class="image-outer">
                                        <img src="/images/testimonial/2.jpg">
                                    </div>

                                    <p class="name">Minh Trang</p>

                                    <div class="text-outer">
                                        <blockquote>Các bạn CSKH luôn hỗ trợ rất nhiệt tình, chất lượng ứng viên cũng
                                            ngày càng tốt hơn.
                                        </blockquote>
                                    </div>

                                </div> <!-- End: .item -->

                            </div> <!-- End: .swiper-wrapper -->
                        </div> <!-- End: .testimonials-container -->
                    </div> <!-- End: .col-md-8 -->

                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>
        <!-- End: Features Section 3
        ================================== -->


        <!-- Start: Features Section 4
        ================================== -->
        <section class="features-section-4 relative background-semi-dark" id="pricing">
            <div class="container">
                <div class="row section-separator">

                    <!-- Start: Section Header -->
                    <div class="section-header col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

                        <h2 class="section-heading">Our Pricing</h2>
                        <p class="sub-heading">Lorem ipsum dolor sit amet, consectetuer elit, sed diam nonummy nibh
                            euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>

                        <a href="/pricing" class="btn btn-success btn-lg mt-50">
                            Tìm hiểu thêm
                        </a>

                    </div>
                    <!-- End: Section Header -->

                    <div class="clearfix"></div>

                </div> <!-- End: .row -->
            </div> <!-- End: .container -->
        </section>
        <!-- End: Features Section 4
        ================================== -->



    </div>
@endsection

@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                items: 1,
                autoplay: true
            });
        });
    </script>
@endsection
