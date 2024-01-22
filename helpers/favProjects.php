<?php

require_once __DIR__ . '/../infra/repositories/favoritedProjectsRepository.php';

function getFavoritedProjects()
{
	return getAllFavoritedProjects();
}

function getFavoritedProjectsWithUserId($user_id, $project_id)
{
	return getFavoritedProjectsByUserId($user_id, $project_id);
}

function createFavoritedProject($favoritedProject)
{
	return createNewFavoritedProject($favoritedProject);
}

function deleteFavoritedWithId($user_id, $project_id)
{
	return deleteFavoritedByIds($user_id, $project_id);
}

?>