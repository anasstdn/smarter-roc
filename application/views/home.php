
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
          <h3 class="card-title">Kriteria</h3>
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
          id="table"
          >
            <thead>
              <tr>
                <th>No</th>
                <th>Kriteria</th>
                <th>Peringkat</th>
                <th>Bobot</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($kriteria) && !empty($kriteria)){
                foreach($kriteria as $key => $val)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".$val['kriteria']."</td>";
                  echo "<td>".$val['rangking']."</td>";
                  echo "<td>".$val['bobot']."</td>";
                  echo "</tr>";  
                }
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<section class="content">
 <div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Sub Kriteria</h3>
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
          id="table1"
          >
            <thead>
              <tr>
                <th>No</th>
                <th>Kriteria</th>
                <th>Sub Kriteria</th>
                <th>Peringkat</th>
                <th>Bobot</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($subkriteria) && !empty($subkriteria)){
                foreach($subkriteria as $key => $val)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".$val['kriteria']."</td>";
                  echo "<td>";
                  foreach($val['sub_kriteria'] as $key1 => $sub)
                  {
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>".$sub."</td>";
                    echo "</tr>"; 
                    echo "</table>";
                  }
                  echo "</td>";
                  echo "<td>";
                  foreach($val['rangking'] as $key1 => $sub)
                  {
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>".$sub."</td>";
                    echo "</tr>"; 
                    echo "</table>";
                  }
                  echo "</td>";
                  echo "<td>";
                  foreach($val['bobot'] as $key1 => $sub)
                  {
                    echo "<table>";
                    echo "<tr>";
                    echo "<td>".$sub."</td>";
                    echo "</tr>"; 
                    echo "</table>";
                  }
                  echo "</td>";
                  echo "</tr>";  
                }
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="content">
 <div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Rekapitulasi Tingkat Kerusakan Jalan</h3>
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
         id="table2"
         >
            <thead>
              <tr>
                <th>No</th>
                <th>No Ruas</th>
                <th>Nama Jalan</th>
                <th>Kecamatan</th>
                <th>Baik (%)</th>
                <th>Sedang (%)</th>
                <th>Rusak Ringan (%)</th>
                <th>Rusak Berat (%)</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($tabel_rekap) && !empty($tabel_rekap)){
                foreach($tabel_rekap as $key => $val)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".$val['no_ruas']."</td>";
                  echo "<td>".$val['nama_jalan']."</td>";
                  echo "<td>".$val['kec']."</td>";
                  echo "<td>".$val['Baik']."</td>";
                  echo "<td>".$val['Sedang']."</td>";
                  echo "<td>".$val['Rusak Ringan']."</td>";
                  echo "<td>".$val['Rusak Berat']."</td>";
                  echo "</tr>";  
                }
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="content">
 <div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Data Nilai ROC Pada Sub Kriteria </h3>
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
          id="table3"
          >
            <thead>
              <tr>
                <th>No</th>
                <th>No Ruas</th>
                <th>Nama Jalan</th>
                <th>Kecamatan</th>
                <th>Baik</th>
                <th>Sedang</th>
                <th>Rusak Ringan</th>
                <th>Rusak Berat</th>
              </tr>
            </thead>
            <tbody>
              <?php if(isset($roc_sub) && !empty($roc_sub)){
                foreach($roc_sub as $key => $val)
                {
                  echo "<tr>";
                  echo "<td>".($key+1)."</td>";
                  echo "<td>".$val['no_ruas']."</td>";
                  echo "<td>".$val['nama_jalan']."</td>";
                  echo "<td>".$val['kec']."</td>";
                  echo "<td>".$val['Baik']."</td>";
                  echo "<td>".$val['Sedang']."</td>";
                  echo "<td>".$val['Rusak Ringan']."</td>";
                  echo "<td>".$val['Rusak Berat']."</td>";
                  echo "</tr>";  
                }
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<section class="content">
 <div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Data Nilai Utility </h3>
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
                <th>Baik</th>
                <th>Sedang</th>
                <th>Rusak Ringan</th>
                <th>Rusak Berat</th>
                <th>Total</th>
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
                  echo "<td>".$val['Baik']."</td>";
                  echo "<td>".$val['Sedang']."</td>";
                  echo "<td>".$val['Rusak Ringan']."</td>";
                  echo "<td>".$val['Rusak Berat']."</td>";
                  echo "<td>".$val['total']."</td>";
                  echo "</tr>";  
                }
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

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
          <h3 class="card-title">Hasil SPK </h3>
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
                <th>Baik</th>
                <th>Sedang</th>
                <th>Rusak Ringan</th>
                <th>Rusak Berat</th>
                <th>Total</th>
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
                  echo "<td>".$val['Baik']."</td>";
                  echo "<td>".$val['Sedang']."</td>";
                  echo "<td>".$val['Rusak Ringan']."</td>";
                  echo "<td>".$val['Rusak Berat']."</td>";
                  echo "<td>".$val['total']."</td>";
                  echo "</tr>";  
                }
              }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
    <!-- /.content -->