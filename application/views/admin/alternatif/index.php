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
                    <?= $this->session->flashdata('alert_msg'); ?>
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
                                <a href="<?php echo site_url('alternatif/add'); ?>" class="btn btn-success btn-sm">Add</a>
                                <div class="float-right">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#import"><i class="fa fa-upload"></i> Import</button>
                                </div>
                            </div>
                        <?php endif;?> 
                        <!-- /.card-body -->
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" id="">
									<thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Registrasi</th>
                                            <th>Nama Sekaa Teruna</th>
                                            <th>Nama Banjar</th>
                                            <!-- <th>Agama</th> -->
                                            <th>Desa</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 1; 
                                            foreach ($alternatif as $a) : ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $a['nis']; ?></td>
                                                    <td><?php echo $a['nama_siswa']; ?></td>
                                                    <td><?php echo $a['jenis_kelamin']?></td>
                                                    <!-- <td><?php echo $a['agama']?></td> -->
                                                    <td><?php echo $a['alamat']; ?></td>
                                                    <td>
                                                        <?php if($level == 'Admin'):?>
                                                        <a href="<?php echo site_url('alternatif/edit/'.$a['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                                                        <!-- <a onclick="return confirm('Are you sure You want to delete?')" href="<?php echo site_url('alternatif/remove/'.$a['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a> -->
                                                        <?php else : ?>
                                                            <div class="alert alert-danger">Anda tidak memiliki akses untuk mengedit data</div>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
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

<div class="modal inmodal" id="import" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content animated flipInY">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Import Data Alternatif</h4>
                <small class="font-bold">Silahkan menggunakan template yang sudah ditentukan.</small>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo site_url('alternatif/import'); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file">File</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <a href="<?= base_url('assets/upload_template/template_alternatif.csv')?>" class="btn btn-info"><i class="fa fa-download"></i> Download Template</a>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

