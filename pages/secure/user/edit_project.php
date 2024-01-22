<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/project.php';

$project = project($_GET['id']);

if ($project) {
	foreach ($project as $k => $v) {
		$$k = $v;
	}
}

include 'new_project.php';
?>