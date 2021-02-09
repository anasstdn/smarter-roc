<div class="error"></div>
<p class="login-box-msg" style="font-size: 11pt"><b>Masukkan Kode OTP</b></p>

<form action="#" id="form" method="post">
	<div class="form-row mb-3">
		<input type="text" name="kode_otp" id="kode_otp" class="form-control form-control-sm" onkeypress="validate(event)" placeholder="Masukkan Kode OTP" required="">
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
			<button type="submit" id="submit" class="btn btn-primary btn-sm btn-block">Verifikasi</button>
		</div>
		<div class="col-2">
		</div>
		<!-- /.col -->
	</div>
	<br/>
	<div class="row">
		<p style="font-size: 10pt">Kembali ke <a href="<?php echo base_url('index.php/auth'); ?>">Login</a></p>
	</div>
</form>
<script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		$(function(){
			$('#form').submit('#submit',function(e){
				e.preventDefault();
				verifyOTP();
			})
		})
	})

	verifyOTP = () => {
		$(".error").html("").hide();
		$(".success").html("").hide();
		var otp = $("#kode_otp").val();
		var input = {
			"otp" : otp,
			"action" : "verify_otp"
		};
		if (otp.length == 6 && otp != null) {
			$.ajax({
				url : '<?php echo base_url('index.php/auth/sendOTP'); ?>',
				type : 'POST',
				dataType : "json",
				data : input,
				success : function(response) {
					$("." + response.type).html(response.message)
					$("." + response.type).show();
				},
				error : function() {
					alert("ss");
				}
			});
		} else {
			$(".error").html('You have entered wrong OTP.')
			$(".error").show();
		}
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
		if( !regex.test(key) ) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
</script>