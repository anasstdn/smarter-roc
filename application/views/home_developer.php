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

    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard v2</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <?php if(in_array($this->session->userdata('role_id'),getConfigValues('ROLE_USER')))
          {?>
            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Pengajuan</span>
                <span class="info-box-number">
                  <?=dashboard_user()['total_pengajuan'];?>
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Belum Dikonfirmasi</span>
                <span class="info-box-number"><?=dashboard_user()['total_belum_verif'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Verifikasi Diterima</span>
                <span class="info-box-number"><?=dashboard_user()['total_verif_diterima'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Verifikasi Ditolak</span>
                <span class="info-box-number"><?=dashboard_user()['total_verif_ditolak'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <?php }else{?>

            <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Pengajuan</span>
                <span class="info-box-number">
                  <?=dashboard_admin()['total_pengajuan'];?>
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Belum Dikonfirmasi</span>
                <span class="info-box-number"><?=dashboard_admin()['total_belum_verif'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Verifikasi Diterima</span>
                <span class="info-box-number"><?=dashboard_admin()['total_verif_diterima'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Verifikasi Ditolak</span>
                <span class="info-box-number"><?=dashboard_admin()['total_verif_ditolak'];?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <?php }?>
          <!-- /.col -->
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Peta Kerusakan Jalan</h5>

                <div class="card-tools">

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <p class="text-center">
                      <strong>Peta Kerusakan Jalan Bulan <?= bulan(date('m'))?> <?= date('Y')?></strong>
                    </p>

                    <div class = "map_wrapper">
                      <div id="mapid"></div>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

      </div>
    </section>

    <script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
    integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
    crossorigin=""></script>

    <script type="text/javascript">
      var map_lat = '-7.782962938864839';
      var map_lng = '110.36706447601318';
      var mymap = L.map('mapid').setView([map_lat, map_lng], 16);
      let group_marker;

      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        layers: group_marker,
      }).addTo(mymap);

      function load_data_presensi_all(){
        $.ajax({
          url : "<?= base_url('home/loadMap');?>",
          type: "GET",
          dataType: "JSON",
          data: {
            "date_start": $("#date_start").val(),
            "date_end": $("#date_end").val(),
          },
          success: function(data){
        // resolve(data);
        all_coordinates = [];
        if(data){
          data.forEach(item => {
            person = L.marker([item.latitude, item.longitude]).bindPopup(`User : ${item.name}
              <br>
              Tanggal Pengajuan : ${item.tgl_pengajuan}
              <br>
              Jalan : ${item.nama_jalan}
              <br>
              Keterangan : ${item.keterangan}`);
            all_coordinates.push(person)
          })
          group_marker = L.layerGroup(all_coordinates).addTo(mymap);

        }

        $('html, body').animate({
          scrollTop: $("#mapid").offset().top - (150)
        }, 1000);

      },
      error: function (jqXHR, textStatus, errorThrown) {
        // reject(errorThrown);
      },
    })
      }

      load_data_presensi_all();
      $('#cari').on('click',function(){
        if(group_marker){
          mymap.removeLayer(group_marker)
        }
        load_data_presensi_all();

      });
    </script>