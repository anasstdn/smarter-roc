
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">SPK SMARTER ROC</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">SPK SMARTER ROC</a></li>
          <li class="breadcrumb-item active">Hasil</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<?php
array_multisort(array_column($roc_utility, 'total'), SORT_ASC,array_column($roc_utility, 'nama_jalan'), SORT_ASC,$roc_utility);
?>

<section class="content">
 <div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Hasil SPK 10 Jalan Paling Rusak</h3>
        </div>
        <div class="card-body">
           <table 
          data-toggle="table"
          data-search="true"
          data-pagination="true"
          data-page-list="[5,10, 25, 50, 100, 200, All]"
          data-show-fullscreen="true"
          data-show-extended-pagination="true"
          class="table table-bordered table-striped table-vcenter table-sm" 
          id="table4"
          >
            <thead>
              <tr>
                <th>No</th>
                <th>No Ruas</th>
                <th>Nama Jalan</th>
                <th>Kecamatan</th>
                <th style="text-align: center">B</th>
                <th style="text-align: center">S</th>
                <th style="text-align: center">RR</th>
                <th style="text-align: center">RB</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($roc_utility) && !empty($roc_utility)){
                foreach($roc_utility as $key => $val)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".$val['no_ruas']."</td>";
                  echo "<td>".$val['nama_jalan']."</td>";
                  echo "<td>".$val['kec']."</td>";
                  echo "<td style='text-align:right'>".get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_BAIK')[0])." m</td>";
                  echo "<td style='text-align:right'>".get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_SEDANG')[0])." m</td>";
                  echo "<td style='text-align:right'>".get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_RUSAK_RINGAN')[0])." m</td>";
                  echo "<td style='text-align:right'>".get_detail_master_jalan($val['id_master_jalan'],getConfigValues('KRITERIA_RUSAK_BERAT')[0])." m</td>";
                  echo "</tr>";  

                  if($key == 9)
                  {
                    break;
                  }
                }
              }?>
            </tbody>
          </table>
        </div>
        <div class="card-footer text-right">
          <a href="<?= base_url('spk/detail_spk')?>" class="btn btn-primary">Lihat Detail SPK</a>
          <a href="<?= base_url('spk/export_to_excel')?>" class="btn btn-success" target="_blank">Export ke Excel</a>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
    <!-- /.content -->