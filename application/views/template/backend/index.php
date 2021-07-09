<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Dinas PU</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/dist/css/adminlte.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/plugins/toastr/toastr.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-table.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/plugins/ekko-lightbox/ekko-lightbox.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
  <div class="wrapper">
    <!-- Navbar -->
    <?php echo $header; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php echo $sidebar; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php echo $content; ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.5
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>assets/template/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="<?php echo base_url(); ?>assets/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="<?php echo base_url(); ?>assets/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>assets/template/dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="<?php echo base_url(); ?>assets/template/dist/js/demo.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="<?php echo base_url(); ?>assets/template/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="<?php echo base_url(); ?>assets/template/plugins/raphael/raphael.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/template/plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/template/plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="<?php echo base_url(); ?>assets/template/plugins/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/template/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="<?php echo base_url(); ?>assets/template/plugins/toastr/toastr.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/bootstrap-table.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="<?php echo base_url(); ?>assets/template/dist/js/pages/dashboard2.js"></script>
  <script src="<?php echo base_url(); ?>assets/template/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/template/plugins/filterizr/jquery.filterizr.min.js"></script>

  <script>
    $(function() {
      $(".alert button.close").click(function(e) {
        $(this).parent().fadeOut('slow');
      });

      $(".alert").fadeTo(2000, 500).fadeOut(500, function() {
        $('.alert').fadeOut('slow');
      });

      var response_success = '<?= $this->session->flashdata('success') ?>';
      var response_error = '<?= $this->session->flashdata('error') ?>';

      if (response_success) {
        toastr.success(response_success);
      }

      if (response_error) {
        toastr.error(response_error);
      }

      $('body').on('keypress', function() {
        $('.help-block').html('');
      })

    })

    function show_modal(url) {
      $.ajax({
        url: url,
        dataType: 'text',
        success: function(data) {
          $('.modal').appendTo("body");
          $("#formModal").html(data);
          $("#formModal").modal('show');
        }
      });
    };
  </script>
</body>

</html>