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
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>
                    <?php if (validation_errors()) { ?>
                        <div class="alert alert-danger">
                            <a class="close" data-dismiss="alert">x</a>
                            <strong><?php echo strip_tags(validation_errors()); ?></strong>
                        </div>
                    <?php } ?>
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <?php if($level == 'Admin'):?>
                            <div class="card-header">
                                <a href="<?php echo site_url('kriteria/add'); ?>" class="btn btn-success btn-sm">Add</a> 
                            </div> <!-- /.card-body -->
                        <?php endif;?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" id="">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kriteria</th>
                                            <th>Bobot</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($kriteria as $k) : ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $k['nama_kriteria']; ?></td>
                                                <td><?php echo $k['bobot']; ?></td>
                                                <td>
                                                    <?php if ($k['type'] == 1): ?>
                                                        <span class="badge badge-primary">Benefit</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-info">Cost</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($level == 'Admin'):?>
                                                    <a href="<?php echo site_url('kriteria/edit/'.$k['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                                                    <!-- <a
                                                        onclick="return confirm('Are you sure You want to delete?')"
                                                        href="<?php echo site_url('kriteria/remove/'.$k['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a> -->
                                                    <?php else : ?>
                                                        <div class="alert alert-danger">Anda tidak memiliki akses untuk mengedit data</div>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

