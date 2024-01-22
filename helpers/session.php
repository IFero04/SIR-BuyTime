<?php
session_start();
require_once __DIR__ . '/../infra/repositories/userRepository.php';

function isAuthenticated()
{
    return isset($_SESSION['name']) ? true : false;
}

function user()
{
    if (isAuthenticated()) {
       return getUserById($_SESSION['id']);
    }

    return false;
}

function userId()
{
    return $_SESSION['id'];
}

function administrator()
{
    $user = user();
	return $user['administrator'] ? true : false;
}

function isUserAdmin($user)
{
    $user = getUserByid($user['id']);
	return $user['administrator'] ? true : false;
}

function updateUserInfo($user)
{
	return updateUser($user);
}

function getNoAdmins() {
	return getNormalUsers();
}

function getUsersExcludingId($user_id)
{
	return getAllUsersExceptId($user_id);
}

function getUserWithId($user_id)
{
	return getUserById($user_id);
}

function getUsersWithIds($ids)
{
	return getUsersByIds($ids);
}

function getEveryUser()
{
	return getAllUsers();
}

function deleteUserById($user_id)
{
	return deleteUser($user_id);
}

?>