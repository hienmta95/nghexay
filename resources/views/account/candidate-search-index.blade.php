@extends('layouts.account')

@section('content')

    <div class="inner-box">
        <h2 class="title-2"><i class="icon-star-circled"></i> {{ t('Saved searches') }} </h2>
        <div class="row">

            <div class="col-sm-4">
                <ul class="list-group list-group-unstyle">

                </ul>
                <div class="pagination-bar text-center">

                </div>
            </div>

            <div class="col-sm-8">
                <div class="adds-wrapper">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('after_scripts')
    <!-- include footable   -->
    <script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
    <script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            $('#addManageTable').footable().bind('footable_filtering', function (e) {
                var selected = $('.filter-status').find(':selected').text();
                if (selected && selected.length > 0) {
                    e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                    e.clear = !e.filter;
                }
            });

            $('.clear-filter').click(function (e) {
                e.preventDefault();
                $('.filter-status').val('');
                $('table.demo').trigger('footable_clear_filter');
            });

        });
    </script>
    <!-- include custom script for ads table [select all checkbox]  -->
    <script>

        function checkAll(bx) {
            var chkinput = document.getElementsByTagName('input');
            for (var i = 0; i < chkinput.length; i++) {
                if (chkinput[i].type == 'checkbox') {
                    chkinput[i].checked = bx.checked;
                }
            }
        }

    </script>
@endsection
