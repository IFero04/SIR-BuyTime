<?php

require_once __DIR__ . '/../infra/repositories/projectRepository.php';

function getProjects()
{
	return getAllProjects();
}

function createProject($project)
{
	return createNewProject($project);
}

function updateProject($id, $projectObject)
{
	return editProject($id, $projectObject);
}

function project($project_id)
{
    return getProjectById($project_id);
}

function deleteProjectWithId($project_id)
{
	return deleteProjectById($project_id);
}

function getUserProjects($user_id)
{
    return getUserOwnProjects($user_id);
}

function getUserProjectsWithIdAndManagerId($project_id, $title, $user_id)
{
	return getUserOwnProjectsWithId($project_id, $title, $user_id);
}

function getUserAddedProjects($user_id)
{
    return getUserPermissionProjects($user_id);
}

function getUserAddedProjectsWithTitle($project_id, $title, $user_id)
{
    return getUserPermissionProjectsWithTitle($project_id, $title, $user_id);
}

?>