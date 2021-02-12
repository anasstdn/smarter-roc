<style type="text/css">
  table {
    border-collapse:separate; 
    border-spacing: 0 1em;
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
                <h3 class="card-title">Verifikasi</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="<?php echo base_url('pengajuan/simpan_verifikasi'); ?>" method="post" id="form">
                <div class="card-body">
                  <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan?>">
                  <?php if(isset($longlat) && !empty($longlat)){?>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Titik Lokasi Kerusakan Jalan</label>
                      <div class="map-section">
                        <div style="width: 100%">
                          <iframe width="100%" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=<?=$longlat?>+(Morhuman)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>                           
                      </div>
                    </div>
                  <?php } ?>

                  <table border="0" width="100%">
                    <tr>
                      <td width="10%">Tanggal Pengajuan</td>
                      <td width="30%">
                        <input type="text" id="tgl_pengajuan" name="tgl_pengajuan" class="form-control" placeholder="Tanggal Pengajuan" value="<?=isset($pengajuan->tgl_pengajuan) && !empty($pengajuan->tgl_pengajuan)?date('d-m-Y H:i:s',strtotime($pengajuan->tgl_pengajuan)):''?>" readonly>
                      </td>
                      <td width="5%"></td>
                      <td width="10%">Nama Jalan</td>
                      <td width="30%">
                        <textarea class="form-control" row="5" id="nama_jalan" name="nama_jalan" readonly=""><?=isset($pengajuan->nama_jalan) && !empty($pengajuan->nama_jalan)?$pengajuan->nama_jalan:''?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%">Latitude</td>
                      <td width="30%">
                        <input type="text" id="latitude" name="latitude" class="form-control" placeholder="" value="<?=isset($pengajuan->latitude) && !empty($pengajuan->latitude)?$pengajuan->latitude:''?>" readonly>
                      </td>
                      <td width="5%"></td>
                      <td width="10%">Longitude</td>
                      <td width="30%">
                        <input type="text" id="longitude" name="longitude" class="form-control" placeholder="" value="<?=isset($pengajuan->longitude) && !empty($pengajuan->longitude)?$pengajuan->longitude:''?>" readonly>
                      </td>
                    </tr>
                    <tr>
                      <td width="10%">Keterangan</td>
                      <td width="30%">
                        <textarea class="form-control" row="5" id="keterangan" name="keterangan" readonly=""><?=isset($pengajuan->keterangan) && !empty($pengajuan->keterangan)?$pengajuan->keterangan:''?></textarea>
                      </td>
                      <td width="5%"></td>
                      <td width="10%">User Pengaju</td>
                      <td width="30%">
                        <input type="text" id="user_input" name="user_input" class="form-control" placeholder="" value="<?=isset($pengajuan->user_input) && !empty($pengajuan->user_input)?getUserById($pengajuan->user_input)->name:''?>" readonly>
                      </td>
                    </tr>
                  </table>
                  <br/>
                  <div class="form-group row">
                    <label for="exampleInputFile" class="col-3">Foto</label>
                    <div class="col-md-5">
                      <a href="<?php echo base_url();?>assets/pelaporan/<?= $pengajuan->foto; ?>" data-toggle="lightbox" data-title="Foto Pelaporan" data-gallery="gallery">
                        <img src="<?php echo base_url();?>assets/pelaporan/<?= $pengajuan->foto; ?>" class="img-fluid mb-2" width="50%" height="auto" alt="white sample"/>
                      </a>
                    </div>
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
              <a href="<?= base_url('pengajuan/verifikasi_pengajuan')?>" class="btn btn-outline-primary">Kembali</a>
              <button type="submit" name="action" value="diterima" class="btn btn-primary">Verifikasi Diterima</button>
              <button type="submit" name="action" value="ditolak" class="btn btn-danger">Verifikasi Ditolak</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
<script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>
<script>
 $(function () {
  $(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox({
      alwaysShowClose: true
    });
  });

  $('#form').submit('[name="action"]',function(e){
    if(!confirm('Apakah anda yakin akan melanjutkan ke proses berikutnya?'))
    {
      e.preventDefault();
    }
  })
});
</script>