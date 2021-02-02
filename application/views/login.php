<?php
// Cek apakah terdapat session nama message
if($this->session->flashdata('message')){ // Jika ada
  echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" aria-hidden="true">&times;</button>'.$this->session->flashdata('message').'</div>'; // Tampilkan pesannya
}
?>

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
		<div class="col-8">
			<!-- <div class="icheck-primary">
				<input type="checkbox" id="remember">
				<label for="remember">
					Remember Me
				</label>
			</div> -->
		</div>
		<!-- /.col -->
		<div class="col-4">
			<button type="submit" class="btn btn-primary btn-block">Sign In</button>
		</div>
		<!-- /.col -->
	</div>
</form>