<style>
  .help-block {
    color: red;
  }
</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <!-- <h1 class="m-0 text-dark">Permission</h1> -->
      </div><!-- /.col -->
      <div class="col-sm-6">
            <!-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Import ke Database</h3>
              </div>
              <div class="card-body">
                <?php echo $this->session->flashdata('notif') ?>
                <form method="POST" action="<?php echo base_url() ?>/importdata/upload" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
                <input type="file" name="userfile" class="form-control">
              </div>

              <button type="submit" class="btn btn-success">UPLOAD</button>
            </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>