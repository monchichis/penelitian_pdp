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
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Default box -->
            <div class="row">
                <!-- left column -->
               
                    <div class="col-md-6">

                        <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                        <?php if (validation_errors()) { ?>
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert">x</a>
                                <strong><?php echo strip_tags(validation_errors()); ?></strong>
                            </div>
                        <?php } ?>
                        <!-- general form elements -->
                        
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Penilaian Alternatif</h5>
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
                                        <div class="table table-responsive">
                                            <form method="post" action="<?= base_url('penilaian/add')?>" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label> Pilih Alternatif</label>
                                                <select class="form-control" name="id_alternatif" id="id_alternatif">
                                                    <option value="">-- Pilih Alternatif --</option>
                                                    <?php foreach ($alternatif as $a): ?>
                                                        <option value="<?php echo $a['id']; ?>"><?php echo $a['nama_siswa']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                                <div class="form-group">
                                                    <label>Pilih Kriteria</label>
                                                    <select class="form-control" name="id_kriteria" id="id_kriteria">
                                                        <option value="">-- Pilih Kriteria --</option>
                                                        <?php foreach ($kriteria as $k): ?>
                                                            <option value="<?php echo $k['id']; ?>"><?php echo $k['nama_kriteria']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="subkriteria-container" style="display: none;">
                                                    <label>Pilih Subkriteria</label>
                                                    <select class="form-control" name="id_subkriteria" id="id_subkriteria">
                                                        <option value="">-- Pilih Subkriteria --</option>
                                                        <?php foreach ($subkriteria as $s): ?>
                                                            <option value="<?php echo $s['id_subkriteria']; ?>"><?php echo $s['nama_subkriteria']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary btn-block"> Tambahkan <i class="fa fa-arrow-circle-right"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $this->session->flashdata('alert_msg'); ?>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                Preview Penilaian
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#import"><i class="fa fa-upload"></i> Import</button>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#petunjuk"><i class="fa fa-question"></i> Petunjuk</button>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                <div class="table table-responsive">
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
                                    <form id="hitungForm" action="<?= base_url('penilaian/hitung'); ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="table table-responsive scrollable-table">
                                                <table class="table table-bordered table-hover ">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Alternatif</th>
                                                            <?php foreach ($kriteria as $k): ?>
                                                                <th><?php echo $k['nama_kriteria']; ?></th>
                                                            <?php endforeach; ?>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $no = 1;
                                                        $grouped_penilaian = [];
                
                                                        // Grupkan penilaian berdasarkan nama siswa
                                                        foreach ($penilaian as $p) {
                                                            $grouped_penilaian[$p['nama_siswa']][] = $p;
                                                        }
                
                                                        foreach ($grouped_penilaian as $nama_siswa => $nilai_kriteria): ?>
                                                            <tr>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= $nama_siswa; ?></td>
                
                                                                <?php foreach ($kriteria as $k): ?>
                                                                    <?php 
                                                                    $nama_subkriteria = '-'; // Default jika tidak ada data
                                                                    $nilai = ''; // Default nilai kosong
                                                                    $type_kriteria = '';
                                                                    foreach ($nilai_kriteria as $n) {
                                                                        if ($n['nama_kriteria'] == $k['nama_kriteria']) {
                                                                            $id = $n['id'];
                                                                            $id_alternatif = $n['id_alternatif'];
                                                                            $id_kriteria = $n['id_kriteria'];
                                                                            $nama_subkriteria = $n['nama_subkriteria']; // Tampilkan subkriteria
                                                                            $nilai = $n['nilai']; // Simpan nilai dalam input hidden
                                                                            $type_kriteria = $n['type'];
                                                                            break;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <td>
                                                                        <?= $nama_subkriteria; ?> 
                                                                        <!-- <input type="text" name="nilai[<?= $nama_siswa; ?>][<?= $k['nama_kriteria']; ?>]" value="<?= $nilai; ?>"> -->
                                                                        <input type="hidden" name="id_detail_penilaian[]" value="<?= $id; ?>">
                                                                        <input type="hidden" name="nilai[]" value="<?= $nilai; ?>">
                                                                        <!-- <input type="text" name="type_kriteria[<?= $nama_siswa; ?>][<?= $k['nama_kriteria']; ?>]" value="<?= $type_kriteria; ?>"> -->
                                                                        <input type="hidden" name="id_kriteria[]" value="<?= $id_kriteria; ?>">
                                                                        <input type="hidden" name="type_kriteria[]" value="<?= $type_kriteria; ?>">
                                                                        <input type="hidden" name="id_alternatif[]" value="<?= $id_alternatif; ?>">
                                                                    </td>
                                                                <?php endforeach; ?>
                
                                                                <td>
                                                                    <a href="#" class="btn btn-warning btn-sm edit-btn" data-id="<?= $id_alternatif; ?>" data-toggle="modal" data-target="#edit-penilaian">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>
                                                                    <a href="<?= base_url('penilaian/delete/' . $id_alternatif); ?>" class="btn btn-danger btn-sm delete-btn" data-id="<?= $id_alternatif ?>"> 
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <!-- <?php if (!$all_alternatif_filled): ?>disabled<?php endif; ?> -->
                                            <button type="button" class="btn btn-primary btn-sm btn-block" id="hitungButton">
                                                <i class="fa fa-calculator"></i> Hitung
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>         
                    </div>
                
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<div class="modal inmodal" id="edit-penilaian" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Edit Data Penilaian</h4>
                <small class="font-bold">Ubahlah sesuai dengan yang diinginkan.</small>
            </div>
            <div class="modal-body">
                <!-- Data akan dimuat di sini secara dinamis -->
                <form id="edit-form" method="post" action="<?php echo site_url('penilaian/update_penilaian'); ?>">
                    <input type="hidden" name="id_alternatif" id="id_alternatif">
                    <div id="dynamic-fields"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="edit-form">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="import" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Import Data Penilaian</h4>
                <small class="font-bold">Silahkan menggunakan template yang sudah ditentukan.</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo site_url('penilaian/import'); ?>" method="post" enctype="multipart/form-data">
                            <!-- <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Alternatif</label>
                                        <table class="table table-striped table-bordered table-hover" id="">
                                            <thead>
                                                <tr>
                                                    <th>Id Alternatif</th>
                                                    <th>Nama Alternatif</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                    <?php foreach($alternatif as $al):?>
                                                        <tr>
                                                            <td><?= $al['id']?></td>
                                                            <td><?= $al['nama_siswa']?></td>

                                                        </tr>
                                                    <?php endforeach;?>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kriteria</label>
                                        <table class="table table-striped table-bordered table-hover" id="">
                                            <thead>
                                                <tr>
                                                    <th>Id Kriteria</th>
                                                    <th>Nama Kriteria</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                </tr>
                                                <?php foreach($kriteria as $k):?>
                                                    <tr>
                                                        <td><?= $k['id']?></td>
                                                        <td><?= $k['nama_kriteria']?></td>

                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Subkriteria</label>
                                        <table class="table table-striped table-bordered table-hover" id="">
                                            <thead>
                                                <tr>
                                                    <th>Id Subkriteria</th>
                                                    <th>Nama Subkriteria</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($subkriteria as $sk):?>
                                                    <tr>
                                                        <td><?= $sk['id']?></td>
                                                        <td><?= $sk['nama_subkriteria']?></td>

                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <a href="<?= base_url('assets/upload_template/template_penilaian.csv')?>" class="btn btn-info"><i class="fa fa-download"></i> Download Template</a>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="petunjuk" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Informasi Alternatif, Kriteria dan Subkriteria</h4>
                <small class="font-bold">Silahkan menggunakan template yang sudah ditentukan.</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
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

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Alternatif</label>
                                        <div class="table-responsive scrollable-table">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Id Alternatif</th>
                                                        <th>Nama Alternatif</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($alternatif as $al): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($al['id']) ?></td>
                                                            <td><?= htmlspecialchars($al['nama_siswa']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kriteria</label>
                                        <div class="table-responsive scrollable-table">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Id Kriteria</th>
                                                        <th>Nama Kriteria</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($kriteria as $k): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($k['id']) ?></td>
                                                            <td><?= htmlspecialchars($k['nama_kriteria']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Subkriteria</label>
                                        <div class="table-responsive scrollable-table">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Id Subkriteria</th>
                                                        <th>Nama Subkriteria</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($subkriteria as $sk): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($sk['id']) ?></td>
                                                            <td><?= htmlspecialchars($sk['nama_subkriteria']) ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('assets/'); ?>template/js/jquery-3.1.1.min.js"></script>
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tangkap semua tombol dengan class "delete-btn"
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                // Mencegah aksi default dari link
                event.preventDefault();

                // Ambil URL dari atribut href
                const url = this.getAttribute('href');

                // Tampilkan SweetAlert2 untuk konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data Alternatif ini akan dihapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, redirect ke URL penghapusan
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_kriteria').select2({
            placeholder: "-- Pilih Kriteria --",
            allowClear: true
        });

         $('#id_alternatif').select2({
            placeholder: "-- Pilih Alternatif --",
            allowClear: true
        });

        
    });
