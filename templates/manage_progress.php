<?php
	@require_once __DIR__ . '../../helpers/productivity.php';
	@require_once __DIR__ . '../../helpers/session.php';
	@require_once __DIR__ . '../../helpers/task.php';

	if (isset($_GET['id'])) {

		$productivity = productivity($_GET['id']);
		$user = user();

		if ($productivity) {
			foreach ($productivity as $k => $v) {
				$$k = $v;
			}
		}
	}
?>

<div class="container-fluid">
	<div id="msg"></div>

	<form action="" id="manage-progress">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name="project_id" value="<?php echo isset($_GET['pid']) ? $_GET['pid'] : '' ?>">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-md-5">
					<?php if (!isset($_GET['tid'])): ?>
						<div class="form-group">
							<label for="" class="control-label">Task</label>
							<select class="form-control form-control-sm select2" name="task_id" required>
								<option></option>
								<?php 
								$tasks = getTasksWithProjectId($_GET['pid']);

								foreach ($tasks as $task):
								?>
								<option value="<?php echo $task['id'] ?>" <?php echo isset($task_id) && $task_id == $task['id'] ? "selected" : '' ?>><?php echo ucwords($task['task']) ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php else: ?>
					<input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
					<input type="hidden" name="task_id" value="<?php echo isset($_GET['tid']) ? $_GET['tid'] : '' ?>">
					<?php endif; ?>
					<div class="form-group">
						<label for="">Subject</label>
						<input type="text" class="form-control form-control-sm" name="subject" value="<?php echo isset($subject) ? $subject : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Date</label>
						<input type="date" class="form-control form-control-sm" name="date" value="<?php echo isset($date) ? date("Y-m-d", strtotime($date)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">Start Time</label>
						<input type="time" class="form-control form-control-sm" name="start_time" value="<?php echo isset($start_time) ? date("H:i", strtotime("2020-01-01 ".$start_time)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="">End Time</label>
						<input type="time" class="form-control form-control-sm" name="end_time" value="<?php echo isset($end_time) ? date("H:i",strtotime("2020-01-01 ".$end_time)) : '' ?>" required>
					</div>
					<div class="form-group">
						<label for="customFile" class="control-label">Attachments</label>
						<div class="custom-file">
							<input type="file" name="attachment" id="customFile" class="custom-file-input rounded-circle" onchange="displayAttachment(this, $(this))">
							<label for="customFile" id="customFileLabel" class="custom-file-label">Choose File</label>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="form-group">
						<label for="">Comment/Progress Description</label>
						<textarea name="comment" id="" cols="30" rows="10" class="summernote form-control" required="">
							<?php echo isset($comment) ? $comment : '' ?>
						</textarea>
					</div>
				</div>
			</div>		
		</div>
	</form>
</div>

<script>
	function displayAttachment(input, _this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        // reader.onload = function (e) {
	        // 	$('#cimg').attr('src', e.target.result);
	        // }

	        // reader.readAsDataURL(input.files[0]);
			$('#customFileLabel')[0].innerHTML = input.files[0].name;
	    }
	}

	$(document).ready(function() {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				[ 'style', [ 'style' ] ],
				[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				[ 'fontname', [ 'fontname' ] ],
				[ 'fontsize', [ 'fontsize' ] ],
				[ 'color', [ 'color' ] ],
				[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				[ 'table', [ 'table' ] ],
				[ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
			]
		});

		$('.select2').select2({
			placeholder: "Please select here",
			width: "100%"
		});
	});

	$('#manage-progress').submit(function(e){
    	e.preventDefault()
    	start_load()
    	$.ajax({
    		url:'/BuyTime/helpers/ajax.php?action=save_progress',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if (resp == "ok") {
					alert_toast('Data successfully saved', 'success');
					setTimeout(() => {
						location.reload()
					}, 1500);
				} else if (resp == 0) {
					$('#msg').html('<div class="alert alert-danger">' + resp + '</div>');
					end_load();
				} else if (resp == 2) {
					$('#msg').html('<div class="alert alert-danger">Please select a task for the productivity.</div>');
					end_load();
				} else if (resp == 3) {
					$('#msg').html('<div class="alert alert-danger">Start time cannot be higher than end time.</div>');
				} else {
					$('#msg').html('<div class="alert alert-danger">' + resp + '</div>');
					end_load();
				}
			}
    	})
    });
</script>