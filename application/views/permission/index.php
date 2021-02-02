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
                <h3 class="card-title">Permissions</h3>
              </div>
              <div class="card-body">
                <?php
                if(in_array('permissions-create', permissions($this->session->userdata())))
                {
                  ?>
                  <div class="row">
                    <div class="col-md-11">
                    </div>
                    <div class="col-md-1 text-right">
                      <a class="btn btn-block btn-primary btn-sm" href="#" onclick="create();">
                        Tambah
                      </a>
                    </div>
                  </div>
                <?php } ?>
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
                      <th data-field="name">Name</th>
                      <th data-field="description">Description</th>
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
        url: "<?php echo base_url('/permission/getData'); ?>",
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

    create = ()=>{
      save_method = 'create';
      $('#form')[0].reset();
      $("#formModal").modal('show');
      $('.help-block').empty();
      $('.modal-title').text('Tambah Data Baru');
    }

    edit = (id) => {
      save_method = 'update';
       $('#form')[0].reset(); // reset form on modals
       $('.form-group').removeClass('has-error'); // clear error class
       $('.help-block').empty(); // clear error string

       $.ajax({
        url : "<?php echo site_url('permission/edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);
            $('[name="description"]').val(data.description);
            // $('[name="lastName"]').val(data.lastName);
            // $('[name="gender"]').val(data.gender);
            // $('[name="address"]').val(data.address);
            // $('[name="dob"]').datepicker('update',data.dob);
            $('#formModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Data'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
    }

    save = () => {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      var url;

      if(save_method == 'create') {
        url = "<?php echo site_url('permission/store')?>";
      } else {
        url = "<?php echo site_url('permission/update')?>";
      }

       // ajax adding data to database
       $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            if(data.status) //if success close modal and reload ajax table
            {
              toastr.success('Data Berhasil Disimpan');
              $('#table').bootstrapTable('refresh', {silent: true});
              $('#formModal').modal('hide');           
            }
            else
            {
              for (var i = 0; i < data.inputerror.length; i++) 
              {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
                }
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error adding / update data');
            $('#btnSave').text('Simpan'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

          }
        });
     }

     delete_data = (id)=>{
      if(confirm('Apakah anda yakin akan menghapus data ini?'))
       {
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('permission/delete')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
                //if success reload ajax table
                toastr.success('Data Berhasil Dihapus');
                $('#table').bootstrapTable('refresh', {silent: true});
                $('#formModal').modal('hide');
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                // alert('Error deleting data');
                toastr.error('Data Gagal Dihapus');
              }
            });

      }
    }

  </script>

  <div class="modal fade" id="formModal" aria-hidden="true" aria-labelledby="formModalLabel" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Large Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" id="form" class="form-horizontal">
            <input type="hidden" value="" name="id"/> 
            <div class="form-body" style="margin-left: 2em">
              <div class="form-group">
                <label class="control-label col-md-3">Name</label>
                <div class="col-md-9">
                  <input name="name" placeholder="Name" class="form-control" type="text">
                  <span class="help-block"></span>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-3">Description</label>
                <div class="col-md-9">
                  <input name="description" placeholder="Description" class="form-control" type="text">
                  <span class="help-block"></span>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
          <button type="button" id="btnSave" class="btn btn-primary" onclick="save();">Simpan</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>