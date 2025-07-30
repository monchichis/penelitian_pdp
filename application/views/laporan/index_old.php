<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    
                    
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Filter Data Penilaian</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a></li>
                                    <li><a href="#" class="dropdown-item">Config option 2</a></li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $this->session->flashdata('alert_msg'); ?>
                                    <div class="table table-responsive">
                                        <form method="post" action="<?= base_url('laporan/filter_tahun')?>" enctype="multipart/form-data" class="form-inline">
                                            <div class="form-group mb-2">
                                                <label for="tahun" class="mr-2">Tahun Penilaian</label>
                                                <select class="form-control" name="tahun" id="tahun">
                                                    <option value="">-- Pilih Tahun Penilaian --</option>
                                                    <?php
                                                    $currentYear = date('Y');
                                                    for ($i = 0; $i < 10; $i++) :
                                                        $year = $currentYear - $i; ?>
                                                        <option value="<?= $year ?>"><?= $year ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="form-group mx-sm-3 mb-2">
                                                <button type="submit" class="btn btn-primary">Cari <i class="fa fa-search"></i></button>
                                                &nbsp; &nbsp;
                                                <a href="<?= base_url('laporan/cetak/'.$tahun)?>" class="btn btn-success" target="_blank">
                                                    <i class="fa fa-print"></i> Cetak
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card container-fluid">       
                        <div class="card-body">
                            <?php foreach($identitas as $d) { ?>
                                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                    <div>
                                        <img src="<?php echo base_url('assets/dist/aplikasi/') . $d->logo; ?>" 
                                            style="width: 100px; height: auto;"/>
                                    </div>
                                    <div style="text-align: right;">
                                        <span style="line-height: 1.6; font-weight: bold;">
                                            <?php echo $d->nama_aplikasi; ?>
                                            <br><?php echo $d->alamat; ?>
                                            <br><?php echo $d->telp; ?>
                                        </span>
                                    </div>
                                </div>
                            <?php } ?>
                            
                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <style>
                                    .scrollable-table {
                                        max-height: 300px;
                                        overflow-y: auto;
                                    }
                                    .scrollable-table table {
                                        width: 100%;
                                        table-layout: fixed;
                                    }
                                </style>
                                
                                <!-- <hr>
                                <p align="center">
                                    <b>Nilai Setiap Data Alternatif</b>
                                </p> -->
                                
                                <div class="table table-responsive scrollable-table" hidden>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?php echo $k['nama_kriteria']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($penilaian)): ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                                            Belum ada data.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else:
                                                $grouped_penilaian = [];
                                                
                                                // Grupkan penilaian berdasarkan nama siswa
                                                foreach ($penilaian as $p) {
                                                    $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                }
                                                
                                                foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria): ?>
                                                    <tr>
                                                        <td><?= $nama_siswa; ?></td>
                                                        <?php foreach ($kriteria as $k): 
                                                            $nama_subkriteria = '-';
                                                            $nilai = '';
                                                            $type_kriteria = '';
                                                            
                                                            foreach ($nilai_kriteria as $n) {
                                                                if ($n['nama_kriteria'] == $k['nama_kriteria']) {
                                                                    $id = $n['id'];
                                                                    $nama_subkriteria = $n['nama_subkriteria'];
                                                                    $nilai = $n['nilai'];
                                                                    $type_kriteria = $n['type'];
                                                                    break;
                                                                }
                                                            }
                                                            ?>
                                                            <td>
                                                                <?= $nilai; ?>
                                                                <input type="hidden" name="id_detail_penilaian[]" value="<?= $id; ?>">
                                                                <input type="hidden" name="nilai[]" value="<?= $nilai; ?>">
                                                                <input type="hidden" name="type_kriteria[]" value="<?= $type_kriteria; ?>">
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach;
                                            endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- <hr>
                                <p align="center">
                                    <b>Nilai Normalisasi</b>
                                </p> -->
                            
                                <div class="table table-responsive scrollable-table" hidden>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?php echo $k['nama_kriteria']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($penilaian)): ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                                            Belum ada data.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else:
                                                $grouped_penilaian = [];

                                                foreach ($penilaian as $p) {
                                                    $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                }

                                                foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria): ?>
                                                    <tr>
                                                        <td><?= $nama_siswa; ?></td>
                                                        <?php foreach ($kriteria as $k): 
                                                            $nama_subkriteria = '-';
                                                            $nilai = '';
                                                            $type_kriteria = '';
                                                            $id_kriteria = $k['id'];
                                                            
                                                            foreach ($nilai_kriteria as $n) {
                                                                if ($n['id_kriteria'] == $id_kriteria) {
                                                                    $id = $n['id'];
                                                                    $nama_subkriteria = $n['nama_subkriteria'];
                                                                    $nilai = $n['nilai'];
                                                                    $type_kriteria = $n['type'];
                                                                    break;
                                                                }
                                                            }

                                                            $nilai_min = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_min'] : '-';
                                                            $nilai_max = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_max'] : '-';

                                                            if ($type_kriteria == 1) {
                                                                $hasil = $nilai / $nilai_min;
                                                            } elseif ($type_kriteria == 2) {
                                                                $hasil = $nilai / $nilai_max;
                                                            } else {
                                                                $hasil = '-';
                                                            }
                                                            ?>
                                                            <td>
                                                                <?= ($hasil !== '-') ? number_format($hasil, 3, '.', '') : '-' ?>
                                                                <input type="hidden" name="id_detail_penilaian[]" value="<?= $id; ?>">
                                                                <input type="hidden" name="nilai[]" value="<?= $nilai; ?>">
                                                                <input type="hidden" name="type_kriteria[]" value="<?= $type_kriteria; ?>">
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach;
                                            endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <hr>
                                <p align="center">
                                    <b>Hasil Akhir dan Ranking</b>
                                </p>
                                <div class="table table-responsive scrollable-table">
                                    <form method="post" action="<?= base_url('penilaian/final')?>" enctype="multipart/form-data" id="formPenilaian">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <th>Hasil</th>
                                                    <th>Ranking</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($penilaian) || !is_array($penilaian)): ?>
                                                    <tr>
                                                        <td colspan="<?= (isset($kriteria) && is_array($kriteria)) ? count($kriteria) + 3 : 3; ?>">
                                                            <div class="alert alert-danger animated fadeInDown" role="alert">
                                                                Belum ada data.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php else:
                                                    $grouped_penilaian = [];

                                                    // Kelompokkan penilaian berdasarkan nama siswa
                                                    foreach ($penilaian as $p) {
                                                        $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                    }

                                                    // Hitung total skor untuk setiap siswa
                                                    $total_skor_siswa = [];
                                                    foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria) {
                                                        $total_bobot = 0;
                                                        foreach ($kriteria as $k) {
                                                            $id_kriteria = $k['id'];
                                                            foreach ($nilai_kriteria as $n) {
                                                                if ($n['id_kriteria'] == $id_kriteria) {
                                                                    $nilai = $n['nilai'];
                                                                    $type_kriteria = $n['type'];
                                                                    $bobot_kriteria = $n['bobot'];
                                                                    break;
                                                                }
                                                            }

                                                            $nilai_min = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_min'] : '-';
                                                            $nilai_max = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_max'] : '-';

                                                            if ($type_kriteria == 1) {
                                                                $hasil = $nilai / $nilai_min;
                                                            } elseif ($type_kriteria == 2) {
                                                                $hasil = $nilai / $nilai_max;
                                                            } else {
                                                                $hasil = '-';
                                                            }

                                                            $weighted_value = $hasil * $bobot_kriteria / 100;
                                                            $total_bobot += $weighted_value;
                                                        }
                                                        $total_skor_siswa[$nama_siswa] = $total_bobot;
                                                    }

                                                    // Urutkan siswa berdasarkan total skor dari tertinggi ke terendah
                                                    arsort($total_skor_siswa);

                                                    // Berikan ranking
                                                    $ranking = 1;
                                                    $previous_skor = null;
                                                    $ranked_siswa = [];
                                                    foreach ($total_skor_siswa as $nama_siswa => $total_skor) {
                                                        if ($previous_skor !== null && $total_skor != $previous_skor) {
                                                            $ranking++;
                                                        }
                                                        $ranked_siswa[$nama_siswa] = [
                                                            'ranking' => $ranking,
                                                            'total_skor' => $total_skor
                                                        ];
                                                        $previous_skor = $total_skor;
                                                    }

                                                    // Cari total_skor yang memiliki duplikat (sama)
                                                    $duplicate_skor = array_diff_assoc($total_skor_siswa, array_unique($total_skor_siswa));

                                                    // Urutkan $ranked_siswa berdasarkan ranking dari 1 ke atas
                                                    uasort($ranked_siswa, function($a, $b) {
                                                        return $a['ranking'] - $b['ranking'];
                                                    });

                                                    // Tampilkan data siswa dengan ranking
                                                    foreach ($ranked_siswa as $nama_siswa => $data):
                                                        $total_skor = $data['total_skor'];
                                                        $ranking = $data['ranking'];
                                                        $is_duplicate = in_array($total_skor, $duplicate_skor);
                                                        ?>
                                                        <tr class="<?= $is_duplicate ? 'alert-danger' : '' ?>">
                                                            <td><?= $nama_siswa; ?></td>
                                                            <?php 
                                                            $total_bobot = 0; 
                                                            foreach ($kriteria as $k): 
                                                                $nama_subkriteria = '-';
                                                                $nilai = '';
                                                                $type_kriteria = '';
                                                                $id_kriteria = $k['id'];
                                                                
                                                                foreach ($grouped_penilaian[$nama_siswa] as $n) {
                                                                    if ($n['id_kriteria'] == $id_kriteria) {
                                                                        $id = $n['id'];
                                                                        $id_alternatif = $n['id_alternatif'];
                                                                        $nama_subkriteria = $n['nama_subkriteria'];
                                                                        $nilai = $n['nilai'];
                                                                        $type_kriteria = $n['type'];
                                                                        $bobot_kriteria = $n['bobot'];
                                                                        break;
                                                                    }
                                                                }
                                                                
                                                                $nilai_min = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_min'] : '-';
                                                                $nilai_max = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_max'] : '-';

                                                                if ($type_kriteria == 1) {
                                                                    $hasil = $nilai / $nilai_min;
                                                                } elseif ($type_kriteria == 2) {
                                                                    $hasil = $nilai / $nilai_max;
                                                                } else {
                                                                    $hasil = '-';
                                                                }
                                                                
                                                                $weighted_value = $hasil * $bobot_kriteria / 100;
                                                                $total_bobot += $weighted_value;
                                                            ?>
                                                                
                                                            <?php endforeach; ?>
                                                            <td>
                                                                <?= number_format($total_bobot, 3) ?>
                                                                <input type="hidden" name="id_alternatif[]" value="<?= $id_alternatif; ?>">
                                                                <input type="hidden" name="hasil_akhir[]" value="<?= number_format($total_bobot, 3) ?>">
                                                            </td>
                                                            <td>
                                                                <?= $ranking ?>
                                                                <input type="hidden" name="ranking[]" value="<?= $ranking ?>">
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;
                                                endif; ?>
                                            </tbody>
                                        </table>
                                        
                                        <?php 
                                            $level = $this->session->userdata('level'); 
                                            if ($level == 'Admin' && $cek_header_saw == false): ?>
                                                <button type="button" class="btn btn-primary" id="btnSimpan">
                                                    <i class="fa fa-save"></i> Simpan
                                                </button>
                                            
                                            <?php elseif($level == 'Admin' && $cek_preview == true):?>
                                                <div class="alert alert-success animated fadeInDown" role="alert">
                                                    Data Penilaian Sudah Kirimkan Kepada Perbekel
                                                </div>
                                            <?php endif;?> 
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                <!-- <hr>
                                <p align="center">
                                    <b>Nilai Setiap Data Alternatif</b>
                                </p> -->
                                <div class="table table-responsive scrollable-table" hidden>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?php echo $k['nama_kriteria']; ?></th>
                                                <?php endforeach; ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if (empty($penilaian)) { ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-danger animated fadeInDown " role="alert">
                                                            Belum ada data.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } else {
                                                $no = 1;
                                                $grouped_penilaian = [];
        
                                                // Grupkan penilaian berdasarkan nama siswa
                                                foreach ($penilaian as $p) {
                                                    $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                }
        
                                                foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria): ?>
                                                    <tr>
                                                        
                                                        <td><?= $nama_siswa; ?></td>
        
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <?php 
                                                            $nama_subkriteria = '-'; // Default jika tidak ada data
                                                            $nilai = ''; // Default nilai kosong
                                                            $type_kriteria = '';
                                                            foreach ($nilai_kriteria as $n) {
                                                                if ($n['nama_kriteria'] == $k['nama_kriteria']) {
                                                                    $id = $n['id'];
                                                                    $nama_subkriteria = $n['nama_subkriteria']; // Tampilkan subkriteria
                                                                    $nilai = $n['nilai']; // Simpan nilai dalam input hidden
                                                                    $type_kriteria = $n['type'];
                                                                    break;
                                                                }
                                                            }
                                                            ?>
                                                            <td>
                                                                <?= $nilai; ?> 
                                                                <!-- <input type="text" name="nilai[<?= $nama_siswa; ?>][<?= $k['nama_kriteria']; ?>]" value="<?= $nilai; ?>"> -->
                                                                <input type="hidden" name="id_detail_penilaian[]" value="<?= $id; ?>">
                                                                <input type="hidden" name="nilai[]" value="<?= $nilai; ?>">
                                                                <!-- <input type="text" name="type_kriteria[<?= $nama_siswa; ?>][<?= $k['nama_kriteria']; ?>]" value="<?= $type_kriteria; ?>"> -->
                                                                <input type="hidden" name="type_kriteria[]" value="<?= $type_kriteria; ?>">
                                                            </td>
                                                        <?php endforeach; ?>
        
                                                        
                                                    </tr>
                                                <?php endforeach; 
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <hr>
                                <p align="center">
                                    <b>Menghitung Nilai Utility</b>
                                </p> -->
                                <div class="table table-responsive scrollable-table" hidden>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?php echo $k['nama_kriteria']; ?></th>
                                                <?php endforeach; ?>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if (empty($penilaian)) { ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-danger animated fadeInDown " role="alert">
                                                            Belum ada data.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } else {
                                                $no = 1;
                                                $grouped_penilaian = [];
        
                                                // Grupkan penilaian berdasarkan nama siswa
                                                foreach ($penilaian as $p) {
                                                    $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                }
        
                                                foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria): ?>
                                                    <tr>
                                                        
                                                        <td><?= $nama_siswa; ?></td>
        
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <?php 
                                                            $nama_subkriteria = '-'; // Default jika tidak ada data
                                                            $nilai = ''; // Default nilai kosong
                                                            $type_kriteria = '';
                                                            $nilai_min = '';
                                                            $nilai_max = '';
                                                            $utility = 0;
                                                            $id = ''; // Inisialisasi
                                                            foreach ($nilai_kriteria as $n) {
                                                                if ($n['nama_kriteria'] == $k['nama_kriteria']) {
                                                                    $id = $n['id'];
                                                                    $nama_subkriteria = $n['nama_subkriteria'];
                                                                    $nilai = $n['nilai'];
                                                                    $id_kriteria = $n['id_kriteria'];
                                                                    $type_kriteria = $n['type'];
                                                                    $nilai_min = isset($min_max_smart[$id_kriteria]) ? $min_max_smart[$id_kriteria]['nilai_min'] : '-';
                                                                    $nilai_max = isset($min_max_smart[$id_kriteria]) ? $min_max_smart[$id_kriteria]['nilai_max'] : '-';
                                                                    break;
                                                                }
                                                            }
                                                            // Hitung utility
                                                            if ($nilai_max !== '-' && $nilai_min !== '-' && $nilai_max != $nilai_min) {
                                                                if ($type_kriteria == 1) {
                                                                    $utility = (($nilai - $nilai_min) / ($nilai_max - $nilai_min));
                                                                } else {
                                                                    $utility = (($nilai_max - $nilai) / ($nilai_max - $nilai_min));
                                                                }
                                                            }
                                                            ?>
                                                            <td>
                                                                <?php 
                                                                    if (is_numeric($utility)) {
                                                                        echo number_format($utility, 4, '.', '');
                                                                    } else {
                                                                        echo '0.0000';
                                                                    }
                                                                ?>
                                                                
                                                                <input type="hidden" name="id_detail_penilaian[]" value="<?= htmlspecialchars($id); ?>">
                                                                <input type="hidden" name="nilai[]" value="<?= htmlspecialchars($nilai); ?>">
                                                                <input type="hidden" name="type_kriteria[]" value="<?= htmlspecialchars($type_kriteria); ?>">
                                                            </td>
        
        
                                                        <?php endforeach; ?>
        
                                                        
                                                    </tr>
                                                <?php endforeach; 
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <hr>
                                <p align="center">
                                    <b>Nilai Akhir Normalisasi</b>
                                </p> -->
                                <div class="table table-responsive scrollable-table" hidden>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Alternatif</th>
                                            <?php foreach ($kriteria as $k): ?>
                                                <th><?= $k['nama_kriteria']; ?></th>
                                            <?php endforeach; ?>
                                            <th>Hasil</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($penilaian)): ?>
                                            <tr>
                                                <td colspan="<?= count($kriteria) + 2; ?>">
                                                    <div class="alert alert-danger animated fadeInDown" role="alert">
                                                        Belum ada data.
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php else:
                                            $grouped_penilaian = [];

                                            // Grupkan penilaian berdasarkan nama siswa
                                            foreach ($penilaian as $p) {
                                                $grouped_penilaian[$p['nama_siswa']][] = $p;
                                            }

                                            foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria):
                                                $hasil_akhir = 0; // Reset hasil akhir untuk setiap alternatif
                                        ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($nama_siswa); ?></td>

                                                    <?php foreach ($kriteria as $k): ?>
                                                        <?php 
                                                        $nilai = 0;
                                                        $bobot_kriteria = 0;
                                                        $type_kriteria = '';
                                                        $nilai_min = 0;
                                                        $nilai_max = 0;

                                                        // Cari nilai sesuai kriteria
                                                        foreach ($nilai_kriteria as $n) {
                                                            if ($n['nama_kriteria'] == $k['nama_kriteria']) {
                                                                $nilai = (float)$n['nilai'];
                                                                $id_kriteria = $n['id_kriteria'];
                                                                $bobot_kriteria = (float)$n['bobot'];
                                                                $type_kriteria = $n['type'];

                                                                // Ambil min/max dari array yang sudah dimuat sebelumnya
                                                                if (isset($min_max_smart[$id_kriteria])) {
                                                                    $nilai_min = (float)$min_max_smart[$id_kriteria]['nilai_min'];
                                                                    $nilai_max = (float)$min_max_smart[$id_kriteria]['nilai_max'];
                                                                }
                                                                break;
                                                            }
                                                        }

                                                        // Hitung Utility
                                                        $utility = 0;
                                                        if ($nilai_max != $nilai_min) {
                                                            if ($type_kriteria == 1) {
                                                                // Benefit
                                                                $utility = ($nilai - $nilai_min) / ($nilai_max - $nilai_min);
                                                            } else {
                                                                // Cost
                                                                $utility = ($nilai_max - $nilai) / ($nilai_max - $nilai_min);
                                                            }
                                                        }

                                                        // Normalisasi
                                                        $normalisasi = $utility * ($bobot_kriteria / 100);
                                                        $hasil_akhir += $normalisasi;
                                                        ?>

                                                        <td>
                                                            <?= number_format($normalisasi, 5, '.', ''); ?>
                                                            <input type="hidden" name="nilai[]" value="<?= htmlspecialchars($nilai); ?>">
                                                            <input type="hidden" name="bobot_kriteria[]" value="<?= htmlspecialchars($bobot_kriteria); ?>">
                                                        </td>
                                                    <?php endforeach; ?>
                                                    
                                                    <td><strong><?= number_format($hasil_akhir, 2, '.', ''); ?></strong></td>
                                                </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>

                                </div>
                                <hr>
                                <p align="center">
                                    <b>Hasil Akhir dan Ranking</b>
                                </p>
                                <div class="table table-responsive scrollable-table">
                                    <form method="post" action="<?= base_url('penilaian/final')?>" enctype="multipart/form-data" id="formPenilaian">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <th>Hasil</th>
                                                    <th>Ranking</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($penilaian)): ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="alert alert-danger animated fadeInDown" role="alert">
                                                                Belum ada data.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php else:
                                                    $hasil_ranking = [];
                                                    $grouped_penilaian = [];

                                                    foreach ($penilaian as $p) {
                                                        $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                    }

                                                    foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria) {
                                                        $hasil_akhir = 0;
                                                        $id_alternatif = null;

                                                        foreach ($kriteria as $k) {
                                                            $nilai = 0;
                                                            $bobot_kriteria = 0;
                                                            $type_kriteria = '';
                                                            $nilai_min = 0;
                                                            $nilai_max = 0;

                                                            foreach ($nilai_kriteria as $n) {
                                                                if ($n['nama_kriteria'] == $k['nama_kriteria']) {
                                                                    $nilai = (float)$n['nilai'];
                                                                    $id_kriteria = $n['id_kriteria'];
                                                                    $bobot_kriteria = (float)$n['bobot'];
                                                                    $type_kriteria = $n['type'];
                                                                    if ($id_alternatif === null) {
                                                                        $id_alternatif = $n['id_alternatif'];
                                                                    }

                                                                    if (isset($min_max_smart[$id_kriteria])) {
                                                                        $nilai_min = (float)$min_max_smart[$id_kriteria]['nilai_min'];
                                                                        $nilai_max = (float)$min_max_smart[$id_kriteria]['nilai_max'];
                                                                    }
                                                                    break;
                                                                }
                                                            }

                                                            $utility = 0;
                                                            if ($nilai_max != $nilai_min) {
                                                                if ($type_kriteria == 1) {
                                                                    $utility = ($nilai - $nilai_min) / ($nilai_max - $nilai_min);
                                                                } else {
                                                                    $utility = ($nilai_max - $nilai) / ($nilai_max - $nilai_min);
                                                                }
                                                            }

                                                            $normalisasi = $utility * ($bobot_kriteria / 100);
                                                            $hasil_akhir += $normalisasi;
                                                        }

                                                        $hasil_ranking[] = [
                                                            'id_alternatif' => $id_alternatif,
                                                            'nama_siswa' => $nama_siswa,
                                                            'hasil_akhir' => $hasil_akhir
                                                        ];
                                                    }

                                                    // Urutkan dari nilai tertinggi ke terendah
                                                    usort($hasil_ranking, function ($a, $b) {
                                                        return $b['hasil_akhir'] <=> $a['hasil_akhir'];
                                                    });

                                                    $prev_score = null;
                                                    $rank = 1;

                                                    foreach ($hasil_ranking as $i => $row):
                                                        // Cek hasil sebelumnya
                                                        if ($prev_score !== null && abs($row['hasil_akhir'] - $prev_score) > 0.0001) {
                                                            $rank = $i + 1;
                                                        }

                                                        $row_class = '';
                                                        if ($prev_score !== null && abs($row['hasil_akhir'] - $prev_score) < 0.0001) {
                                                            $row_class = 'class="alert-danger"';
                                                        }

                                                        $prev_score = $row['hasil_akhir'];
                                                ?>
                                                    <tr <?= $row_class; ?>>
                                                        <td><?= htmlspecialchars($row['nama_siswa']); ?></td>
                                                        <td><?= number_format($row['hasil_akhir'], 2, '.', ''); ?></td>
                                                        <td><?= $rank; ?></td>
                                                        <input type="hidden" name="id_alternatif[]" value="<?= htmlspecialchars($row['id_alternatif']); ?>">
                                                        <input type="hidden" name="hasil_akhir[]" value="<?= number_format($row['hasil_akhir'], 4, '.', ''); ?>">
                                                        <input type="hidden" name="ranking[]" value="<?= $rank; ?>">
                                                    </tr>
                                                <?php endforeach; endif; ?>
                                                </tbody>
                                        </table>
                                                                        
                                        <?php 
                                            $level = $this->session->userdata('level'); 
                                            if ($level == 'Admin' && $cek_header_smart == false): ?>
                                                <button type="button" class="btn btn-primary" id="btnSimpan">
                                                    <i class="fa fa-save"></i> Simpan
                                                </button>
                                            
                                            <?php elseif($level == 'Admin' && $cek_preview == true):?>
                                                <div class="alert alert-success animated fadeInDown" role="alert">
                                                    Data Penilaian Sudah Kirimkan Kepada Kepala Sekolah
                                                </div>
                                            <?php endif;?> 


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("btnSimpan").addEventListener("click", function() {
            Swal.fire({
                title: "Konfirmasi Simpan",
                text: "Apakah Anda yakin ingin menyimpan perhitungan akhir ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("formPenilaian").submit();
                }
            });
        });
    });
</script>
