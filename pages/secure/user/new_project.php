<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/session.php';

$user = user();

include_once __DIR__ . '../../../../templates/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-dark text-center" style="margin-top: 20px;"><strong>&nbsp;</strong></h4>
		</div>
	</div>
</div>

<div class="cointainer">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<div id="msg"></div>

					<form action="" id="manage-project">
						<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Title</label>
									<input type="text" name="title" class="form-control form-control-sm" value="<?php echo isset($title) ? $title : '' ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Status</label>
									<select name="status" id="status" class="custom-select custom-select-sm">
										<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Pending</option>
										<option value="3" <?php echo isset($status) && $status == 3 ? 'selected' : '' ?>>On-Hold</option>
										<option value="5" <?php echo isset($status) && $status == 5 ? 'selected' : '' ?>>Done</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Category</label>
									<select name="category" id="category" class="custom-select custom-select-sm">
										<option value="0" <?php echo isset($category) && $category == 0 ? 'selected' : '' ?>>Undetermined</option>
										<option value="1" <?php echo isset($category) && $category == 1 ? 'selected' : '' ?>>Professional</option>
										<option value="2" <?php echo isset($category) && $category == 2 ? 'selected' : '' ?>>Academic</option>
										<option value="3" <?php echo isset($category) && $category == 3 ? 'selected' : '' ?>>Personal</option>
										<option value="4" <?php echo isset($category) && $category == 4 ? 'selected' : '' ?>>Health</option>
										<option value="5" <?php echo isset($category) && $category == 5 ? 'selected' : '' ?>>Technology</option>
										<option value="6" <?php echo isset($category) && $category == 6 ? 'selected' : '' ?>>Art</option>
										<option value="7" <?php echo isset($category) && $category == 7 ? 'selected' : '' ?>>Community</option>
										<option value="8" <?php echo isset($category) && $category == 8 ? 'selected' : '' ?>>Business</option>
										<option value="9" <?php echo isset($category) && $category == 9 ? 'selected' : '' ?>>General</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Priority</label>
									<select name="priority" id="priority" class="custom-select custom-select-sm">
										<option value="0" <?php echo isset($priority) && $priority == 0 ? 'selected' : '' ?>>Undetermined</option>
										<option value="1" <?php echo isset($priority) && $priority == 1 ? 'selected' : '' ?>>Not Important</option>
										<option value="2" <?php echo isset($priority) && $priority == 2 ? 'selected' : '' ?>>Normal</option>
										<option value="3" <?php echo isset($priority) && $priority == 3 ? 'selected' : '' ?>>Important</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">Start Date</label>
									<input type="date" name="start_date" class="form-control form-control-sm" autocomplete="off" value="<?php echo isset($start_date) ? date('Y-m-d', strtotime($start_date)) : '' ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="" class="control-label">End Date</label>
									<input type="date" name="end_date" class="form-control form-control-sm" autocomplete="off" value="<?php echo isset($end_date) ? date('Y-m-d', strtotime($end_date)) : '' ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<?php if (administrator()): ?>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="control-label">Project Manager</label>
										<select name="manager_id" class="form-control form-control-sm select2">
											<option></option>
											<?php
											$normalUsers = getNoAdmins();
											foreach ($normalUsers as $normalUser):
											?>
											<option value="<?php echo $normalUser['id']; ?>" <?php echo isset($manager_id) && $manager_id == $normalUser['id'] ? "selected" : ''?>><?php echo ucwords($normalUser['name'] . ' ' . $normalUser['lastname']); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php else: ?>
								<input type="hidden" name="manager_id" value="<?php echo $user['id'] ?>">
							<?php endif; ?>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="control-label">Project Team Members</label>
										<select name="user_ids[]" class="form-control form-control-sm select2" multiple="multiple">
											<option></option>
											<?php
											$users = getUsersExcludingId($user['id']);

											foreach ($users as $member):
												if (!isUserAdmin($member)):
											?>
											<option value="<?php echo $member['id'] ?>" <?php echo isset($user_ids) && in_array($member['id'], explode(',', $user_ids)) ? "selected" : '' ?>><?php echo ucwords($member['name'] . ' ' . $member['lastname']); ?></option>
											<?php
											endif;
											endforeach;
											?>
										</select>
									</div>
								</div>
						</div>
						<div class="row">
							<div class="col-md-10">
								<div class="form-group">
									<label for="" class="control-label">Description</label>
									<textarea name="description" id="" cols="30" rows="10" class="summernote form-control">
										<?php echo isset($description) ? $description : ''; ?>
									</textarea>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="card-footer border-top border-grey">
					<div class="d-flex w-100 justify-content-center align-items-center">
						<button class="btn btn-rounder btn-color mx-2" form="manage-project">Save</button>
						<button class="btn btn-rounder btn-action mx-2" onclick="location.href='/BuyTime/pages/secure/index.php?page=project_list'">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#manage-project').submit(function(e) {
		e.preventDefault();
		start_load();
		$.ajax({
			url: '/BuyTime/helpers/ajax.php?action=save_project',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: response => {
				if (response.split(":")[0] == 'ok') {
					alert_toast('Data successfully saved', 'success');
					setTimeout(() => {
						location.href = '/BuyTime/pages/secure/index.php?page=view_project&id=' + response.split(':')[1]
					}, 1500);
				} else if (response == 0) {
					$('#msg').html('<div class="alert alert-danger">' + response + '</div>');
					end_load();
				} else if (response == 2) {
					$('#msg').html('<div class="alert alert-danger">Please fill every required information</div>');
					end_load();
				} else if (response == 3) {
					$('#msg').html('<div class="alert alert-danger">Start date cannot be higher than end date.</div>');
					end_load();
				} else {
					$('#msg').html('<div class="alert alert-danger">' + response + '</div>');
					end_load();
				}
			}
		});
	});
</script>
