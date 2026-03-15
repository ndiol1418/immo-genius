
<script>
    const data{{ $id }} = {
        labels: @json($labels),
        datasets: [
            @if (isset($line_title_1))
                {
                    type: 'line',
                    label: @json(isset($line_title_1) ? $line_title_1 : ''),
                    data: @json(isset($data[$key_2]) ? $data[$key_2] : ''),
                    fill: false,
                    borderColor: '#E4032F',
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    cubicInterpolationMode: 'monotone',
                    yAxisID: 'y1',
                },
            @endif
            @if (isset($line_title_2)&& isset($key_2))
                {
                    type: 'line',
                    label: @json(isset($line_title_2) ? $line_title_2 : ''),
                    data:  @json(isset($data[$key_1]) ? $data[$key_1] : ''),
                    fill: false,
                    borderColor: 'rgb(255, 159, 64)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    cubicInterpolationMode: 'monotone',
                    yAxisID: 'y',
                },
            @endif
            @if (isset($bar_title_1))
                {

                    type: 'bar',
                    label: @json(isset($bar_title_1) ? $bar_title_1 : ''),
                    data: @json(isset($data[$key_1]) ? $data[$key_1] : ''),
                    fill: false,
                    borderColor: '#E4032F',
                    backgroundColor: 'rgba(52, 152, 219, 0.8)',
                    tension: 0.4,
                    // yAxisID: 'y1',

                },
            @endif
            @if (isset($bar_title_2) && isset($key_3))
                {

                    type: 'bar',
                    label: @json(isset($bar_title_2) ? $bar_title_2 : ''),
                    data: @json(isset($data[$key_3]) ? $data[$key_3] : ''),
                    fill: false,
                    borderColor: '#E4032F',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    yAxisID: 'y',

                }
            @endif

        ],
        options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
    };
    const config{{ $id }} = {
        type: 'scatter',
        data: data{{ $id }},
        options: {
            animation: {
            onComplete: () => {
                delayed = true;
            },
            delay: (context) => {
                let delay = 0;
                if (context.type === 'data' && context.mode === 'default' && !delayed) {
                delay = context.dataIndex * 300 + context.datasetIndex * 100;
                }
                return delay;
            },
            },
            scales: {
                @if (isset($line_title))

                    y: {
                        beginAtZero: true,
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: @json(isset($line_title) ? $line_title : '')
                        },
                    },
                @endif
                @if (isset($bar_title))
                    y1: {
                        beginAtZero: true,
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: @json(isset($bar_title) ? $bar_title :'')
                        },
                    }
                @endif
            },
            plugins: {
                title: {
                    display: true,
                    text: '{{ isset($title) ? $title : '' }}'
                },
            },
        }
    };
    const chartEl{{ $id }} = document.getElementById(@json(isset($id) ? $id : 'myChart'));
    var taille = {{ isset($height)?$height:0 }};
    if (taille>0) {
        chartEl{{ $id }}.height = {{ $height??'400' }};
    }
    chartEl{{ $id }} .width = '100%';

    var myChart{{ $id }} = new Chart(
        chartEl{{ $id }},
        config{{ $id }}
    );


    @if (isset($data1))
        const data1 = {
            labels: @json($labels1),
            datasets: [
                {
                type: 'line',
                label: @json(isset($bar_title) ? $bar_title : ''),
                data: @json(isset($data1[$key_1]) ? $data1[$key_1] : ''),
                fill: false,
                borderColor: '#E4032F',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                cubicInterpolationMode: 'monotone',
                yAxisID: 'y1',
            },
            {

                type: 'bar',
                label: @json(isset($line_title) ? $line_title : ''),
                data: @json(isset($data1[$key_2]) ? $data1[$key_2] : ''),
                fill: false,
                borderColor: '#E4032F',
                backgroundColor: 'rgba(52, 152, 219, 0.8)',
                tension: 0.4

            }
        ]
        };

        const config1 = {
            type: 'scatter',
            data: data1,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        display: true,
                        title: {
                            display: true,
                            text: @json(isset($line_title) ? $line_title : '')
                        },
                    },
                    y1: {
                        beginAtZero: true,
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: @json(isset($bar_title) ? $bar_title :'')
                        },
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: '{{ isset($title) ? $title : 'soldes' }} sur les 12 mois de l\'année'
                    },
                },
            }
        };
        const chartEl1 = document.getElementById('myChart2');

        chartEl1.height = 450;

        var myChart = new Chart(
            chartEl1,
            config1
        );

    @endif
</script>
