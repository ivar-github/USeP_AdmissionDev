<div class="max-w-2xl  w-full h-full border-2 dark:border-gray-500 rounded-lg shadow dark:bg-gray-800 p-5">
    <div class="flex justify-between border-b border-gray-200 dark:border-gray-500 pb-2">
        <div class="flex items-center">
            <div class="w-12 h-5 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                    <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                    <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                </svg>
                </div>
                <div>
                    <h5 class="leading-none text-sm font-bold text-gray-900 dark:text-white ">Bar Graph Analytics</h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Admission results last previous terms</p>
            </div>
        </div>
        <div>
            <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 rounded-md dark:bg-green-900 dark:text-green-300">
            <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
            </svg>
            {{-- 42.5% --}}
            </span>
        </div>
    </div>

    <div id="chart-HorizontalBar">
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            axios.get('{{ route('api.results.data') }}')
                .then(response => {
                    const data = response.data;
                    renderHorizontalBar(data.graph);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });

        function renderHorizontalBar(data) {
            const qualifiedData = data.map(item => ({ x: `Term ${item.TermID}`, y: item.appQualified }));
            const wavedslotData = data.map(item => ({ x: `Term ${item.TermID}`, y: item.appWaivedSlot }));
            const confirmedData = data.map(item => ({ x: `Term ${item.TermID}`, y: item.appConfirmed }));
            const totalData = data.map(item => ({ x: `Term ${item.TermID}`, y: item.appTotal }));


            const options = {
                colors: ["#8ebee8", "#e8d78e", "#8ee89d", "#e88e95"],
                series: [
                    {
                        name: "Total",
                        color: "#8ebee8",
                        data: totalData,
                    },
                    {
                        name: "Qualified",
                        color: "#e8d78e",
                        data: qualifiedData,
                    },
                    {
                        name: "Confirmed",
                        color: "#8ee89d",
                        data: confirmedData,
                    },
                    {
                        name: "WaivedSlot",
                        color: "#e88e95",
                        data: wavedslotData,
                    },
                ],
                chart: {
                    type: "bar",
                    height: "320px",
                    fontFamily: "Inter, sans-serif",
                    toolbar: {
                        show: true,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: "70%",
                        borderRadiusApplication: "end",
                        borderRadius: 8,
                    },
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: "darken",
                            value: 1,
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 0,
                    colors: ["transparent"],
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: -14
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: true,
                },
                xaxis: {
                    floating: false,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        }
                    },
                    axisBorder: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                },
                yaxis: {
                    show: true,
                },
                fill: {
                    opacity: 1,
                },
            }

            if(document.getElementById("chart-HorizontalBar") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("chart-HorizontalBar"), options);
                chart.render();
            }
        }
    </script>
@endpush
