@props(['data', 'prefix', 'id', 'label' => '', 'title' => '', 'comparison' => ''])



<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $title }}</h4>

        @if ($comparison)
            <a class="btn btn-sm btn-primary"
                href="{{ route('comparison.index', $comparison) }}">{{ __('Comparison') }}</a>
        @endif
    </div>
    <div class="card-content">
        <div class="card-body pl-0">
            <div class="height-300">
                <canvas id="{{ $id }}"></canvas>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('vendors/js/charts/chart.min.js') }}"></script>

    <script>
        var $primary = '#7367F0';
        var $success = '#28C76F';
        var $danger = '#EA5455';
        var $warning = '#FF9F43';
        var $label_color = '#1E1E1E';
        var grid_line_color = '#dae1e7';
        var scatter_grid_color = '#f3f3f3';
        var $scatter_point_light = '#D1D4DB';
        var $scatter_point_dark = '#5175E0';
        var $white = '#fff';
        var $black = '#000';

        var themeColors = [$primary, $success, $danger, $warning, $label_color];

        // Bar Chart
        // Chart Options
        var barChartOptions = {
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each bar to be 2px wide
            elements: {
                rectangle: {
                    borderWidth: 2,
                    borderSkipped: 'left'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            responsiveAnimationDuration: 500,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        color: grid_line_color,
                    },
                    scaleLabel: {
                        display: true,
                    }
                }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        color: grid_line_color,
                    },
                    scaleLabel: {
                        display: true,
                    },
                    ticks: {
                        stepSize: 1000,
                        beginAtZero: true
                    },
                }],
            },
            title: {
                display: false,
                text: 'Predicted world population (millions) in 2050'
            },

        };
    </script>

    <script>
        var {{ $prefix }} = $("#{{ $id }}");

        var {{ $prefix }}ChartData = {
            labels: [
                @foreach ($data as $item)
                    "{{ $item->label }}",
                @endforeach
            ],
            datasets: [{
                label: "{{ $label }}",
                data: [
                    @foreach ($data as $item)
                        "{{ $item->count }}",
                    @endforeach
                ],
                backgroundColor: themeColors,
                borderColor: "transparent"

            }]
        };

        var {{ $prefix }}ChartConfig = {
            type: 'bar',
            // Chart Options
            options: barChartOptions,
            data: {{ $prefix }}ChartData
        };

        var {{ $prefix }}Chart = new Chart({{ $prefix }}, {{ $prefix }}ChartConfig);
    </script>
@endpush
