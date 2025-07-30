<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2><?php echo $title; ?></h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a><?php echo $title; ?></a>
                </li>
                
            </ol>
        </div>
    </div>
    <br/>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong><?php echo strip_tags(validation_errors()); ?></strong>
                </div>
            <?php } ?>
            <div class="row d-flex flex-column">
                <div class="row">
                    <!-- Ucapan selamat datang -->
                    <div class="col-lg-6" id="welcome-section">
                        <div class="col-lg-12">
                            <div class="widget-head-color-box blue-bg p-lg text-center">
                                <div class="m-b-md">
                                <h2 class="font-bold no-margins">
                                    <?php $identitas = $this->db->get("tbl_aplikasi")->row();?>
                                    Selamat Datang Di <p class="small"><?= $identitas->nama_aplikasi?></p>
                                </h2>
                                    <strong><?php echo $user['nama']; ?></strong>
                                </div>
    
                                <img src="<?php echo base_url('assets/dist/aplikasi/') . $identitas->logo; ?>" alt="profile" class="brand-image" style="height:100px">
                            </div>
                            <div class="widget-text-box">
                                <div class="row">
                                    <div class="col-md-12">
                                    <button type="button" class="btn btn-info btn-sm float-right ml-1" data-toggle="modal" data-target="#ubah-pass">Ubah Password</button> 
                                    <button type="button" class="btn btn-info btn-sm float-right" data-toggle="modal" data-target="#profile">Ubah Profil</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Info jumlah data -->
                    <div class="col-lg-6" id="info-data-section">
                        <div class="col-lg-12">
                            <div class="widget style1 yellow-bg">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span>Jumlah Alternatif</span>
                                        <h2 class="font-bold"><?= $jumlah_alternatif ?></h2>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="<?= base_url('alternatif') ?>" class="btn btn-warning btn-sm float-right">Lihat Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="widget style1 lazur-bg">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-files-o fa-5x"></i>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span> Jumlah Kriteria </span>
                                        <h2 class="font-bold"><?= $jumlah_kriteria?></h2>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="<?= base_url('kriteria') ?>" class="btn btn-info btn-sm float-right">Lihat Data</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="widget style1 red-bg">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-files-o fa-5x"></i>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span> Jumlah Subkriteria </span>
                                        <h2 class="font-bold"><?= $jumlah_subkriteria?></h2>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="<?= base_url('subkriteria') ?>" class="btn btn-danger btn-sm float-right">Lihat Data</a>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    
                    
                </div>
            </div>
            <br>
            <div class="row">
                
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <a class="close" data-dismiss="alert">x</a>
                        <strong>Sistem ini hanya digunakan untuk mendukung keputusan. Akan tetapi keputusan akhir di tentukan oleh Perbekel.</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox">
                        <?php echo $this->session->flashdata('alert_msg'); ?>
                        <div class="ibox-title">
                            <h5>Daftar Rekomendasi</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="post" action="<?= base_url('penilaian/proses_eliminasi') ?>" enctype="multipart/form-data" id="eliminasiForm">
                                <div class="table table-responsive scrollable-table">
                                    <style>
                                        .scrollable-table {
                                            max-height: 300px; /* Sesuaikan tinggi tabel sesuai kebutuhan */
                                            overflow-y: auto;
                                        }
                                        .scrollable-table table {
                                            width: 100%;
                                            table-layout: fixed; /* Agar kolom tetap rapi */
                                        }
                                    </style>
                                    <table id="ranking-table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"> Tandai Semua</th>
                                                <th>Alternatif</th>
                                                <th>Hasil SAW | SMART </th>
                                                <th>Ranking SAW | SMART</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($preview_penilaian)) : ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                                            Belum ada data.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else :?>
                                                <?php foreach($preview_penilaian as $pp):?>
                                                    <tr>
                                                        <td><input type="checkbox" class="checkbox-item" name="id_alternatif[]" value="<?= $pp['id_alternatif'] ?>"></td>
                                                        <td><?= $pp['nama_siswa']?></td>
                                                        <td><?= round($pp['hasil_saw'],2)?> | <?= round($pp['hasil_smart'],2)?> </td>
                                                        <td><?= $pp['ranking_saw']?> | <?= $pp['ranking_smart']?></td>
                                                        <td><a href="<?= base_url('penilaian/eliminasi/') . $pp['id_alternatif'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></a></td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-danger" id="submitEliminasi"><i class="fa fa-close"></i> Proses Eliminasi</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox">
                        
                        <div class="ibox-title">
                            <h5>Alternatif Tereleminasi</h5>
                        </div>
                        <div class="ibox-content">
                            <form method="post" action="<?= base_url('penilaian/proses_restore') ?>" enctype="multipart/form-data" id="RestoreForm">
                                <div class="table table-responsive scrollable-table">
                                    <style>
                                        .scrollable-table {
                                            max-height: 300px; /* Sesuaikan tinggi tabel sesuai kebutuhan */
                                            overflow-y: auto;
                                        }
                                        .scrollable-table table {
                                            width: 100%;
                                            table-layout: fixed; /* Agar kolom tetap rapi */
                                        }
                                    </style>
                                    <table id="ranking-table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all-restore"> Tandai Semua</th>
                                                <th>Alternatif</th>
                                                <th>Hasil SAW | SMART </th>
                                                <th>Ranking SAW | SMART</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($eliminasi_alternatif)) : ?>
                                                <tr>
                                                    <td colspan="5">
                                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                                            Belum ada data.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach($eliminasi_alternatif as $ea):?>
                                                <tr>
                                                    <td><input type="checkbox" class="checkbox-item" name="id_alternatif[]" value="<?= $ea['id_alternatif'] ?>"></td>
                                                    <td><?= $ea['nama_siswa'] ?></td>
                                                    <td><?= round($ea['hasil_saw'],2)?> | <?= round($ea['hasil_smart'],2)?> </td>
                                                    <td><?= $ea['ranking_saw']?> | <?= $ea['ranking_smart']?></td>
                                                    <td>
                                                        <a href="<?= base_url('penilaian/restore/') . $ea['id_alternatif'] ?>" class="btn btn-info btn-sm"><i class="fa fa-refresh"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-info" id="submitEliminasi"><i class="fa fa-refresh"></i> Proses Restore</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-lg-12">
                        <div class="widget style1 white-bg">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fa fa-bar-chart fa-5x"></i>
                                </div>
                                <div class="col-md-6 text-right">
                                    
                                    
                                </div>
                                <div class="col-md-12">
                                    <div id="container" style="width: auto; height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- Info Grafik pie -->
                 <div class="col-md-6">
                    <div class="col-lg-12">
                        <div class="widget style1 white-bg">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fa fa-pie-chart fa-5x"></i>
                                </div>
                                <div class="col-md-6 text-right">
                                    
                                    
                                </div>
                                <div class="col-md-12">
                                    <div id="containerpie" style="width: auto; height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div id="containerpie" style="width: 100%; height: 400px;"></div>
                </div> -->
            </div>
                       
        </div>
    </section>
