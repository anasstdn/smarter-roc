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
            <h3 class="card-title">Pengaturan Pengguna</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="<?php echo base_url('settings/store'); ?>" method="post">
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Nama</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan Nama" value="<?=isset($data['name']) && !empty($data['name'])?$data['name']:''?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username" value="<?=isset($data['username']) && !empty($data['username'])?$data['username']:''?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email" value="<?=isset($data['email']) && !empty($data['email'])?$data['email']:''?>">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
               <div class="form-group">
                <label for="exampleInputEmail1">Telegram Chat ID</label>
                <input type="text" id="telegram_chat_id" name="telegram_chat_id" class="form-control" placeholder="Masukkan Telegram Chat ID" value="<?=isset($data['telegram_chat_id']) && !empty($data['telegram_chat_id'])?$data['telegram_chat_id']:''?>">
              </div>
              <!-- <div class="form-group">
                <label for="exampleInputFile">Foto Profil</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Silahkan Pilih File</label>
                  </div> -->
                  <!-- <div class="input-group-append">
                    <span class="input-group-text" id="">Upload</span>
                  </div> -->
                <!-- </div> -->
              <!-- </div> -->
              <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div> -->
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
<script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>