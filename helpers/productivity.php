<?php

require_once __DIR__ . '/../infra/repositories/productivityRepository.php';

function getProductivities()
{
	return getAllProductivities();
}

function getProductivitiesWithProjectId($project_id)
{
    return getProductivitiesByProjectId($project_id);
}

function getProductivityFullWithProjectId($project_id)
{
	return getProductivityFullByProjectId($project_id);
}

function getProductivitiesWithUserId($user_id)
{
	return getProductivitiesByUserId($user_id);
}

function deleteProgressWithId($progress_id)
{
	return deleteProgressById($progress_id);
}

function productivity($productivity_id) {
	return getProductivityById($productivity_id);
}

function createProgress($progress)
{
	return createProductivity($progress);
}

function updateProgress($id, $progress)
{
	return editProgress($id, $progress);
}

function getMultipleSummedTimeRenderedWithProjectId($project_id)
{
	return getSummedTimeRenderedWithProjectId($project_id);
}

?>