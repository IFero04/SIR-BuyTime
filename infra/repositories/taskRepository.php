<?php
require_once __DIR__ . '../../db/connection.php';

function createNewTask($task) {
    $sqlCreate = "INSERT INTO task_list (project_id, task, description, status) VALUES (:project_id, :task, :description, :status)";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        'project_id' => $task['project_id'],
        'task' => $task['task'],
        'description' => $task['description'],
        'status' => $task['status']
    ]);

    if ($success) {
        $task['id'] = $GLOBALS['pdo']->lastInsertId();
    }

    return $success;
}

function getTasksWithProjects($where) {
    $sql = "SELECT t.*, p.title as pname, p.start_date, p.status as pstatus, p.end_date, p.id as pid 
            FROM task_list t 
            INNER JOIN project_list p ON p.id = t.project_id 
            $where 
            ORDER BY p.title ASC";

    $PDOStatement = $GLOBALS['pdo']->prepare($sql);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getTaskById($id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM task_list WHERE id = :id");
    $PDOStatement->bindValue(':id', $id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}

function editTask($task_id, $task) {
    $PDOStatement = $GLOBALS['pdo']->prepare("UPDATE task_list SET project_id = :project_id, task = :task, description = :description, status = :status WHERE id = :id");
    $PDOStatement->bindValue(':id', $task_id, PDO::PARAM_INT);
    $PDOStatement->bindValue(':project_id', $task['project_id'], PDO::PARAM_INT);
    $PDOStatement->bindValue(':task', $task['task'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':description', $task['description'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':status', $task['status'], PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->rowCount();
}

function deleteTaskById($task_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("DELETE FROM task_list WHERE id = :id;");
	$PDOStatement->bindValue(':id', $task_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	$rows = $PDOStatement->rowCount();

	if ($rows > 0) {
		return 1;
	} else {
		return $rows;
	}
}

function getTasksByProjectId($project_id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM task_list WHERE project_id = :project_id order by task asc;");
    $PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getTasksByProjectIdAndStatus($project_id, $status) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM task_list WHERE project_id = :project_id AND status = :status;");
    $PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    $PDOStatement->bindValue(':status', $status, PDO::PARAM_INT);
    $PDOStatement->execute();
	
    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTasks() {
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM task_list order by project_id asc;');
    $tasks = [];

    while ($listaDeTasks = $PDOStatement->fetch()) {
        $tasks[] = $listaDeTasks;
    }
	
    return $tasks;
}
