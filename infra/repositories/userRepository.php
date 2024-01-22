<?php
require_once __DIR__ . '../../db/connection.php';

function createUser($user)
{
    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    $sqlCreate = "INSERT INTO users (name, email, password, foto) VALUES (:name, :email, :password, :foto)";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);

    $success = $PDOStatement->execute([
        ':name' => $user['name'],
        ':email' => $user['email'],
        ':password' => $user['password'],
		':foto' => 'defaultAvatar.png'
    ]);

    if ($success) {
        $user['id'] = $GLOBALS['pdo']->lastInsertId();
    }

    return $success;
}

function getUserById($id)
{
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM users WHERE id = :id");
    $PDOStatement->bindValue(':id', $id, PDO::PARAM_INT);
    $PDOStatement->execute();

    return $PDOStatement->fetch(PDO::FETCH_ASSOC);
}

function getUsersByIds($ids)
{
    $PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM users WHERE id in (:ids) order by name asc");
    $PDOStatement->bindValue(':ids', $ids, PDO::PARAM_STR);
    $PDOStatement->execute();

    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getNormalUsers()
{
	$PDOStatement = $GLOBALS['pdo']->prepare("SELECT * FROM users WHERE administrator = :administrator;");
	$PDOStatement->bindValue(':administrator', 0, PDO::PARAM_INT);
	$PDOStatement->execute();

	return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getUserByEmail($email)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM users WHERE email = ? LIMIT 1;');
    $PDOStatement->bindValue(1, $email);
    $PDOStatement->execute();
    return $PDOStatement->fetch();
}

function getAllUsers()
{
    $PDOStatement = $GLOBALS['pdo']->query('SELECT * FROM users order by name asc;');
    return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
}

function getAllUsersExceptId($user_id)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('SELECT * FROM users WHERE id != :user_id;');
	$PDOStatement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
	$PDOStatement->execute();

    return $PDOStatement->fetchAll();
}

function updateUser($user)
{

    if (isset($user['password']) && !empty($user['password'])) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE  
        users SET
            name = :name,
			lastname = :lastname,
            email = :email,
            administrator = :administrator,
            password = :password,
            foto = :foto
        WHERE id = :id;";

        $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

        return $PDOStatement->execute([
            ':id' => $user['id'],
            ':name' => $user['name'],
			':lastname' => $user['lastname'],
            ':email' => $user['email'],
            ':administrator' => $user['administrator'],
            ':password' => $user['password'],
            ':foto' => $user['foto'],
        ]);
    }

    $sqlUpdate = "UPDATE  
    users SET
        name = :name, 
		lastname = :lastname,
        email = :email, 
        administrator = :administrator,
        foto = :foto
    WHERE id = :id;";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

    return $PDOStatement->execute([
        ':id' => $user['id'],
        ':name' => $user['name'],
		':lastname' => $user['lastname'],
        ':email' => $user['email'],
        ':administrator' => $user['administrator'],
        ':foto' => $user['foto'],
    ]);
}

function updateUserPassword($user)
{
    if (isset($user['password']) && !empty($user['password'])) {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE  
        users SET
            name = :name, 
            password = :password
        WHERE id = :id;";

        $PDOStatement = $GLOBALS['pdo']->prepare($sqlUpdate);

        return $PDOStatement->execute([
            ':id' => $user['id'],
            ':name' => $user['name'],
            ':password' => $user['password']
        ]);
    }
}

function deleteUser($user_id)
{
    $PDOStatement = $GLOBALS['pdo']->prepare('DELETE FROM users WHERE id = :id;');
    $PDOStatement->bindValue(':id', $user_id, PDO::PARAM_INT);

    return $PDOStatement->execute();
}

function createNewUser($user)
{
    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
    $sqlCreate = "INSERT INTO 
    users (
        name, 
        email, 
        password,
		foto) 
    VALUES (
        :name, 
        :email, 
        :password,
		:foto
    )";

    $PDOStatement = $GLOBALS['pdo']->prepare($sqlCreate);
    $success = $PDOStatement->execute([
        ':name' => $user['name'],
        ':email' => $user['email'],
        ':password' => $user['password'],
		':foto' => 'defaultAvatar.png'
    ]);

    if ($success) {
        $user['id'] = $GLOBALS['pdo']->lastInsertId();
        return $user;
    }

    return false;
}
