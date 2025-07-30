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
              <div class="col-md-12">
                <?php echo form_open('kriteria/edit/'.$kriteria['id']); ?>
                <div class="box-body">
                  <div class="row clearfix">
                    <div class="col-md-6">
                      <label for="nama_kriteria" class="control-label">
                        <span class="text-danger">*</span>Nama kriteria
                      </label>
                      <div class="form-group">
                        <input type="text" name="nama_kriteria" value="<?php echo ($this->input->post('nama_kriteria') ? $this->input->post('nama_kriteria') : $kriteria['nama_kriteria']); ?>" class="form-control" id="nama_kriteria" />
                        <span class="text-danger"><?php echo form_error('nama_kriteria');?></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="bobot" class="control-label">
                        <span class="text-danger">*</span>Bobot
                      </label>
                      <div class="form-group">
                        <input type="number" name="bobot" value="<?php echo ($this->input->post('bobot') ? $this->input->post('bobot') : $kriteria['bobot']); ?>" class="form-control" id="bobot" />
                        <span class="text-danger"><?php echo form_error('bobot');?></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="type" class="control-label">
                      <span class="text-danger">*</span>Type
                      </label>
                      <div class="form-group">
                      <select name="type" class="form-control" id="type">
                        <option value="1" <?php echo ($this->input->post('type') == 1 || $kriteria['type'] == 1) ? 'selected="selected"' : ''; ?>>Benefit</option>
                        <option value="2" <?php echo ($this->input->post('type') == 2 || $kriteria['type'] == 2) ? 'selected="selected"' : ''; ?>>Cost</option>
                      </select>
                      <span class="text-danger"><?php echo form_error('type');?></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="alert alert-info">
                          <p>
                            <strong>Benefit:</strong> Kriteria yang semakin tinggi nilainya, semakin baik. Contohnya seperti nilai ujian, semakin tinggi semakin baik.
                          </p>
                          <p>
                            <strong>Cost:</strong> Kriteria yang semakin rendah nilainya, semakin baik. Contohnya seperti biaya, semakin rendah semakin baik.  
                          </p>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <button type="submit" class="btn btn-success">
                    <i class="fa fa-check"></i> Save
                  </button>
                  <a href="<?php echo site_url('kriteria'); ?>" class="btn btn-warning">
                    <i class="fa fa-times"></i> Cancel
                  </a>
                </div>
                <?php echo form_close(); ?>
              </div>
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
        $('#type').select2({
            placeholder: "-- Pilih Type Kriteria --",
            allowClear: true
        });

         $('#agama').select2({
            placeholder: "-- Pilih Agama --",
            allowClear: true
        });
    });
</script>