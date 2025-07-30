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
                            <h5>Data Subkriteria</h5>
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
                                <?php echo form_open('subkriteria/edit/'.$subkriteria['id']); ?>
                                    <div class="box-body">
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <label for="id_kriteria" class="control-label"><span class="text-danger">*</span> Kriteria</label>
                                                <div class="form-group">
                                                    <select name="id_kriteria" class="form-control" id="id_kriteria">
                                                        <option value="">select id_kriteria</option>
                                                        <?php foreach ($all_kriteria as $kriteria) {
                                                            $selected = ($kriteria['id'] == $subkriteria['id_kriteria']) ? ' selected="selected"' : "";
                                                            echo '<option value="' . $kriteria['id'] . '"' . $selected . '>' . $kriteria['nama_kriteria'] . '</option>';
                                                        } ?>
                                                    </select>
                                                    <span class="text-danger"><?php echo form_error('id_kriteria'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nama_subkriteria" class="control-label"><span class="text-danger">*</span>Nama Subkriteria</label>
                                                <div class="form-group">
                                                    <input type="text" name="nama_subkriteria" value="<?php echo ($this->input->post('nama_subkriteria') ? $this->input->post('nama_subkriteria') : $subkriteria['nama_subkriteria']); ?>" class="form-control" id="nama_subkriteria" />
                                                    <span class="text-danger"><?php echo form_error('nama_subkriteria'); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="nilai" class="control-label"><span class="text-danger">*</span>Nilai</label>
                                                <div class="form-group">
                                                    <input type="number" name="nilai" value="<?php echo ($this->input->post('nilai') ? $this->input->post('nilai') : $subkriteria['nilai']); ?>" class="form-control" id="nilai" />
                                                    <span class="text-danger"><?php echo form_error('nilai'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-check"></i> Save
                                        </button>
                                        <a href="<?php echo site_url('subkriteria'); ?>" class="btn btn-warning">
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
        $('#id_kriteria').select2({
            placeholder: "-- Pilih Kriteria --",
            allowClear: true
        });

         $('#agama').select2({
            placeholder: "-- Pilih Agama --",
            allowClear: true
        });
    });
</script>