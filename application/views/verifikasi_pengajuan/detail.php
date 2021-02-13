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
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
     integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
     crossorigin=""/>
     <style>
      html {
        behavior: 'smooth';
      }
      #mapid {
        min-height: 480px;
        z-index: 10;
      }
      .map_wrapper {
        padding: 14px;
        border: 1px solid #e0e0e0;
        background: #fff;
        box-shadow: 0 3px 3px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
        border-radius: 5px;
      }

    </style>
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Detail Pengajuan</h3>
              <div class="text-right">
                <?php if($pengajuan->flag_verifikasi == 'Y'){
                  echo "<span class='badge badge-success' style='font-size:10pt'>DITERIMA</span>";
                }else{
                  echo "<span class='badge badge-danger' style='font-size:10pt'>DITOLAK</span>";
                }?>
              </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo base_url('pengajuan/simpan_verifikasi'); ?>" method="post" id="form">
              <div class="card-body">
                <input type="hidden" name="id_pengajuan" value="<?= $id_pengajuan?>">
                <input type="hidden" name="id_user_input" value="<?=isset($pengajuan->user_input) && !empty($pengajuan->user_input)?$pengajuan->user_input:''?>">

                <div class = "map_wrapper">
                  <div id="mapid"></div>
                </div>

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
              <!-- <button type="submit" name="action" value="diterima" class="btn btn-primary">Verifikasi Diterima</button>
                <button type="submit" name="action" value="ditolak" class="btn btn-danger">Verifikasi Ditolak</button> -->
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
  <script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>

  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
  integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
  crossorigin=""></script>

  <script>
    var map_lat = '-7.782962938864839';
    var map_lng = '110.36706447601318';
    var mymap = L.map('mapid').setView([map_lat, map_lng], 12);
    let group_marker;

    var lokasi = <?= $location; ?>

    $(function () {

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 16,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        layers: group_marker,
      }).addTo(mymap);

      all_coordinates = [];
      lokasi.forEach(item => {
        person = L.marker([item.latitude, item.longitude]).bindPopup(`
          Tanggal Pengajuan : ${item.tgl_pengajuan}
          <br>
          Jalan : ${item.nama_jalan}
          <br>
          Keterangan : ${item.keterangan}`);
        all_coordinates.push(person)
      })
      group_marker = L.layerGroup(all_coordinates).addTo(mymap);



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