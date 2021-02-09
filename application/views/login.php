<?php
// Cek apakah terdapat session nama message
if($this->session->flashdata('message')){ // Jika ada
  echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" aria-hidden="true">&times;</button>'.$this->session->flashdata('message').'</div>'; // Tampilkan pesannya
}
?>
<p class="login-box-msg" style="font-size: 10pt">Sistem Aplikasi Pengaduan Kerusakan Jalan</p>

<form action="<?php echo base_url('index.php/auth/login'); ?>" method="post">
	<div class="input-group mb-3">
		<input type="username" name="username" class="form-control" placeholder="Username">
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-user"></span>
			</div>
		</div>
	</div>
	<div class="input-group mb-3">
		<input type="password" class="form-control" placeholder="Password" name="password"> 
		<div class="input-group-append">
			<div class="input-group-text">
				<span class="fas fa-lock"></span>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-2">
			<!-- <div class="icheck-primary">
				<input type="checkbox" id="remember">
				<label for="remember">
					Remember Me
				</label>
			</div> -->
		</div>
		<!-- /.col -->
		<div class="col-8">
			<button type="submit" class="btn btn-primary btn-sm btn-block">Masuk</button>
		</div>
		<div class="col-2">
		</div>
		<!-- /.col -->
	</div>
	<br/>
	<div class="row">
		<p style="font-size: 10pt">Belum punya akun? <a href="<?php echo base_url('index.php/auth/daftar'); ?>">Daftar Sekarang</a></p>
	</div>
</form>