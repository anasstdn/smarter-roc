<?php
// Cek apakah terdapat session nama message
if ($this->session->flashdata('message')) { // Jika ada
	echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" aria-hidden="true">&times;</button>' . $this->session->flashdata('message') . '</div>'; // Tampilkan pesannya
}
?>
<div class="container">
	<div class="error"></div>
	<p class="login-box-msg" style="font-size: 11pt"><b>Registrasi Pengguna Baru</b></p>
	<label style="font-size: 8pt;color:red">* Wajib install aplikasi Telegram dan Generate Chat ID Telegram</label>
	<form action="#" id="form" method="post">
		<div class="input-group mb-3">
			<input type="name" name="name" id="name" class="form-control form-control-sm" placeholder="Masukkan Nama Lengkap" required="">
			<div class="input-group-append">
				<div class="input-group-text">
					<span class="fas fa-user"></span>
				</div>
			</div>
		</div>
		<div class="input-group mb-3">
			<input type="username" name="username" id="username" class="form-control form-control-sm" placeholder="Masukkan Username" required="">
			<div class="input-group-append">
				<div class="input-group-text">
					<span class="fas fa-user"></span>
				</div>
			</div>
		</div>
		<div class="input-group mb-3">
			<input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Masukkan Email" required="">
			<div class="input-group-append">
				<div class="input-group-text">
					<span class="fas fa-envelope"></span>
				</div>
			</div>
		</div>
		<div class="input-group mb-3">
			<input type="text" name="telegram_chat_id" id="telegram_chat_id" class="form-control form-control-sm" onkeypress="validate(event)" placeholder="Chat ID Telegram (cth : 800322918 dsb)" required="">
			<div class="input-group-append">
				<div class="input-group-text">
					<span class="fas fa-phone"></span>
				</div>
			</div>
		</div>
		<div class="input-group mb-3">
			<input type="password" class="form-control form-control-sm" id="password" placeholder="Password" name="password" minlength="8" required>
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
				<button type="submit" id="submit" class="btn btn-primary btn-sm btn-block">Daftar Sekarang</button>
			</div>
			<div class="col-2">
			</div>
			<!-- /.col -->
		</div>
		<br />
		<div class="row">
			<p style="font-size: 10pt">Kembali ke <a href="<?php echo base_url('index.php/auth'); ?>">Login</a></p>
		</div>
	</form>
</div>
<script src="<?php echo base_url(); ?>assets/template/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		$('#form').submit('#submit', function(e) {
			e.preventDefault();
			sendOTP();
		})
	})

	sendOTP = () => {
		$(".error").html("").hide();
		// var number = $("#mobile").val();
		// if (number.length == 10 && number != null) {
		var input = {
			"name": $('#name').val(),
			"username": $('#username').val(),
			"email": $('#email').val(),
			"telegram_chat_id": $('#telegram_chat_id').val(),
			"password": $('#password').val(),
			"action": "send_otp"
		};
		$.ajax({
			url: '<?php echo base_url('index.php/auth/sendOTP'); ?>',
			type: 'POST',
			data: input,
			success: function(response) {
				$(".container").html(response);
			}
		});
		// } else {
		// $(".error").html('Please enter a valid number!')
		// $(".error").show();
		// }
	}

	function validate(evt) {
		var theEvent = evt || window.event;

		if (theEvent.type === 'paste') {
			key = event.clipboardData.getData('text/plain');
		} else {

			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode(key);
		}
		var regex = /[0-9]|\./;
		if (!regex.test(key)) {
			theEvent.returnValue = false;
			if (theEvent.preventDefault) theEvent.preventDefault();
		}
	}
</script>