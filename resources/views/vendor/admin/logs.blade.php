@extends('admin::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('admin::messages.dashboard') }}
            <small>{{ trans('admin::messages.first_page_you_see', ['app_name' => config('app.name'), 'app_version' => config('app.version')]) }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ admin_url() }}">{{ config('app.name') }}</a></li>
            <li class="active">{{ trans('admin::messages.dashboard') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    {!! Form::open(['url'=> url()->current(),'class'=>'form-inline','method'=>'GET']) !!}
                    <div class="form-group">
                        <label for="type">Loại</label>
                        {!! Form::select('type',['view_profile'=>'Xem hồ sơ','view_post' => 'Xem tin tuyển dụng','pay_profile' => 'Thanh toán điểm'],request()->get('type'),['class'=>'form-control','placeholder'=>'Tất cả hoạt động']) !!}
                    </div>
                    <div class="form-group">
                        <label for="keyword">Từ khóa</label>
                        <input type="text" name="keyword" class="form-control" id="keyword"/>
                    </div>
                    <div class="form-group">
                        <label for="keyword">User</label>
                        <input type="text" name="user" class="form-control" id="keyword"/>
                    </div>
                    <button type="submit" class="btn btn-default">Tìm kiếm</button>
                    {!! Form::close() !!}

                    <hr>
                    <div class="table-responsive mt-5">
                        <table class="table table-striped">
                            <thead class="bg-gray">
                            <tr>
                                <th>Log name</th>
                                <th>User</th>
                                <th>Description</th>
                                <th>Datetime</th>

                            </tr>
                            </thead>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>
                                        {!! $activity->log_name !!}
                                    </td>
                                    <td>
                                        {!! optional($activity->causer)->name !!}
                                    </td>
                                    <td>
                                        {!! $activity->description !!}
                                    </td>

                                    <td>
                                        {!! $activity->created_at !!}
                                    </td>

                                </tr>
                            @endforeach


                        </table>
                    </div>
                    <div class="pull-right">
                        {!! $activities->appends(request()->except('page'))->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
