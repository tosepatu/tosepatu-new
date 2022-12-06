<?php
require_once '../asset/php/sidebar-karyawan.php';
require_once '../asset/php/auth-karyawan.php';

// $count = new Auth();
?>

</div>
</div>
</section>

<!--   Core JS Files   -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script> -->
<!-- Line Chart -->
<script>
    // var ctx1 = document.getElementById("chart-line").getContext("2d");

    // var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    // gradientStroke1.addColorStop(1, 'rgba(95, 211, 208, 0.2)');
    // gradientStroke1.addColorStop(0.2, 'rgba(95, 211, 208, 0.2)');
    // gradientStroke1.addColorStop(0, 'rgba(95, 211, 208, 0.2)');
    // new Chart(ctx1, {
    //     type: "line",
    //     data: {
    //         labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    //         datasets: [{
    //             label: "Mobile apps",
    //             tension: 0.4,
    //             borderWidth: 0,
    //             pointRadius: 0,
    //             borderColor: "#5FD3D0",
    //             backgroundColor: gradientStroke1,
    //             borderWidth: 3,
    //             fill: true,
    //             data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
    //             maxBarThickness: 6

    //         }],
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         plugins: {
    //             legend: {
    //                 display: false,
    //             }
    //         },
    //         interaction: {
    //             intersect: false,
    //             mode: 'index',
    //         },
    //         scales: {
    //             y: {
    //                 grid: {
    //                     drawBorder: false,
    //                     display: true,
    //                     drawOnChartArea: true,
    //                     drawTicks: false,
    //                     borderDash: [5, 5]
    //                 },
    //                 ticks: {
    //                     display: true,
    //                     padding: 10,
    //                     color: '#fbfbfb',
    //                     font: {
    //                         size: 11,
    //                         family: "Open Sans",
    //                         style: 'normal',
    //                         lineHeight: 2
    //                     },
    //                 }
    //             },
    //             x: {
    //                 grid: {
    //                     drawBorder: false,
    //                     display: false,
    //                     drawOnChartArea: false,
    //                     drawTicks: false,
    //                     borderDash: [5, 5]
    //                 },
    //                 ticks: {
    //                     display: true,
    //                     color: '#ccc',
    //                     padding: 20,
    //                     font: {
    //                         size: 11,
    //                         family: "Open Sans",
    //                         style: 'normal',
    //                         lineHeight: 2
    //                     },
    //                 }
    //             },
    //         },
    //     },
    // });
</script>
<!-- Link auth line chart -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<!-- <script src="path/to/chartjs/dist/chart.umd.js"></script> -->
<!-- Link Ajax Request-->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<!-- Ajax add produk request -->
<script>
    // $(document).ready(function() {
    //     $("#add-produk-btn").click(function(e) {
    //         if ($("#add-produk-form")[0].checkValidity()) {
    //             e.preventDefault();
    //             $.ajax({
    //                 url: '../asset/php/action.php',
    //                 method: 'post',
    //                 data: $("#add-produk-btn").serialize() + '$action=tambahproduk',
    //                 success: function(response) {
    //                     console.log(response);
    //                     if (response === 'tambahproduk') {
    //                         $("#alert").html(response);
    //                     } else {
    //                         $("#aAlert").html(response);
    //                     }
    //                 }
    //             });
    //         }
    //     });
    // });
</script>

</body>

</html>
<?php
// } else {
//     header("Location: ../login-admin/index.php");
// }
?>