<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="<?php echo base_url('assets/'); ?>template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>template/css/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>template/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>template/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>template/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>template/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/'); ?>template/css/plugins/izitoast/iziToast.min.css" rel="stylesheet">
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
</head>
<body onload="window.print()">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="row">
                            <!-- <div class="col-md-6">
                                <hr>
                                <p align="center"><b>Nilai Setiap Data Alternatif Metode SAW</b></p>
                                <div class="table-responsive scrollable-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?= $k['nama_kriteria']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Group data penilaian by alternative for easier access (dilakukan di awal view)
                                            $grouped_penilaian = [];
                                            foreach ($penilaian as $p) {
                                                $grouped_penilaian[$p['id_alternatif']]['nama_siswa'] = $p['nama_siswa'];
                                                $grouped_penilaian[$p['id_alternatif']]['nilai_kriteria'][$p['id_kriteria']] = [
                                                    'nilai' => $p['nilai'],
                                                    'type' => $p['type'], // Menggunakan type_kriteria dari model
                                                    'bobot' => $p['bobot'] // Menggunakan bobot_kriteria dari model
                                                ];
                                            }

                                            if (empty($grouped_penilaian)): ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                                            Belum ada data penilaian.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($grouped_penilaian as $id_alt => $alternatif_data): ?>
                                                    <tr>
                                                        <td><?= $alternatif_data['nama_siswa']; ?></td>
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <td>
                                                                <?= isset($alternatif_data['nilai_kriteria'][$k['id']]['nilai']) ? $alternatif_data['nilai_kriteria'][$k['id']]['nilai'] : '-'; ?>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                
                                <hr>
                                <p align="center"><b>Nilai Setiap Data Alternatif Metode SMART</b></p>
                                <div class="table-responsive scrollable-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?= $k['nama_kriteria']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($grouped_penilaian)): // Reuse grouped_penilaian from above ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-danger animated fadeInDown" role="alert">
                                                            Belum ada data penilaian.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($grouped_penilaian as $id_alt => $alternatif_data): ?>
                                                    <tr>
                                                        <td><?= $alternatif_data['nama_siswa']; ?></td>
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <td>
                                                                <?= isset($alternatif_data['nilai_kriteria'][$k['id']]['nilai']) ? $alternatif_data['nilai_kriteria'][$k['id']]['nilai'] : '-'; ?>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php
                                    // Inisialisasi array untuk perhitungan SAW di dalam view
                                    $saw_normalisasi = [];
                                    $saw_hasil_akhir = [];

                                    if (!empty($grouped_penilaian)) {
                                        foreach ($grouped_penilaian as $id_alternatif => $alternatif_data) {
                                            $total_saw_score = 0;
                                            foreach ($kriteria as $k) { // Loop melalui kriteria yang tersedia
                                                $id_kriteria = $k['id'];
                                                $nilai_mentah = isset($alternatif_data['nilai_kriteria'][$id_kriteria]['nilai']) ? $alternatif_data['nilai_kriteria'][$id_kriteria]['nilai'] : 0;
                                                $type_kriteria = (int) $k['type']; // Ambil tipe dari objek kriteria langsung (nilai 1 atau 2)
                                                $bobot_kriteria = (float) $k['bobot'] / 100; // MENGGUNAKAN $k['bobot'] dan dibagi 100

                                                // Dapatkan nilai min dan max untuk kriteria ini dari data min_max_saw
                                                $min_val = isset($min_max_saw[$id_kriteria]['nilai_min']) ? $min_max_saw[$id_kriteria]['nilai_min'] : 1;
                                                $max_val = isset($min_max_saw[$id_kriteria]['nilai_max']) ? $min_max_saw[$id_kriteria]['nilai_max'] : 5;

                                                $normalisasi_val = 0;
                                                if ($type_kriteria == 1) { // Benefit (1)
                                                    if ($max_val > 0) {
                                                        $normalisasi_val = $nilai_mentah / $max_val;
                                                    }
                                                } else if ($type_kriteria == 2) { // Cost (2)
                                                    if ($nilai_mentah > 0) {
                                                        $normalisasi_val = $min_val / $nilai_mentah;
                                                    }
                                                } else {
                                                    $normalisasi_val = 0; // Fallback for undefined type
                                                }
                                                $saw_normalisasi[$id_alternatif][$id_kriteria] = round($normalisasi_val, 4);
                                                $total_saw_score += ($normalisasi_val * $bobot_kriteria);
                                            }
                                            $saw_hasil_akhir[$id_alternatif] = round($total_saw_score, 4);
                                        }
                                    }
                                ?>
                                <!-- <h5 class="mb-3">1. Matriks Normalisasi (R) - SAW</h5>
                                <div class="table-responsive scrollable-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?= $k['nama_kriteria']; ?><br>(<?= ($k['type'] == 1) ? 'Benefit' : 'Cost'; ?>)</th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($saw_normalisasi)): ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-info animated fadeInDown" role="alert">
                                                            Data normalisasi SAW belum tersedia.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($grouped_penilaian as $id_alt => $alt_data): ?>
                                                    <tr>
                                                        <td><?= $alt_data['nama_siswa']; ?></td>
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <td>
                                                                <?= isset($saw_normalisasi[$id_alt][$k['id']]) ? $saw_normalisasi[$id_alt][$k['id']] : '-'; ?>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div> -->

                                <h5 class="mt-4 mb-3">Hasil Akhir (V) & Ranking - SAW</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Alternatif</th>
                                                <th>Nilai SAW</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($saw_hasil_akhir)): ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="alert alert-info animated fadeInDown" role="alert">
                                                            Hasil akhir SAW belum tersedia.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php
                                                // Urutkan hasil akhir SAW dari terbesar ke terkecil
                                                arsort($saw_hasil_akhir);

                                                $rank = 1;
                                                $prev_score = null;
                                                $rank_counter = 1;

                                                foreach ($saw_hasil_akhir as $id_alt => $total_score):
                                                    $row_class = '';
                                                    if ($prev_score !== null && $total_score == $prev_score) {
                                                        $current_rank = $rank - 1; // Gunakan ranking sebelumnya
                                                        $row_class = 'table-danger'; // Bootstrap class for red background
                                                    } else {
                                                        $current_rank = $rank_counter;
                                                    }
                                                    $prev_score = $total_score;
                                                    $rank = $current_rank;
                                                    $rank_counter++;
                                                ?>
                                                <tr class="<?= $row_class; ?>">
                                                    <td>
                                                        <?= $current_rank; ?>
                                                        <input type="hidden" name="ranking_saw[]" value="<?= $current_rank; ?>">
                                                    </td>
                                                    <td><?= $grouped_penilaian[$id_alt]['nama_siswa']; ?></td>
                                                    <td>
                                                        <?= $total_score; ?>
                                                        <input type="hidden" name="nilai_saw[]" value="<?= $total_score; ?>">
                                                        <input type="hidden" name="id_alternatif_saw[]" value="<?= $id_alt; ?>">
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    // Inisialisasi array untuk perhitungan SMART di dalam view
                                    $smart_utility = [];
                                    $smart_hasil_akhir = [];

                                    if (!empty($grouped_penilaian)) {
                                        foreach ($grouped_penilaian as $id_alternatif => $alternatif_data) {
                                            $total_smart_score = 0;
                                            foreach ($kriteria as $k) { // Loop melalui kriteria yang tersedia
                                                $id_kriteria = $k['id'];
                                                $nilai_mentah = isset($alternatif_data['nilai_kriteria'][$id_kriteria]['nilai']) ? $alternatif_data['nilai_kriteria'][$id_kriteria]['nilai'] : 0;
                                                $type_kriteria = (int) $k['type']; // Ambil tipe dari objek kriteria langsung (nilai 1 atau 2)
                                                $bobot_kriteria = (float) $k['bobot'] / 100; // Menggunakan $k['bobot'] dan dibagi 100

                                                // Dapatkan nilai min dan max dari rentang nilai subkriteria untuk kriteria ini
                                                $min_scale_val = isset($min_max_smart[$id_kriteria]['nilai_min']) ? $min_max_smart[$id_kriteria]['nilai_min'] : 1;
                                                $max_scale_val = isset($min_max_smart[$id_kriteria]['nilai_max']) ? $min_max_smart[$id_kriteria]['nilai_max'] : 5;

                                                $utility_val = 0;
                                                if (($max_scale_val - $min_scale_val) > 0) {
                                                    if ($type_kriteria == 1) { // Benefit (1)
                                                        $utility_val = (($nilai_mentah - $min_scale_val) / ($max_scale_val - $min_scale_val)); // HAPUS * 100
                                                    } else if ($type_kriteria == 2) { // Cost (2)
                                                        $utility_val = (($max_scale_val - $nilai_mentah) / ($max_scale_val - $min_scale_val)); // HAPUS * 100
                                                    } else {
                                                        $utility_val = 0; // Fallback for undefined type
                                                    }
                                                } else {
                                                    // Jika min_scale_val == max_scale_val, nilai utilitas adalah 1 (jika cocok) atau 0
                                                    $utility_val = ($nilai_mentah == $min_scale_val) ? 1 : 0; // Ubah dari 100 menjadi 1
                                                }
                                                
                                                $smart_utility[$id_alternatif][$id_kriteria] = round($utility_val, 4); // Bulatkan ke 4 desimal untuk konsistensi dengan 0.xx
                                                $total_smart_score += ($utility_val * $bobot_kriteria);
                                            }
                                            $smart_hasil_akhir[$id_alternatif] = round($total_smart_score, 4); // Bulatkan ke 4 desimal
                                        }
                                    }
                                ?>
                                <!-- <h5 class="mb-3">1. Nilai Utilitas (U) - SMART</h5>
                                <div class="table-responsive scrollable-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Alternatif</th>
                                                <?php foreach ($kriteria as $k): ?>
                                                    <th><?= $k['nama_kriteria']; ?><br>(<?= ($k['type'] == 1) ? 'Benefit' : 'Cost'; ?>)</th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($smart_utility)): ?>
                                                <tr>
                                                    <td colspan="<?= count($kriteria) + 1; ?>">
                                                        <div class="alert alert-info animated fadeInDown" role="alert">
                                                            Data utilitas SMART belum tersedia.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($grouped_penilaian as $id_alt => $alt_data): ?>
                                                    <tr>
                                                        <td><?= $alt_data['nama_siswa']; ?></td>
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <td>
                                                                <?= isset($smart_utility[$id_alt][$k['id']]) ? $smart_utility[$id_alt][$k['id']] : '-'; ?>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div> -->

                                <h5 class="mt-4 mb-3">Hasil Akhir (V) & Ranking - SMART</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Alternatif</th>
                                                <th>Nilai SMART</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($smart_hasil_akhir)): ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="alert alert-info animated fadeInDown" role="alert">
                                                            Hasil akhir SMART belum tersedia.
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php
                                                // Urutkan hasil akhir SMART dari terbesar ke terkecil
                                                arsort($smart_hasil_akhir);

                                                $rank = 1;
                                                $prev_score = null;
                                                $rank_counter = 1; 

                                                foreach ($smart_hasil_akhir as $id_alt => $total_score):
                                                    $row_class = '';
                                                    if ($prev_score !== null && $total_score == $prev_score) {
                                                        $current_rank = $rank - 1; // Gunakan ranking sebelumnya
                                                        $row_class = 'table-danger'; // Bootstrap class for red background
                                                    } else {
                                                        $current_rank = $rank_counter;
                                                    }
                                                    $prev_score = $total_score;
                                                    $rank = $current_rank; 

                                                    $rank_counter++; 
                                                ?>
                                                    <tr class="<?= $row_class; ?>">
                                                        <td>
                                                            <?= $current_rank; ?>
                                                            <input type="hidden" name="ranking_smart[]" value="<?= $current_rank; ?>">
                                                        </td>
                                                        <td><?= $grouped_penilaian[$id_alt]['nama_siswa']; ?></td>
                                                        <td>
                                                            <?= $total_score; ?>
                                                            <input type="hidden" name="nilai_smart[]" value="<?= $total_score; ?>">
                                                            <input type="hidden" name="id_alternatif_smart[]" value="<?= $id_alt; ?>">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
            
            

        </div>
    </div>
</body>
<!-- Mainly scripts -->
<script src="<?php echo base_url('assets/'); ?>template/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/popper.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/bootstrap.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/metisMenu/jquery.metisMenu.js"></script>

<script src="<?php echo base_url('assets/'); ?>template/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url('assets/'); ?>template/js/inspinia.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/pace/pace.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url('assets/'); ?>template/js/plugins/izitoast/iziToast.min.js"></script>
</html>