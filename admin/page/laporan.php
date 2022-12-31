<?php
require_once '../asset/php/sidebar.php';
$count = new Auth();
?>

<div class="tbl-container">
    <div class="tbl-content">
        <div class="tbl-header">
            <a href="#popup1" style="color: #fff; background-color: #5FD3D0; text-decoration: none; font-size: small;" class="btn-left"><i class="fa-solid fa-download">&nbsp;&nbsp;&nbsp;</i>Unduh Laporan</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="tbl-header-right">
            </div>
        </div>
        <!-- <div class="tab-menu">
            <button class="tablink w3-red" onclick="openCity(event,'showAllPesanan')">Semua</button>
            <button class="tablink" onclick="openCity(event,'showPesananBaru')">Bulan Ini</button>
            <button class="tablink" onclick="openCity(event,'showPesananProses')">Bulan Lalu</button>
            <button class="tablink" onclick="openCity(event,'showPesananSelesai')">Hari Ini</button>
            <button class="tablink" onclick="openCity(event,'showPesananBatal')">Minggu Ini</button>
        </div> -->
        <div class="ringkasan-laporan">
            <div class="card-laporan">
                <h5>Total Pendapatan</h5>
                <br>
                <h3>Rp. <?php $ttp = $count->total_pendapatan();
                        echo number_format($ttp); ?></h3>
                <br>
                <p>Semua Data</p>
            </div>
            <div class="card-laporan">
                <h5>Total Pesanan</h5>
                <br>
                <h3><?= $count->totalCount('pesanan'); ?></h3>
                <br>
                <p>Semua Data</p>
            </div>
            <div class="card-laporan">
                <h5>Produk Terlaris</h5>
                <br>
                <h3>
                    <?php
                    $ptl = $count->produk_terlaris();
                    // foreach ($ptl as $row) {
                    $cekProduk = $count->fetchAllProdukByID($ptl);
                    echo $cekProduk['nama_layanan'];
                    // }
                    ?>
                </h3>
                <br>
                <p>Semua Data</p>
            </div>
            <div class="card-laporan">
                <h5>Pelanggan Utama</h5>
                <br>
                <h3><?php
                    $plg = $count->pelanggan_utama();
                    // foreach ($ptl as $row) {
                    $cekPelanggan = $count->fetchPelangganByID($plg);
                    echo $cekPelanggan['username_user'];
                    // }
                    ?>
                </h3>
                <br>
                <p>Transaksi
                    <?php
                    $to = $count->transaksi_pelanggan_utama($plg);
                    echo $to['total_transaksi'];
                    ?>x
                </p>
                <p>Total Rp.
                    <?php
                    $toPlg = $count->total_transaksi_pelanggan_utama($plg);
                    echo number_format($toPlg['total_transaksi']);
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="content-data-grafik">
    <div class="chart">
        <div class="card-header">
            <h3>
                <?php
                $bulan = date("F");
                echo 'Grafik Total Pendapatan ';
                ?>
            </h3>
            <p>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo $today = date('j F Y, g:i A');
                // $cek = $count->grafik_total_pesanan();
                $cekLabell = $count->grafik_total_pendapatan();
                $grandTotalNominal = array();
                $labelTahun = array();
                foreach ($cekLabell as $row) {
                    $labelTahun[] = $row['tahun'];
                    $grandTotalNominal[] = ucfirst($row['total_transaksi']);
                }
                ?>
            </p>
        </div>
        <div class="cont-chart">
            <canvas id="chart-total-pendapatan" class="chart-canvas"></canvas>
        </div>
    </div>

    <div class="chart">
        <div class="card-header">
            <h3>
                <?php
                $bulan = date("F");
                echo 'Grafik Total Pesanan ';
                ?>
            </h3>
            <p>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo $today = date('j F Y, g:i A');
                $cekLabel = $count->grafik_total_pesanan();
                $grandTotal = array();
                $label = array();
                foreach ($cekLabel as $row) {
                    $label[] = $row['tahun'];
                    $grandTotal[] = ucfirst($row['jumlah_tahunan']);
                }
                ?>
            </p>
        </div>
        <div class="cont-chart">
            <canvas id="chart-line" class="chart-canvas"></canvas>
        </div>
    </div>

    <div class="chart">
        <div class="card-header">
            <h3>
                <?php
                $bulan = date("F");
                echo 'Grafik Total Produk Terlaris ';
                ?>
            </h3>
            <p>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo $today = date('j F Y, g:i A');
                $cekLabelP = $count->grafik_produk_terlaris();
                $TotalProduk = array();
                $labelProduk = array();
                foreach ($cekLabelP as $row) {
                    $cekProduk = $count->fetchAllProdukByID($row['uid_layanan']);
                    $namaProduk = $cekProduk['nama_layanan'];
                    $labelProduk[] = ucfirst($namaProduk);
                    $TotalProduk[] = ucfirst($row['qty']);
                }
                ?>
            </p>
        </div>
        <div class="cont-chart">
            <canvas id="chart-produk-terlaris" class="chart-canvas"></canvas>
        </div>
    </div>

    <div class="chart">
        <div class="card-header">
            <h3>
                <?php
                $bulan = date("F");
                echo 'Grafik Nominal Produk Terlaris';
                ?>
            </h3>
            <p>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo $today = date('j F Y, g:i A');
                $cekLabelProdukNominal = $count->grafik_nominal_produk_terlaris();
                $nominalProduk = array();
                $labelnominalProduk = array();
                foreach ($cekLabelProdukNominal as $row) {
                    $cekProduk = $count->fetchAllProdukByID($row['uid_layanan']);
                    $namaProduk = $cekProduk['nama_layanan'];
                    $labelnominalProduk[] = ucfirst($namaProduk);
                    $nominalProduk[] = ucfirst($row['nominal_produk']);
                }
                ?>
            </p>
        </div>
        <div class="cont-chart">
            <canvas id="chart-nominal-produk-terlaris" class="chart-canvas"></canvas>
        </div>
    </div>
