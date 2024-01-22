<?php
	require_once __DIR__ . '../../infra/middlewares/middleware-user.php';
	@require_once __DIR__ . '/../helpers/session.php';

	if (isset($_GET['id'])) {
		$user = user();
	}
?>
<div class="container-fluid">
	<div id="msg"></div>

	<form action="" id="manage-user">
		<div class="d-flex justify-content-left align-items-center">
			<div class="row align-items-center">
				<input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : '' ?>">

				<div class="col-lg-6 mb-3">
					<label for="firstname">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $user['name'] ?>" required>
				</div>

				<div class="col-lg-6 mb-3">
					<label for="lastname">Last Name</label>
					<?php if (isset($user['lastname'])): ?>
						<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($user['lastname']) ? $user['lastname'] : 'Not Provided' ?>" required>
					<?php else: ?>
						<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" required>
					<?php endif; ?>
				</div>

				<div class="col-lg-12 mb-3">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="form-control" value="<?php echo isset($user['email']) ? $user['email'] : '' ?>" required disabled autocomplete="off">
				</div>

				<div class="col-lg-12 mb-3">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
					<small class="form-text text-muted">Leave this blank if you don't want to change the password.</small>
				</div>

				<div class="col-lg-12 mb-3">
					<label for="customFile" class="control-label">Avatar</label>
					<div class="custom-file">
						<input type="file" name="img" id="customFile" class="custom-file-input rounded-circle" onchange="displayImg(this, $(this))">
						<label for="customFile" id="customFileLabel" class="custom-file-label">Choose File</label>
					</div>
				</div>

				<div class="col-lg-12 mb-3 d-flex justify-content-center">
					<img src="<?php echo isset($user['foto']) ? '/BuyTime/assets/uploads/' . $user['foto'] : '' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</div>
		</div>
	</form>
</div>


<style>
	img#cimg {
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>

<script>
	function displayImg(input, _this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
			$('#customFileLabel')[0].innerHTML = input.files[0].name;
	    }
	}

	$('#manage-user').submit(function(e) {
		e.preventDefault();
		start_load();
		$.ajax({
			url: '/BuyTime/helpers/ajax.php?action=update_user',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: response => {
				if (response == 1) {
					alert_toast('Data successfully saved', 'success');
					setTimeout(function() {
						location.reload();
					}, 1500);
				} else if (response == 2) {
					$('#msg').html('<div class="alert alert-danger">Password must have a minimum of 6 characters</div>');
					end_load();
				} else {
					$('#msg').html(response);
					end_load();
				}
			}
		});
	});
</script>