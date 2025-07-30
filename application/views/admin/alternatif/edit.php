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
        <div class="col-md-12">
          <?php echo $this->session->flashdata('alert_msg'); ?>
          <div class="ibox">
            <div class="ibox-title">
              <h5>Data Alternatif</h5>
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
              <?php echo form_open('alternatif/edit/'.$alternatif['id']); ?>
              <div class="row">
                <div class="col-md-6">
                  <label for="nis" class="control-label"><span class="text-danger">*</span>No Registrasi</label>
                  <div class="form-group">
                    <input type="number" name="nis" value="<?php echo ($this->input->post('nis') ? $this->input->post('nis') : $alternatif['nis']); ?>" class="form-control" id="nis" readonly/>
                    <span class="text-danger"><?php echo form_error('nis'); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="nama_siswa" class="control-label"><span class="text-danger">*</span>Nama Sekaa Teruna</label>
                  <div class="form-group">
                    <input type="text" name="nama_siswa" value="<?php echo ($this->input->post('nama_siswa') ? $this->input->post('nama_siswa') : $alternatif['nama_siswa']); ?>" class="form-control" id="nama_siswa" />
                    <span class="text-danger"><?php echo form_error('nama_siswa'); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="jenis_kelamin" class="control-label"><span class="text-danger">*</span>Banjar</label>
                  <div class="form-group">
                  <input type="text" name="jenis_kelamin" value="<?= $alternatif['jenis_kelamin']?>" class="form-control" id="banjar" />
                    
                    <span class="text-danger"><?php echo form_error('jenis_kelamin'); ?></span>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <label for="alamat" class="control-label"><span class="text-danger">*</span>Desa</label>
                  <div class="form-group">
                    <textarea name="alamat" class="form-control" id="alamat"><?php echo ($this->input->post('alamat') ? $this->input->post('alamat') : $alternatif['alamat']); ?></textarea>
                    <span class="text-danger"><?php echo form_error('alamat'); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for=" " class="control-label"></label>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">
                      <i class="fa fa-check"></i> Save
                    </button>
                    <a href="<?php echo site_url('alternatif'); ?>" class="btn btn-warning">
                      <i class="fa fa-times"></i> Cancel
                    </a>
                  </div>
                </div>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script src="<?php echo base_url('assets/'); ?>template/js/jquery-3.1.1.min.js"></script>
<script>
  $(document).ready(function() {
    $('#jenis_kelamin').select2({
      placeholder: "-- Pilih Jenis Kelamin --",
      allowClear: true
    });

    $('#agama').select2({
      placeholder: "-- Pilih Agama --",
      allowClear: true
    });
  });
</script>
