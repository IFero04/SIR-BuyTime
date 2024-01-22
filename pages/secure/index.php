<?php
	require_once __DIR__ . '../../../infra/middlewares/middleware-user.php';
	@require_once __DIR__ . '/../../helpers/session.php';
	
	$user = user();

	include_once __DIR__ . '../../../templates/header.php';
?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
	<div class="wrapper">
		<?php include '../../templates/topbar.php' ?>
		<?php include '../../templates/sidebar.php' ?>

		<div class="content-wrapper">
			<div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="toast-body text-white">

				</div>
			</div>

			<div class="toasts-top-right fixed" id="toastsContainerTopRight"></div>

			<!-- <div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0"><?php //echo $title ?></h1>
						</div>
					</div>
					<hr class="border-grey">
				</div>
			</div> -->

				<!-- Main Content -->
				<section class="content">
					<div class="container-fluid">
						<?php
							$page = isset($_GET['page']) ? $_GET['page'] : 'home';

							if (!file_exists('./user/' . $page . '.php')) {
								include '404.html';
							} else {
								include './user/' . $page . '.php';
							}
						?>
					</div>
				</section>

				<!-- content -->
				<div class="modal fade" id="confirm_modal" role="dialog">
					<div class="modal-dialog modal-md" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Confirmation</h5>
							</div>
							<div class="modal-body">
								<div id="delete_content"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-color" id="confirm" onclick="">Continue</button>
								<button type="button" class="btn btn-action" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="uni_modal" role="dialog">
					<div class="modal-dialog modal-md" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"></h5>
							</div>
							<div class="modal-body"></div>
							<div class="modal-footer">
								<button type="button" class="btn btn-color" id="submit" onclick="$('#uni_modal form').submit()"><strong>Save</strong></button>
								<button type="button" class="btn btn-color" data-dismiss="modal"><strong>Cancel</strong></button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="uni_modal_right" role="dialog">
					<div class="modal-dialog modal-full-height modal-md" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"></h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span class="fa fa-arrow-right"></span>
								</button>
							</div>
							<div class="modal-body">
							</div>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="viewer_modal" role="dialog">
					<div class="modal-content">
						<button type="button" class="btn-close" data-dismiss="modal">
							<span class="fa fa-times"></span>
						</button>
						<img src="" alt="">
					</div>
				</div>
			</div>
		</div>

		<aside class="control-sidebar control-sidebar-dark">

		</aside>

		<?php
			include_once __DIR__ . '../../../templates/footer.php';
		?>
	</div>
</body>