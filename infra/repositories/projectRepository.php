<?php
require_once __DIR__ . '../../db/connection.php';

function createNewProject($project) {
    $sqlCreate = "INSERT INTO project_list (title, description, category, priority, status, start_date, end_date, manager_id, user_ids) VALUES (:title, :description, :category, :priority, :status, :start_date, :end_date, :manager_id, :user_ids)";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        'title' => $project['title'],
        'description' => $project['description'],
		'category' => $project['category'],
		'priority' => $project['priority'],
        'status' => $project['status'],
        'start_date' => $project['start_date'],
        'end_date' => $project['end_date'],
        'manager_id' => $project['manager_id'],
        'user_ids' => $project['user_ids']
    ]);

    if ($success) {
        $project['id'] = $GLOBALS['pdo']->lastInsertId();
		return $GLOBALS['pdo']->lastInsertId();
    }
}

function editProject($project_id, $project) {
    $PDOStatement = $GLOBALS['pdo']->prepare("UPDATE project_list SET title = :title, description = :description, category = :category, priority = :priority, status = :status, start_date = :start_date, end_date = :end_date, manager_id = :manager_id, user_ids = :user_ids WHERE id = :project_id");
    $PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    $PDOStatement->bindValue(':title', $project['title'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':description', $project['description'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':category', $project['category'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':priority', $project['priority'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':status', $project['status'], PDO::PARAM_INT);
    $PDOStatement->bindValue(':start_date', $project['start_date'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':end_date', $project['end_date'], PDO::PARAM_STR);
    $PDOStatement->bindValue(':manager_id', $project['manager_id'], PDO::PARAM_INT);
    $PDOStatement->bindValue(':user_ids', $project['user_ids'], PDO::PARAM_STR);
    $PDOStatement->execute();

    return $PDOStatement->rowCount();
}

function getProjectById($id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM project_list WHERE id = :id");
    $PDOStatement->bindValue(':id', $id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}

function getProjectByTitle($title, $manager_id) {
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM project_list WHERE title = :title AND manager_id = :manager_id");
    $PDOStatement->bindValue(':title', $title, PDO::PARAM_STR);
    $PDOStatement->bindValue(':manager_id', $manager_id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProjects() {
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM project_list order by start_date asc;');
    $projects = [];

    while ($listaDePojetos = $PDOStatement->fetch()) {
        $projects[] = $listaDePojetos;
    }
	
    return $projects;
}

function getUserOwnProjects($user_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM project_list WHERE manager_id = :manager_id;");
	$PDOStatement->bindValue(':manager_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function deleteProjectById($project_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("DELETE FROM project_list WHERE id = :id;");
	$PDOStatement->bindValue(':id', $project_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	$rows = $PDOStatement->rowCount();

	if ($rows > 0) {
		return 1;
	} else {
		return $rows;
	}
}

function getUserOwnProjectsWithId($project_id, $title, $user_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM project_list WHERE id = :project_id AND title = :title AND manager_id = :manager_id;");
	$PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$PDOStatement->bindValue(':title', $title, PDO::PARAM_STR);
	$PDOStatement->bindValue(':manager_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}

function getUserPermissionProjects($user_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM project_list WHERE manager_id != :manager_id AND FIND_IN_SET(:user_id, REPLACE(user_ids, ';', ',')) > 0;");
	$PDOStatement->bindValue(':manager_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getUserPermissionProjectsWithTitle($project_id, $title, $user_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM project_list WHERE id = :project_id AND manager_id != :manager_id AND title = :title AND FIND_IN_SET(:user_id, REPLACE(user_ids, ';', ',')) > 0;");
	$PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$PDOStatement->bindValue(':title', $title, PDO::PARAM_STR);
	$PDOStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->bindValue(':manager_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}