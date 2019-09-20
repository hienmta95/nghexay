@extends('layouts.account')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <ol class="breadcrumb">
                <li><a href="{!! url('account/dashboard') !!}"> <i class="fa fa-home"></i> Dashboard</a></li>
                <li class="active">Danh sách hồ sơ đã xem</li>
            </ol>
            <div class="card card-default dashboard-block">
                <div class="card-heading">
                    <h4 class="card-title">Hồ sơ đã xem</h4>
                </div>
                <div class="card-body">
                    @include('account.inc.candidate-row')
                </div>
            </div>


            <div class="row">
                <div class="col-dm-12">
                    {!! $candidates->links() !!}
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

@section('after_scripts')
    <script src="{{ url('js/employer.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>

@endsection
