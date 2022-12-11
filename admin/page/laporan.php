<?php
require_once '../asset/php/sidebar.php';
$count = new Auth();
?>

<div class="chart">
    <div class="card-header">
        <h3>
            <?php
            $bulan = date("F");
            echo 'Grafik Pemesanan ' . $count->bulan($bulan);
            ?>
        </h3>
        <p>
            <?php
            date_default_timezone_set('Asia/Jakarta');
            echo $today = date('j F Y, g:i A');
            ?>
        </p>
    </div>
    <div class="cont-chart">
        <canvas id="chart-line" class="chart-canvas"></canvas>
    </div>
</div>
</div>
<!-- Line Chart -->
<script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(95, 211, 208, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(95, 211, 208, 0.2)');
    gradientStroke1.addColorStop(0, 'rgba(95, 211, 208, 0.2)');
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5FD3D0",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>