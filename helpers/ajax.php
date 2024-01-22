<?php
	require_once __DIR__ . '/../infra/middlewares/middleware-user.php';
	@require_once __DIR__ . '/../helpers/session.php';
	@require_once __DIR__ . '/../helpers/project.php';
	@require_once __DIR__ . '/../helpers/productivity.php';
	@require_once __DIR__ . '/../helpers/task.php';
	@require_once __DIR__ . '/../helpers/favProjects.php';

	$action = $_GET['action'];

	function update_user() {
		extract($_POST);
		$user = user();

		$user_id = $_POST['id'];
		$user_name = $_POST['firstname'];
		$user_lastname = null;
		$user_email = $user['email'];
		$user_administrator = $user['administrator'];
		$password = null;
		$imageName = 'defaultAvatar.png';

		if (isset($_FILES['img']) && $_FILES['img']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['img']['name'];
			$move = move_uploaded_file($_FILES['img']['tmp_name'], __DIR__ . '/../../BuyTime/assets/uploads/' . $fname);
			$imageName = $fname;
		} elseif ($user['foto'] != 'defaultAvatar.png') {
			$imageName = $user['foto'];
		}

		if ($_POST['password'] == '') {
			$password = '';
		} elseif ($_POST['password'] != '' && strlen($_POST['password']) < 6) {
			return 2;
		} else {
			$password = $_POST['password'];
		}

		if ($_POST['lastname'] != '') {
			$user_lastname = $_POST['lastname'];
		}

		$userObject = [];
		$userObject['id'] = $user_id;
		$userObject['name'] = $user_name;
		$userObject['lastname'] = $user_lastname;
		$userObject['email'] = $user_email;
		$userObject['administrator'] = $user_administrator;
		$userObject['foto'] = $imageName;


		if ($password != '') {
			$userObject['password'] = $password;
			updateUser($userObject);
			$user = user();
			return 1;
		} else {
			updateUser($userObject);
			$user = user();
			return 1;
		}
	}

	function delete_project() {
		extract($_POST);
		$projectDelete = deleteProjectWithId($id);
		
		if ($projectDelete == 1) {
			return 1;
		} else {
			return $projectDelete;
		}
	}

	function delete_progress() {
		extract($_POST);
		$progressDelete = deleteProgressWithId($id);
		
		if ($progressDelete == 1) {
			return 1;
		} else {
			return $progressDelete;
		}
	}

	function delete_task() {
		extract($_POST);
		$taskDelete = deleteTaskWithId($id);
		
		if ($taskDelete == 1) {
			return 1;
		} else {
			return $taskDelete;
		}
	}

	function save_project() {
		extract($_POST);

		$project_title = $_POST['title'];
		$project_description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
		$project_userids = isset($_POST['user_ids']) ? implode(',', $_POST['user_ids']) : '';

		if ($_POST['title'] == '' || empty(trim($_POST['description'])) || $_POST['start_date'] == '' || $_POST['end_date'] == '' || $_POST['manager_id'] == '') {
			return 2;
		}

		$startdate = strtotime($_POST['start_date']);
		$enddate = strtotime($_POST['end_date']);

		if ($enddate < $startdate) return 3;
		
		$projectObject = [
			'title' => $project_title,
			'description' => $project_description,
			'category' => $_POST['category'],
			'priority' => $_POST['priority'],
			'status' => $_POST['status'],
			'start_date' => $_POST['start_date'],
			'end_date' => $_POST['end_date'],
			'manager_id' => $_POST['manager_id'],
			'user_ids' => $project_userids
		];
		
		if (empty($id)) {
			$save = createProject($projectObject);
		} else {
			$save = updateProject($id, $projectObject);
		}

		if ($save) {
			$return = array("ok", $save);
			$implodedReturn = implode(":", $return);
			return $implodedReturn;
		}
	}

	function favorite_project() {
		extract($_POST);

		$user_id = $_POST['user_id'];
		$project_id = $_POST['id'];
		$favorite = $_POST['favorito'];

		$favoriteObject = [
			'user_id' => $user_id,
			'project_id' => $project_id
		];

		if ($favorito == 'true') {
			$save = createNewFavoritedProject($favoriteObject);
		} else {
			$save = deleteFavoritedWithId($user_id, $project_id);
		}

		return $save;
	}

	function save_task() {
		extract($_POST);

		$task_project_id = $_POST['project_id'];
		$task_task = $_POST['task'];
		$task_description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
		$task_status = $_POST['status'];

		if ($_POST['task'] == '' || empty(trim($_POST['description'])) || $_POST['status'] == '') {
			return 2;
		}

		$taskObject = [
			'project_id' => $task_project_id,
			'task' => $task_task,
			'description' => $task_description,
			'status' => $task_status,

		];

		if (empty($id)) {
			$save = createTask($taskObject);
		} else {
			$save = updateTask($id, $taskObject);
		}

		return $save;
	}

	function save_progress() {
		extract($_POST);
		$data = "";

		$user = user();

		$progress_project_id = $_POST['project_id'];
		$progress_task_id = $_POST['task_id'];
		$progress_comment = $_POST['comment'];
		$progress_subject = $_POST['subject'];
		$progress_date = $_POST['date'];
		$progress_start_time = $_POST['start_time'];
		$progress_end_time = $_POST['end_time'];
		$progress_user_id = $user['id'];
		$progress_attachment = '';

		if (isset($_FILES['attachment']) && $_FILES['attachment']['tmp_name'] != '') {
			$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['attachment']['name'];

			$path = __DIR__ . '/../../BuyTime/assets/attachments/' . $progress_project_id;
			if (!is_dir($path)) {
				mkdir($path);
			}

			$move = move_uploaded_file($_FILES['attachment']['tmp_name'], __DIR__ . '/../../BuyTime/assets/attachments/' . $progress_project_id . '/' . $_FILES['attachment']['name']);
			$progress_attachment = $_FILES['attachment']['name'];
		}

		if (!$progress_task_id) {
			return 2;
		}
		
		$dur = abs(strtotime("2020-01-01 ".$end_time)) - abs(strtotime("2020-01-01 ".$start_time));
		if (abs(strtotime("2020-01-01 ".$end_time)) < abs(strtotime("2020-01-01 ".$start_time))) return 3;
		$dur = $dur / (60 * 60);

		$progress_timerendered = $dur;

		$progressObject = [
			'project_id' => $progress_project_id,
			'task_id' => $progress_task_id,
			'comment' => $progress_comment,
			'subject' => $progress_subject,
			'date' => $progress_date,
			'start_time' => $progress_start_time,
			'end_time' => $progress_end_time,
			'user_id' => $progress_user_id,
			'attachment' => $progress_attachment,
			'time_rendered' => $progress_timerendered
		];

		if (empty($id)) {
			$save = createProgress($progressObject);
		} else {
			$save = updateProgress($id, $progressObject);
		}

		if ($save) return "ok";
	}

	function delete_user() {
		extract($_POST);
		$delete = deleteUserById($id);
		if ($delete) return 1;
	}

	if ($action == 'update_user') {
		$save = update_user();
		if ($save) echo $save;
	}

	if ($action == 'delete_project') {
		$save = delete_project();
		if ($save) echo $save;
	}

	if ($action == 'save_project') {
		$save = save_project();
		if ($save) echo $save;
	}

	if ($action == 'favorite_project') {
		$save = favorite_project();
		if ($save) echo $save;
	}

	if ($action == 'save_progress') {
		$save = save_progress();
		if ($save) echo $save;
	}

	if ($action == 'delete_progress') {
		$save = delete_progress();
		if ($save) echo $save;
	}

	if ($action == 'delete_task') {
		$save = delete_task();
		if ($save) echo $save;
	}

	if ($action == 'delete_user') {
		$save = delete_user();
		if ($save) echo $save;
	}

	if ($action == 'save_task') {
		$save = save_task();
		if ($save) echo $save;
	}
?>