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
            
            <div class="table table-responsive" hidden>
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

            <div class="table table-responsive" hidden>
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
                                        $id = '';

                                        foreach ($nilai_kriteria as $n) {
                                            if ($n['id_kriteria'] == $id_kriteria) {
                                                $id = $n['id'];
                                                $nama_subkriteria = $n['nama_subkriteria'];
                                                $nilai = $n['nilai'];
                                                $type_kriteria = $n['type'];
                                                break;
                                            }
                                        }

                                        // Pastikan nilai minimal dan maksimal ada
                                        $nilai_min = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_min'] : null;
                                        $nilai_max = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_max'] : null;

                                        $hasil = '-'; // Default jika tidak bisa dihitung

                                        if (is_numeric($nilai)) {
                                            if ($type_kriteria == 1 && is_numeric($nilai_min) && $nilai_min > 0) {
                                                $hasil = $nilai / $nilai_min;
                                            } elseif ($type_kriteria == 2 && is_numeric($nilai_max) && $nilai_max > 0) {
                                                $hasil = $nilai / $nilai_max;
                                            }
                                        }
                                        ?>
                                        <td>
                                            <?= ($hasil !== '-') ? number_format($hasil, 3, '.', '') : '-' ?>
                                            <input type="hidden" name="id_detail_penilaian[]" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="nilai[]" value="<?= htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="type_kriteria[]" value="<?= htmlspecialchars($type_kriteria, ENT_QUOTES, 'UTF-8'); ?>">
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
            <div class="table table-responsive">
                <form method="post" action="<?= base_url('penilaian/final')?>" enctype="multipart/form-data" id="formPenilaian">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 20%">Alternatif</th>
                                <?php if (!empty($kriteria) && is_array($kriteria)): ?>
                                    <?php foreach ($kriteria as $k): ?>
                                        <th><?php echo htmlspecialchars($k['nama_kriteria'], ENT_QUOTES, 'UTF-8'); ?></th>
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
                                        $nilai = 0;
                                        $type_kriteria = null;
                                        $bobot_kriteria = 0;

                                        foreach ($nilai_kriteria as $n) {
                                            if ($n['id_kriteria'] == $id_kriteria) {
                                                $nilai = $n['nilai'];
                                                $type_kriteria = $n['type'];
                                                $bobot_kriteria = $n['bobot'];
                                                break;
                                            }
                                        }

                                        $nilai_min = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_min'] : null;
                                        $nilai_max = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_max'] : null;
                                        $hasil = '-';

                                        if (is_numeric($nilai)) {
                                            if ($type_kriteria == 1 && is_numeric($nilai_min) && $nilai_min > 0) {
                                                $hasil = $nilai / $nilai_min;
                                            } elseif ($type_kriteria == 2 && is_numeric($nilai_max) && $nilai_max > 0) {
                                                $hasil = $nilai / $nilai_max;
                                            }
                                        }

                                        $weighted_value = ($hasil !== '-') ? $hasil * ($bobot_kriteria / 100) : 0;
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

                                // Tampilkan data siswa dengan ranking
                                foreach ($ranked_siswa as $nama_siswa => $data):
                                    $total_skor = $data['total_skor'];
                                    $ranking = $data['ranking'];
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($nama_siswa, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <?php 
                                        $total_bobot = 0;
                                        foreach ($kriteria as $k): 
                                            $nilai = 0;
                                            $type_kriteria = null;
                                            $bobot_kriteria = 0;
                                            $id_kriteria = $k['id'];
                                            $id = '';

                                            foreach ($grouped_penilaian[$nama_siswa] as $n) {
                                                if ($n['id_kriteria'] == $id_kriteria) {
                                                    $id = $n['id'];
                                                    $nilai = $n['nilai'];
                                                    $type_kriteria = $n['type'];
                                                    $bobot_kriteria = $n['bobot'];
                                                    break;
                                                }
                                            }

                                            $nilai_min = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_min'] : null;
                                            $nilai_max = isset($min_max_saw[$id_kriteria]) ? $min_max_saw[$id_kriteria]['nilai_max'] : null;
                                            $hasil = '-';

                                            if (is_numeric($nilai)) {
                                                if ($type_kriteria == 1 && is_numeric($nilai_min) && $nilai_min > 0) {
                                                    $hasil = $nilai / $nilai_min;
                                                } elseif ($type_kriteria == 2 && is_numeric($nilai_max) && $nilai_max > 0) {
                                                    $hasil = $nilai / $nilai_max;
                                                }
                                            }

                                            $weighted_value = ($hasil !== '-') ? $hasil * ($bobot_kriteria / 100) : 0;
                                            $total_bobot += $weighted_value;
                                        ?>
                                            <td>
                                                <?= number_format($weighted_value, 3, '.', '') ?>
                                                <input type="hidden" name="id_detail_penilaian[]" value="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                                                <input type="hidden" name="nilai[]" value="<?= htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8'); ?>">
                                                <input type="hidden" name="type_kriteria[]" value="<?= htmlspecialchars($type_kriteria, ENT_QUOTES, 'UTF-8'); ?>">
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

                    
                </form>
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