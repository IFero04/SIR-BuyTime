<?php

require_once __DIR__ . '/../infra/repositories/taskRepository.php';

function getTasks()
{
	return getAllTasks();
}

function getTaskWithId($task_id)
{
    return getTaskById($task_id);
}

function getTasksWithProjectId($project_id)
{
    return getTasksByProjectId($project_id);
}

function getTasksWithProjectIdAndStatus($project_id, $status)
{
	return getTasksByProjectIdAndStatus($project_id, $status);
}

function getTasksContainingProjects($where)
{
	return getTasksWithProjects($where);
}

function deleteTaskWithId($task_id)
{
	return deleteTaskById($task_id);
}

function createTask($task)
{
	return createNewTask($task);
}

function updateTask($id, $task)
{
	return editTask($id, $task);
}

?>