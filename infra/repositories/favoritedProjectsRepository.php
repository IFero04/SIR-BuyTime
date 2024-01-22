<?php
require_once __DIR__ . '../../db/connection.php';

function createNewFavoritedProject($favorited) {
    $sqlCreate = "INSERT INTO fav_projects (user_id, project_id) VALUES (:user_id, :project_id);";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        'user_id' => $favorited['user_id'],
        'project_id' => $favorited['project_id']
    ]);

    return $success;
}

function getFavoritedProjectsByUserId($user_id, $project_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM fav_projects WHERE user_id = :user_id AND project_id = :project_id;");
	$PDOStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	$result = $PDOStatement->fetch(PDO::FETCH_ASSOC);

	if ($result) {
		return true;
	} else {
		return false;
	}
}

function getAllFavoritedProjects() {
	$PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM fav_projects;');
    $favoritedProjects = [];

    while ($listaDeFavoritos = $PDOStatement->fetch()) {
        $projects[] = $listaDeFavoritos;
    }
	
    return $favoritedProjects;
}

function deleteFavoritedByIds($user_id, $project_id) {
	$PDOStatement = $GLOBALS['pdo']->prepare("DELETE FROM fav_projects WHERE user_id = :user_id AND project_id = :project_id;");
	$PDOStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->bindValue(':project_id', $project_id, PDO::PARAM_INT);
	$PDOStatement->execute();

	$rows = $PDOStatement->rowCount();

	if ($rows > 0) {
		return 1;
	} else {
		return $rows;
	}
}

?>