</script>
<script>
    $(document).ready(function() {
        $('#id_kriteria').change(function() {
            var id_kriteria = $(this).val();

            if (id_kriteria) {
                $('#subkriteria-container').show(); // Menampilkan subkriteria jika kriteria dipilih
                $.ajax({
                    url: "<?php echo site_url('penilaian/getSubkriteriaByKriteria'); ?>",
                    method: "POST",
                    data: {
                        id_kriteria: id_kriteria
                    },
                    dataType: 'json',
                    success: function(data) {
                        var html = '<option value="">-- Pilih Subkriteria --</option>';
                        for (var i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].id + '">' + data[i].nama_subkriteria + '</option>';
                        }
                        $('#id_subkriteria').html(html);
                    }
                });
            } else {
                $('#subkriteria-container').hide(); // Menyembunyikan jika kriteria kosong
                $('#id_subkriteria').html('<option value="">-- Pilih Subkriteria --</option>');
            }
        });
    });
</script>
<!-- <script>
    $(document).ready(function() {
        // Fungsi untuk memeriksa apakah semua alternatif sudah terisi
        function checkAllAlternativesFilled() {
            $.ajax({
                url: '<?= base_url('penilaian/check_filled'); ?>',
                method: 'GET',
                success: function(response) {
                    if (response === 'true') {
                        // Jika semua data sudah terisi, aktifkan tombol dan hapus pesan warning
                        $('#hitungButton').prop('disabled', false);
                        $('#warningMessage').remove(); // Hapus pesan warning jika ada
                    } else {
                        // Jika ada data yang belum terisi, nonaktifkan tombol dan tampilkan pesan warning
                        $('#hitungButton').prop('disabled', true);

                        // Tambahkan pesan warning di atas tombol jika belum ada
                        if ($('#warningMessage').length === 0) {
                            $('#hitungButton').before('<div id="warningMessage" class="alert alert-warning mt-2" role="alert">Semua alternatif harus diisi sebelum menghitung!</div>');
                        }
                    }
                },
                error: function() {
                    console.error('Error checking filled alternatives');
                }
            });
        }

        // Memeriksa setiap beberapa detik
        setInterval(checkAllAlternativesFilled, 5000); // Memeriksa setiap 5 detik

        // Memeriksa saat halaman dimuat
        checkAllAlternativesFilled();
    });
