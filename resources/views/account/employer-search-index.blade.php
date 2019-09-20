@extends('layouts.account')

@section('content')
    <ol class="breadcrumb">
        <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Tìm kiếm ứng viên</li>
    </ol>
    <div class="card search-wrapper">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 mt-20 mb-20">
                    {!! Form::open(['url' => \URL::current(), 'method' => 'get','class'=>'form-inline']) !!}
                    <div class="row">
                        <?php
                        //$cities = array_merge(['' => 'Tất cả vị trí'], $cities->pluck('name', 'id')->toArray());
                        $cities =  $cities->pluck('name', 'id')->toArray();
                        //$catArr = array_merge(['' => 'Tất cả ngành nghề'], $categories->pluck('name', 'id')->toArray());
                        $catArr = $categories->pluck('name', 'id')->toArray();

                        ?>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="text" placeholder="Từ khóa, tiêu đề công việc"
                                   value="{!! request()->get('keyword')  !!}">
                        </div>
                        <div class="col-md-3">
                            {!! Form::select('category_id',$catArr,request()->get('category_id'),['class'=>'form-control sselecter','placeholder' =>'Tất cả ngành nghề']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::select('location',$cities,request()->get('location'),['class'=>'form-control sselecter','placeholder' =>'Tất cả địa điểm']) !!}
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-block btn-success">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                            <div class="mt-1 text-center">
                                <a href="#" id="search-toggle">Tìm kiếm nâng cao</a>
                            </div>
                        </div>

                    </div>
                    <div id="advance-search"  class="row mt-20" @if(request()->has('edu_type_id') ||
                    request()->has('expected_job_post_type_id') ||
                    request()->has('experience_years') ||
                    request()->has('gender_id') ) style="display: block" @endif>
                        <div class="col-md-3">
                            {!! Form::select('edu_type_id',$educationTypes->pluck('name','id')->toArray(),request()->get('edu_type_id'),
                            [
                            'class'=>'form-control sselecter',
                            'placeholder'=> 'Trình độ học vấn'
                            ]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::select('expected_job_post_type_id',$positionTypes->pluck('name','id')->toArray(),request()->get('expected_job_post_type_id'),[
                            'class'=>'form-control sselecter',
                            'placeholder'=> 'Vị trí mong muốn']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::select('experience_years',[
                                '<=1' => '1 năm',
                                '2' => '2 năm',
                                '3' => '3 năm',
                                '4' => '4 năm',
                                '>=5' => '5 năm trở lên',
                            ],request()->get('experience_years'),[
                            'class'=>'form-control sselecter',
                            'placeholder'=> 'Tất cả kinh nghiệm'
                            ]) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::select('gender_id',$genders->pluck('name','id')->toArray(),request()->get('gender_id'),[
                            'class'=>'form-control sselecter',
                            'placeholder'=> 'Giới tính']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>

    <div class="inner-box mt-20">
        <h4><i class="icon-star-circled"></i> {{ t('Latest candidates') }} </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="row candidates-wrapper" id="candidate-wrapper">
                    @foreach($candidates as $candidate)
                        @include('account.inc.candidate-item')
                    @endforeach
                    <div class="clearfix"></div>
                    <div class="text-center ">
                        {!! $candidates->links() !!}
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="candidateModal" tabindex="-1" role="dialog" aria-labelledby="candidateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">

            </div>
        </div>
    </div>
@endsection

@section('before_styles')
    <style>
        .form-inline .form-control {
            width: 100% !important;
        }

        #advance-search {
            display: none;
        }

        .search-wrapper {
            background: #2b5876; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #4e4376, #2b5876); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #4e4376, #2b5876); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .search-wrapper a {
            color: #FFFFFF;
        }

        @media screen and (min-width: 992px) {
            .modal-lg {
                width: 900px;
            }
        }
    </style>
@stop

@section('after_scripts')
    <!-- include footable   -->
    <script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('js/jspdf.min.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('js/employer.js?v=2-0-1') }}" type="text/javascript"></script>
    <script>
        $('#search-toggle').click(function () {
            $('#advance-search').toggle();
        });
    </script>
@endsection
