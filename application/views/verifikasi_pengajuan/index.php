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
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Pengajuan Keluhan Belum Diverifikasi</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table 
                  data-toggle="table"
                  data-ajax="ajaxRequest"
                  data-search="true"
                  data-side-pagination="server"
                  data-pagination="true"
                  data-page-list="[5,10, 25, 50, 100, 200, All]"
                  data-show-fullscreen="true"
                  data-show-extended-pagination="true"
                  class="table table-bordered table-striped table-vcenter" 
                  id="table"
                  >
                  <thead>
                    <tr>
                      <th data-field="id"></th>
                      <th data-field="tgl_pengajuan">Tanggal Pengajuan</th>
                      <th data-field="nama_jalan">Nama Jalan</th>
                      <th data-field="latitude">Latitude</th>
                      <th data-field="longitude">Longitude</th>
                      <th data-field="user_input">Pengaju</th>
                      <th data-field="aksi">Aksi</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->

  <script>
    function ajaxRequest(params) {
      var formData = new FormData();
      formData.append('limit', params.data.limit);
      formData.append('offset', params.data.offset);
      formData.append('order', params.data.order);
      formData.append('search', params.data.search);
      formData.append('sort', params.data.sort);

      $.ajax({
        type: "POST",
        url: "<?php echo base_url('/pengajuan/getData'); ?>",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          params.success({
            "rows": data.data,
            "total": data.total
          })
        },
        error: function (er) {
          params.error(er);
        }
      });
    }
</script>