</div>

<!-- Line Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
<script>
    // setup 
    const grandTotal = <?php echo json_encode($grandTotal); ?> 
    const label = <?php echo json_encode($label); ?> 
    const grandTotalL = <?php echo json_encode($grandTotalNominal); ?> 
    const labelL = <?php echo json_encode($labelTahun); ?> 
    const totalProduk = <?php echo json_encode($TotalProduk); ?> 
    const labelP = <?php echo json_encode($labelProduk); ?> 
    const labelNominal = <?php echo json_encode($labelnominalProduk); ?> 
    const nominalProduk = <?php echo json_encode($nominalProduk); ?> 

    const data = {
        labels: label,
        datasets: [{
            label: grandTotal,
            data: grandTotal,
            borderWidth: 1,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
        }]
    };
    
    const dataTotalPendapatan = {
        labels: labelL,
        datasets: [{
            label: grandTotalL,
            data: grandTotalL,
            borderWidth: 1,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
        }]
    };

    const dataProdukTerlaris = {
        labels: labelP,
        datasets: [{
            label: totalProduk,
            data: totalProduk,
            borderWidth: 1,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
        }]
    };

    const dataNominalProdukTerlaris = {
        labels: labelNominal,
        datasets: [{
            label: nominalProduk,
            data: nominalProduk,
            borderWidth: 1,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
        }]
    };
    
    // config
    const configTotalPesanan = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            }
        }
    };

    const configTotalPendapatan = {
        type: 'bar',
        data: dataTotalPendapatan,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            }
        }
    };

    const configProdukTerlaris = {
        type: 'pie',
        data: dataProdukTerlaris,
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        circular: false,
                        offset: false,
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        offset: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        circular: false,
                        borderDash: [5, 5]
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            }
        }
    };
    
    const configNominalProdukTerlaris = {
        type: 'pie',
        data: dataNominalProdukTerlaris,
        options: {
            scales: {
                y: {
                    beginAtZero: false,
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        circular: false,
                        offset: false,
                        borderDash: [5, 5]
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        offset: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        circular: false,
                        borderDash: [5, 5]
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            }
        }
    };

    // render
    const ChartTotalPesanan = new Chart(
        document.getElementById('chart-line'),
        configTotalPesanan
    );
    const ChartTotalPendapatan = new Chart(
        document.getElementById('chart-total-pendapatan'),
        configTotalPendapatan
    );
    const ChartJumlahProdukTerlaris = new Chart(
        document.getElementById('chart-produk-terlaris'),
        configProdukTerlaris
    );
    const ChartNominalProdukTerlaris = new Chart(
        document.getElementById('chart-nominal-produk-terlaris'),
        configNominalProdukTerlaris
    );

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
            // responsive: true,
            // maintainAspectRatio: false,
            // plugins: {
            //     legend: {
            //         display: false,
            //     }
            // },
    //         interaction: {
    //             intersect: false,
    //             mode: 'index',
    //         },
    //         scales: {
    //             y: {
                    // grid: {
                    //     drawBorder: false,
                    //     display: true,
                    //     drawOnChartArea: true,
                    //     drawTicks: false,
                    //     borderDash: [5, 5]
                    // },
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
    // const labels = Utils.months({
    //     count: 7
    // });
    // const data = {
    //     labels: labels,
    //     datasets: [{
    //         label: 'My First Dataset',
    //         data: [65, 59, 80, 81, 56, 55, 40],
    //         backgroundColor: [
    //             'rgba(255, 99, 132, 0.2)',
    //             'rgba(255, 159, 64, 0.2)',
    //             'rgba(255, 205, 86, 0.2)',
    //             'rgba(75, 192, 192, 0.2)',
    //             'rgba(54, 162, 235, 0.2)',
    //             'rgba(153, 102, 255, 0.2)',
    //             'rgba(201, 203, 207, 0.2)'
    //         ],
    //         borderColor: [
    //             'rgb(255, 99, 132)',
    //             'rgb(255, 159, 64)',
    //             'rgb(255, 205, 86)',
    //             'rgb(75, 192, 192)',
    //             'rgb(54, 162, 235)',
    //             'rgb(153, 102, 255)',
    //             'rgb(201, 203, 207)'
    //         ],
    //         borderWidth: 1
    //     }]
    // };

    // const config = {
    //     type: 'bar',
    //     data: data,
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     },
    // };
</script>