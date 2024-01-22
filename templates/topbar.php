<?php
	require_once __DIR__ . '../../infra/middlewares/middleware-user.php';
	@require_once __DIR__ . '/../helpers/session.php';

	$user = user();
?>
<link rel="stylesheet" href="<?php BASE_URL?>/BuyTime/assets/css/pages/dashboard.css">
<nav class="main-header navbar navbar-expand navbar-color navbar-dark">
	<ul class="navbar-nav">
		<?php if ($user): ?>
		<li class="nav-item">
			<a href="" class="nav-link" data-widget="pushmenu" role="button">
				<i class="fas fa-bars fa-lg" style="color: #000; margin-top: 8px;"></i>
			</a>
		</li>
		<?php endif; ?>
		<li>
			<a href="./" class="nav-link nav-color" role="button">
				<img src="/BuyTime/assets/images/LogoF.png" alt="BuyTime Logo">
			</a>
		</li>
	</ul>

	<ul class="navbar-nav ml-auto">
		<li class="nav-item ml-auto">
			<a href="#" class="nav-link" data-widget="fullscreen" role="button">
				<i class="fas fa-expand-arrows-alt fa-lg" style="color: #000; margin-top: 8px;"></i>
			</a>
		</li>
		<li class="nav-item dropdown">
			<a href="" class="nav-link" data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
				<span>
					<div class="d-flex badge-pill">
						<span class="fa fa-user fa-lg mr-2" style="color: #000; margin-top: 8px;"></span>
						<span class="i-name">
							<b>
								<?php echo $user['name']; ?>
							</b>
						</span>
						<span class="fa fa-angle-down fa-lg ml-2" style="color: #000; margin-top: 10px;"></span>
					</div>
				</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
				<a href="javascript:void(0)" class="dropdown-item" id="manage_account">
					<i class="fa fa-cog" style="color: #5b63d1;"></i>
					<strong>Manage Account</strong>
				</a>
				<form action="/BuyTime/controllers/auth/login.php" method="post">
                    <button class="dropdown-item" type="submit" name="user" value="logout">
						<i class="fa fa-power-off" style="color: #5b63d1;"></i>
						<strong>Logout</strong>
					</button>
                </form>
			</div>
		</li>
	</ul>
</nav>

<script>
	$('#manage_account').click(function() {
		uni_modal('Manage Account', '/BuyTime/templates/manage_user.php?id=<?php echo $user['id'] ?>');
	});
</script>