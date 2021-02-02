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
                <h3 class="card-title">Buat Role</h3>
              </div>
              <form action="<?= base_url('role/store'); ?>" id="form" class="form-horizontal" method="POST">
                <div class="card-body">
                  <div class="form-body" style="margin-left: 2em">
                    <div class="form-group">
                      <label class="control-label col-md-3">Name</label>
                      <div class="col-md-12">
                        <input name="name" placeholder="Name" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Description</label>
                      <div class="col-md-12">
                        <input name="description" placeholder="Description" class="form-control" type="text">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-md-3">Permissions</label>
                      <div class="col-md-12">
                        <div class="form-group clearfix">
                          <?php if($permissions->num_rows() > 0){?>
                            <?php foreach($permissions->result_array() as $key => $val){?>
                              <div class="icheck-primary">
                                <input type="checkbox" name="permissions[]" id="checkboxPrimary_<?=$key?>" value="<?=$val['id']?>">
                                <label for="checkboxPrimary_<?=$key?>">
                                  <?= $val['name']?>
                                </label>
                              </div>
                            <?php } ?>
                          <?php } ?>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" id="simpan" class="btn btn-primary">Submit</button>
                  <a href="<?= base_url('/role'); ?>" class="btn btn-success">Kembali</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

<script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>
<script>
  $(function(){
    $('#form').submit('#simpan',function(e){
      var err = 0;
      var atLeastOneIsChecked = false;
      $('input').each(function(index,element){
        if($(this).attr('name') == 'name')
        {
          if($(this).val() == '')
          {
            err += 1;
            $(this).parent().parent().addClass('has-error');
            $(this).next().text('Silahkan isi form');
            toastr.warning('Silahkan lengkapi isian terlebih dahulu');
          }
          else
          {
            // e.preventDefault();
            $(this).parent().parent().removeClass('has-error');
            $(this).next().text('');
          }
        }
        // if($(this).attr('name') == 'description')
        // {
        // }

      })

      $('input:checkbox[name="permissions[]"]').each(function () {
        if ($(this).is(':checked')) {
          atLeastOneIsChecked = true;
          return false;
        }
      });
      if(atLeastOneIsChecked == false)
      {
        err += 1;
        toastr.warning('Silahkan centang minimal satu permission');
      }

      if(err > 0)
      {
        e.preventDefault();
      }

    });
  })
</script>