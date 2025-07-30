<style>
    /* Menyelaraskan isi welcome-section */
#welcome-section {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

/* Mengatur ukuran logo */
#welcome-section img {
    max-width: 100%;
    height: auto;
}
</style>
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
            <?php echo $this->session->flashdata('alert_msg'); ?>
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger">
                    <a class="close" data-dismiss="alert">x</a>
                    <strong><?php echo strip_tags(validation_errors()); ?></strong>
                </div>
            <?php } ?>
            <div class="row d-flex flex-column">
                <div class="row">
                    <!-- Ucapan selamat datang -->
                    <div class="col-lg-4" id="welcome-section">
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
                    <div class="col-lg-4" id="info-data-section">
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
                    <!-- Info Grafik pie -->
                     <div class="col-lg-4">
                        <div class="col-lg-12">
                            <div class="widget style1 white-bg">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-pie-chart fa-5x"></i>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div id="container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    <!-- <div class="col-lg-4">
                         <div id="container" style="width: 100%; height: 400px;"></div>
                    </div> -->
                    
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
                <!-- <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Daftar Rekomendasi</h5>
                        </div>
                        <div class="ibox-content">
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
                                            
                                            <th>Alternatif</th>
                                            <th>Hasil</th>
                                            <th>Ranking</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($preview_penilaian)) : ?>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="alert alert-info animated fadeInDown" role="alert">
                                                        Belum ada data.
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else : 
                                            $duplikat_counts = [];

                                            // Hitung jumlah kemunculan kombinasi hasil_akhir dan ranking
                                            foreach ($preview_penilaian as $pp) {
                                                $hasil_akhir = number_format($pp['hasil_akhir'], 2, '.', '');
                                                $key = $hasil_akhir . '-' . $pp['ranking'];
                                                if (!isset($duplikat_counts[$key])) {
                                                    $duplikat_counts[$key] = 1;
                                                } else {
                                                    $duplikat_counts[$key]++;
                                                }
                                            }

                                            // Tampilkan data dengan warna merah jika hasil_akhir dan ranking duplikat
                                            foreach ($preview_penilaian as $pp) : 
                                                $hasil_akhir = number_format($pp['hasil_akhir'], 2, '.', '');
                                                $key = $hasil_akhir . '-' . $pp['ranking'];
                                                $row_class = ($duplikat_counts[$key] > 1) ? 'table-danger' : '';
                                        ?>
                                            <tr class="<?= $row_class; ?>">
                                                <td><?= $pp['nama_siswa'] ?></td>
                                                <td><?= $hasil_akhir ?></td>
                                                <td><?= $pp['ranking'] ?></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Alternatif Tereleminasi</h5>
                        </div>
                        <div class="ibox-content">
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
                                            <th>Alternatif</th>
                                            <th>Hasil</th>
                                            <th>Ranking</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($eliminasi_alternatif)) : ?>
                                            <tr>
                                                <td colspan="3">
                                                    <div class="alert alert-info animated fadeInDown" role="alert">
                                                        Belum ada data.
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else : 
                                            $duplikat_counts = [];

                                            // Hitung jumlah kemunculan kombinasi hasil_akhir dan ranking
                                            foreach ($eliminasi_alternatif as $pp) {
                                                $hasil_akhir = number_format($pp['hasil_akhir'], 2, '.', '');
                                                $key = $hasil_akhir . '-' . $pp['ranking'];
                                                if (!isset($duplikat_counts[$key])) {
                                                    $duplikat_counts[$key] = 1;
                                                } else {
                                                    $duplikat_counts[$key]++;
                                                }
                                            }

                                            // Tampilkan data dengan warna merah jika hasil_akhir dan ranking duplikat
                                            foreach ($eliminasi_alternatif as $pp) : 
                                                $hasil_akhir = number_format($pp['hasil_akhir'], 2, '.', '');
                                                $key = $hasil_akhir . '-' . $pp['ranking'];
                                                $row_class = ($duplikat_counts[$key] > 1) ? 'table-danger' : '';
                                        ?>
                                            <tr class="<?= $row_class; ?>">
                                                <td><?= $pp['nama_siswa'] ?></td>
                                                <td><?= $hasil_akhir ?></td>
                                                <td><?= $pp['ranking'] ?></td>
                                                
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gunakan base_url dinamis dari CodeIgniter
        const baseUrl = '<?php echo base_url(); ?>'; // Ambil base_url dari CodeIgniter

        // Buat URL lengkap untuk fetch data
        const url = baseUrl + 'admin/get_kriteria_data';

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const kriteriaData = data.map(item => ({
                    name: item.nama_kriteria,
                    y: parseFloat(item.bobot)
                }));

                // Inisialisasi Highcharts
                Highcharts.chart('container', {
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Ambil elemen welcome-section dan info-data-section
    const welcomeSection = document.getElementById('welcome-section');
    const infoDataSection = document.getElementById('info-data-section');

    // Hitung tinggi elemen info-data-section
    const infoDataHeight = infoDataSection.offsetHeight;

    // Atur tinggi welcome-section sesuai dengan tinggi info-data-section
    welcomeSection.style.height = `${infoDataHeight}px`;

    // Opsional: Tambahkan padding atau margin jika diperlukan
    welcomeSection.style.display = 'flex';
    welcomeSection.style.alignItems = 'center';
    welcomeSection.style.justifyContent = 'center';
});
</script>