</div>

<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content animated flipInYbounce">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Profil</h5>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('admin/edit_profile'); ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" value="<?php echo $user['email']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" value="<?php echo $user['nama']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2 font-weight-bolder">Photo</div>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo base_url('assets/dist/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image">
                                    <label class="custom-file-label" for="image">Pilih File</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan </button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ubah-pass">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Password</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <form action="<?php echo base_url('admin/ubah_password'); ?>" method="post">
                        <div class="form-group">
                            <label for="current_password">Password Lama</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password1">Password Baru</label>
                            <input type="password" class="form-control" id="new_password1" name="new_password1" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password2">Ulang Password Baru</label>
                            <input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Ketik ulang password baru" required>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/'); ?>template/js/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectAllEliminasi = document.getElementById("select-all");
        const checkboxesEliminasi = document.querySelectorAll("#eliminasiForm .checkbox-item");

        const selectAllRestore = document.getElementById("select-all-restore");
        const checkboxesRestore = document.querySelectorAll("#RestoreForm .checkbox-item");

        function clearOtherSelection(checkedBox, checkboxesToClear, selectAllToClear) {
            if (checkedBox.checked) {
                checkboxesToClear.forEach(checkbox => checkbox.checked = false);
                selectAllToClear.checked = false;
            }
        }

        // Event untuk "Tandai Semua" Eliminasi
        selectAllEliminasi.addEventListener("change", function () {
            checkboxesEliminasi.forEach(checkbox => checkbox.checked = this.checked);
            clearOtherSelection(this, checkboxesRestore, selectAllRestore);
        });

        // Event untuk "Tandai Semua" Restore
        selectAllRestore.addEventListener("change", function () {
            checkboxesRestore.forEach(checkbox => checkbox.checked = this.checked);
            clearOtherSelection(this, checkboxesEliminasi, selectAllEliminasi);
        });

        // Cek perubahan checkbox Eliminasi secara individual
        checkboxesEliminasi.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                selectAllEliminasi.checked = document.querySelectorAll("#eliminasiForm .checkbox-item:checked").length === checkboxesEliminasi.length;
                clearOtherSelection(this, checkboxesRestore, selectAllRestore);
            });
        });

        // Cek perubahan checkbox Restore secara individual
        checkboxesRestore.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                selectAllRestore.checked = document.querySelectorAll("#RestoreForm .checkbox-item:checked").length === checkboxesRestore.length;
                clearOtherSelection(this, checkboxesEliminasi, selectAllEliminasi);
            });
        });
    });
