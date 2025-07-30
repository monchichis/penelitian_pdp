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
                    <div class="alert alert-info animated fadeInDown">
                        <h4 class="alert-heading">Definisi Metode SAW</h4>
                        <p>Metode SAW (Simple Additive Weighting) adalah teknik pengambilan keputusan yang digunakan untuk menentukan pilihan terbaik dari beberapa alternatif berdasarkan sejumlah kriteria dengan cara menghitung nilai total setiap alternatif sebagai penjumlahan terbobot dari nilai-nilai kriteria.</p>
                        <p>Berikut adalah cara kerja metode SAW:</p>
                        <ul>
                            <li>Identifikasi alternatif-alternatif yang akan dievaluasi.</li>
                            <li>Tentukan kriteria-kriteria yang relevan untuk mengevaluasi setiap alternatif.</li>
                            <li>Lakukan normalisasi matriks keputusan agar semua nilai kriteria dapat dibandingkan secara adil menggunakan rumus normalisasi untuk kriteria benefit dan cost.</li>
                            <li>Tentukan bobot untuk setiap kriteria berdasarkan tingkat pentingnya, dengan memastikan total bobot seluruh kriteria sama dengan 1.</li>
                            <li>Hitung nilai preferensi untuk setiap alternatif dengan menjumlahkan hasil perkalian antara bobot kriteria dan nilai normalisasi pada setiap kriteria.</li>
                            <li>Urutkan nilai preferensi dari yang tertinggi hingga terendah, dan pilih alternatif dengan nilai preferensi tertinggi sebagai solusi terbaik.</li>
                        </ul>
                    </div>
                    
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
                    
                    <div class="card">       
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
                            
                            <hr>
                            <p align="center">
                                <b>Nilai Setiap Data Alternatif</b>
                            </p>
                            
                            <div class="table table-responsive scrollable-table">
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
                            
                            <hr>
                            <p align="center">
                                <b>Nilai Normalisasi</b>
                            </p>
                           
                            <div class="table table-responsive scrollable-table">
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
                                                <th style="width: 20%">Alternatif</th>
                                                <?php if (isset($kriteria) && is_array($kriteria)): ?>
                                                    <?php foreach ($kriteria as $k): ?>
                                                        <th><?php echo $k['nama_kriteria']; ?></th>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                <th>Total</th>
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
                                                            <td>
                                                                <?= number_format($weighted_value, 3, '.', '') ?>
                                                                <input type="hidden" name="id_detail_penilaian[]" value="<?= $id; ?>">
                                                                <input type="hidden" name="nilai[]" value="<?= $nilai; ?>">
                                                                <input type="hidden" name="type_kriteria[]" value="<?= $type_kriteria; ?>">
                                                            </td>
                                                        <?php endforeach; ?>
                                                        <td>
                                                            <?= number_format($total_bobot, 3) ?>
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
                                    if($cek_header_saw): ?>
                                        <div class="alert alert-warning animated fadeInDown" role="alert">
                                            Data Penilaian Menunggu Review Perbekel
                                        </div>
                                    <?php elseif($level == 'Admin' && !$cek_header_saw): ?>
                                        <button type="button" class="btn btn-primary" id="btnSimpan">
                                            <i class="fa fa-save"></i> Validasi Penilaian
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
