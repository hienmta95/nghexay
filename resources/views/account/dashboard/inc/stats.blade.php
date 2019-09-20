<div class="card card-default dashboard-block">
    <div class="card-heading">
        <h4 class="card-title">
            Thống kê
            <select class="form-control select-range pull-right" name="select-range" id="select-range">
                <option value="7days">7 ngày</option>
                <option value="1month">1 tháng</option>
                <option value="3months">3 tháng</option>
            </select>
        </h4>


    </div>
    <div class="card-body p-b-20">
        <div id="chart-holder">
            <div id="employerChart"></div>
        </div>
    </div>
</div>
@push('css-stack')
    <style>
        .stat-panel {
            display: none;
        }

        .stat-panel.active {
            display: block;
        }

        .select-range {
            width: 200px;
            margin-top: -10px;
        }
    </style>
@endpush

@push('js-stack')
    <script>
        $(document).ready(function () {
            function getStat($range = '7days') {
                $.ajax({
                    url: '/ajax/employer/dashboard-charts',
                    data: {range: $range},
                    method: 'GET',
                    success: function (res) {
                        $('#chart-holder').html(res);
                    }
                });
            }
            getStat();
            $('#select-range').on('change', function () {
                getStat($(this).val());
            });
        });
    </script>
@endpush
