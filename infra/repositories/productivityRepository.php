<?php
require_once __DIR__ . '../../db/connection.php';

function createProductivity($productivity) {
    $sqlCreate = "INSERT INTO user_productivity (project_id, task_id, comment, attachment, subject, date, start_time, end_time, user_id, time_rendered) VALUES (:project_id, :task_id, :comment, :attachment, :subject, :date, :start_time, :end_time, :user_id, :time_rendered)";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        'project_id' => $productivity['project_id'],
        'task_id' => $productivity['task_id'],
        'comment' => $productivity['comment'],
        'subject' => $productivity['subject'],
        'date' => $productivity['date'],
        'start_time' => $productivity['start_time'],
		'attachment' => $productivity['attachment'],
        'end_time' => $productivity['end_time'],
        'user_id' => $productivity['user_id'],
        'time_rendered' => $productivity['time_rendered']
    ]);

    if ($success) {
        $productivity['id'] = $GLOBALS['pdo']->lastInsertId();
    }

    return $success;
}

function getSummedTimeRenderedWithProjectId($project_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT SUM(time_rendered) as duration FROM user_productivity WHERE project_id = :project_id");
	$PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}

function editProgress($project_id, $project) {
    $PDOStatement = $GLOBALS['pdo']->prepare("UPDATE user_productivity SET id = :id, project_id = :project_id, task_id = :task_id, comment = :comment, subject = :subject, date = :date, start_time = :start_time, end_time = :end_time, user_id = :user_id, time_rendered = :time_rendered WHERE id = :id");
    $PDOStatement->bindValue(':id', $project_id, PDO::PARAM_INT);
    $PDOStatement->bindValue(':project_id', $project['project_id'], PDO::PARAM_INT);
    $PDOStatement->bindValue(':task_id', $project['task_id'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':comment', $project['comment'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':subject', $project['subject'], PDO::PARAM_INT);
    $PDOStatement->bindValue(':date', $project['date'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':start_time', $project['start_time'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':end_time', $project['end_time'], PDO::PARAM_INT);
    $PDOStatement->bindValue(':user_id', $project['user_id'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':time_rendered', $project['time_rendered'], PDO::PARAM_STR);
    $PDOStatement->execute();

    return $PDOStatement->rowCount();
}

function getProductivityById($id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM user_productivity WHERE id = :id");
    $PDOStatement->bindValue(':id', $id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}

function deleteProgressById($progress_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("DELETE FROM user_productivity WHERE id = :id;");
	$PDOStatement->bindValue(':id', $progress_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	$rows = $PDOStatement->rowCount();

	if ($rows > 0) {
		return 1;
	} else {
		return $rows;
	}
}

function getProductivityFullByProjectId($project_id) {
    $sql = "SELECT p.*, CONCAT(u.name, ' ', u.lastname) as uname, u.foto, t.task
	FROM user_productivity p
	INNER JOIN users u ON u.id = p.user_id
	INNER JOIN task_list t ON t.id = p.task_id
	WHERE p.project_id = :project_id
	ORDER BY UNIX_TIMESTAMP(p.date_created) DESC";
	//INNER JOIN task_list t ON t.id = p.task_id

    $PDOStatement = $GLOBALS['pdo']->prepare($sql);
    $PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getProductivitiesByProjectId($project_id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM user_productivity WHERE project_id = :project_id");
    $PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getProductivitiesByUserId($user_id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM user_productivity WHERE user_id = :user_id");
    $PDOStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProductivities() {
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM user_productivity order by project_id asc;');
    $tasks = [];

    while ($listaDeTasks = $PDOStatement->fetch()) {
        $tasks[] = $listaDeTasks;
    }
	
    return $tasks;
}
