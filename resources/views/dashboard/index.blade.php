@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-3"><strong>Analistik</strong> Dashboard</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Pendapatan</h5>
                            <div class="form-group">
                                <label for="grouss_amount_range" class="form-label">Filter</label>
                                <input type="month" id="gross_month_picker" class="form-control">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="align-self-center chart chart-lg">
                                <canvas id="chartjs-dashboard-bar-grossAmount"></canvas>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pengunjung</h5>
                <div class="form-gro">
                    <label for="dataRange" class="form-label">Filter</label>
                    <select id="dataRange" class="form-select w-auto">
                        <option value="day">Harian</option>
                        <option value="month" selected>Bulanan</option>
                        <option value="year">Tahunan</option>
                    </select>
                </div>

            </div>
            <div class="card-body d-flex w-100">
                <div class="align-self-center chart chart-lg">
                    <canvas id="chartjs-dashboard-bar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const grossCtx = document.getElementById("chartjs-dashboard-bar-grossAmount").getContext("2d");
    const monthInput = document.getElementById("gross_month_picker");
    const grossBaseUrl = "{{ route('grossAmount.data') }}";

    // Buat chart hanya 1 kali
    const grossChart = new Chart(grossCtx, {
        type: "pie",
        data: {
            labels: [],
            datasets: [{
                label: "Pendapatan",
                backgroundColor: ["#FFCE56"],
                hoverBackgroundColor: ["#FFC233"],
                data: [],
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return "Rp. " + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    function updateGrossChart(month) {
        fetch(`${grossBaseUrl}?month=${month}`)
            .then(response => response.json())
            .then(data => {
                let total = data.data.reduce((sum, item) => sum + item.total, 0);

                grossChart.data.labels = [`Pendapatan Bulan ${month}`]; 
                grossChart.data.datasets[0].data = [total];
                grossChart.update();
            })
            .catch(err => console.error("Error fetching data:", err));
    }

    // Set default bulan saat halaman pertama kali dibuka
    const today = new Date().toISOString().slice(0, 7);
    monthInput.value = today;
    updateGrossChart(today);

    // Event listener untuk mengupdate chart saat bulan berubah
    monthInput.addEventListener("change", function () {
        updateGrossChart(this.value);
    });
});

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("chartjs-dashboard-bar").getContext("2d");
        const chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [], // Empty initially, will be filled dynamically
                datasets: [{
                    label: "Data",
                    backgroundColor: window.theme.z,
                    borderColor: window.theme.z,
                    hoverBackgroundColor: window.theme.z,
                    hoverBorderColor: window.theme.z,
                    data: [], // Empty initially
                    barPercentage: 0.75,
                    categoryPercentage: 0.5,
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                // Format tooltip value to integer
                                return context.dataset.label + ": " + Math.round(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) {
                                // Format Y-axis labels to integers
                                return Math.round(value);
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                    }
                }
            }
        });


        const baseUrl = "{{ route('visitors.data') }}";
        function updateChart(range) {
            fetch(`${baseUrl}?range=${range}`)
                .then(response => response.json())
                .then(data => {
                    const labels = [];
                    const values = [];

                    if (range === "day") {
                        labels.push("Hari Ini");
                        values.push(data);
                    } else if (range === "month") {
                        data.forEach(item => {
                            labels.push(`Tanggal ${item.day}`);
                            values.push(item.total);
                        });
                    } else if (range === "year") {
                        data.forEach(item => {
                            labels.push(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"][item.month - 1]);
                            values.push(item.total);
                        });
                    }

                    chart.data.labels = labels;
                    chart.data.datasets[0].data = values;
                    chart.update();
                })
                .catch(err => console.error("Error fetching data:", err));
        }




        updateChart("month");

        // Listen for dropdown change
        document.getElementById("dataRange").addEventListener("change", function () {
            updateChart(this.value);
        });
    
    });
</script>

@endpush
@endsection