</script>

<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column' // Menggunakan 'column' seperti yang Anda inginkan
        },
        title: {
            text: 'Visualisasi Hasil Penilaian Alternatif'
        },
        xAxis: {
            categories: [
                <?= $chart_categories_json; ?>
            ]
        },
        yAxis: {
            title: {
                text: 'Hasil Akhir'
            }
        },
        plotOptions: {
            column: {
                // Konfigurasi agar bar tidak saling menimpa
                stacking: 'normal' // Opsional: jika ingin bar tereliminasi dan rekomendasi bertumpuk
                // atau cukup biarkan default jika baris yang sama hanya punya 1 nilai
            }
        },
        series: [{
            name: 'Rekomendasi', // Nama untuk legend (biru)
            data: [
                <?= $chart_data_rekomendasi_json; ?>
            ],
            color: 'blue' // Warna untuk series ini
        }, {
            name: 'Tereliminasi', // Nama untuk legend (merah)
            data: [
                <?= $chart_data_tereliminasi_json; ?>
            ],
            color: 'red' // Warna untuk series ini
        }],
        // Tambahkan legend untuk memastikan posisi dan tampilan legend
        legend: {
            enabled: true,
            layout: 'horizontal',
            align: 'center',
            verticalAlign: 'bottom',
            floating: false
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gunakan base_url dinamis dari CodeIgniter
        const baseUrl = '<?php echo base_url(); ?>'; // Ambil base_url dari CodeIgniter

        // Buat URL lengkap untuk fetch data
        const url = baseUrl + 'perbekel/get_kriteria_data';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const kriteriaData = data.map(item => ({
                    name: item.nama_kriteria,
                    y: parseFloat(item.bobot)
                }));

                // Inisialisasi Highcharts
                Highcharts.chart('containerpie', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: 'Grafik Bobot Kriteria'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}: {point.y}%'
                            }
                        }
                    },
                    series: [{
                        name: 'Bobot',
                        colorByPoint: true,
                        data: kriteriaData
                    }]
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>