</script> -->
<!-- // Jika ingin menghitung langsung saat tombol ditekan -->
<script>
    document.getElementById('hitungButton').addEventListener('click', function(event) {
        event.preventDefault(); // Mencegah submit langsung

        Swal.fire({
            title: "Konfirmasi Perhitungan",
            text: "Apakah Anda yakin ingin melakukan perhitungan ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hitung!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading sementara proses berjalan
                Swal.fire({
                    title: "Sedang Menghitung...",
                    text: "Mohon tunggu sebentar.",
                    icon: "info",
                    timer: 1800000,
                    showConfirmButton: false
                });

                // Submit form ke fungsi `hitung()`
                document.getElementById('hitungForm').submit();
            }
        });
    });
</script>
<script>
        $(document).on('click', '.edit-btn', function () {
        var id_alternatif = $(this).data('id'); // Ambil id_alternatif dari tombol

        // Kirim permintaan AJAX ke server untuk mendapatkan data penilaian
        $.ajax({
            url: '<?php echo site_url("penilaian/get_penilaian_by_alternatif"); ?>/' + id_alternatif,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#id_alternatif').val(id_alternatif); // Simpan id_alternatif ke input hidden
                $('#dynamic-fields').html(''); // Bersihkan konten sebelumnya

                // Loop melalui data yang diterima
                response.forEach(function (item) {
                    var kriteriaLabel = `
                        <div class="form-group">
                            <label>${item.nama_kriteria}</label>
                            <select class="form-control subkriteria-dropdown" name="subkriteria[]" data-kriteria-id="${item.id_kriteria}">
                                <option value="">Pilih Subkriteria</option>
                            </select>
                        </div>
                    `;
                    $('#dynamic-fields').append(kriteriaLabel);

                    // Muat subkriteria berdasarkan id_kriteria
                    loadSubkriteria(item.id_kriteria, item.nama_subkriteria);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });

    // Fungsi untuk memuat subkriteria berdasarkan id_kriteria
    function loadSubkriteria(id_kriteria, selectedSubkriteria) 
    {
        $.ajax({
            url: '<?php echo site_url("penilaian/get_subkriteria_by_kriteria"); ?>/' + id_kriteria,
            type: 'GET',
            dataType: 'json',
            success: function (subkriteria) {
                var dropdown = $('.subkriteria-dropdown[data-kriteria-id="' + id_kriteria + '"]');
                dropdown.empty(); // Bersihkan dropdown
                dropdown.append('<option value="">Pilih Subkriteria</option>');

                // Tambahkan opsi subkriteria ke dropdown
                subkriteria.forEach(function (sub) {
                    var selected = (sub.nama_subkriteria === selectedSubkriteria) ? 'selected' : '';
                    dropdown.append(`<option value="${sub.id_subkriteria}" ${selected}>${sub.nama_subkriteria}</option>`);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error fetching subkriteria:', error);
            }
        });
    }
</script>
<script>
        $('#edit-form').on('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(); // Gunakan FormData untuk menangani data kompleks
        var id_alternatif = $('#id_alternatif').val();
        formData.append('id_alternatif', id_alternatif);

        $('.subkriteria-dropdown').each(function () {
            var id_kriteria = $(this).data('kriteria-id'); // Ambil id_kriteria dari atribut data
            var id_subkriteria = $(this).val(); // Ambil nilai subkriteria yang dipilih
            if (id_subkriteria) {
                formData.append('subkriteria[' + id_kriteria + ']', id_subkriteria); // Kirim sebagai array asosiatif
            }
        });

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                
                $('#edit-penilaian').modal('hide');
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error saving data:', error);
            }
        });
    });
</script>