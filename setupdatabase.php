<?php
# EASY DATABASE SETUP
require __DIR__ . '/infra/db/connection.php';

# DROP TABLE
$pdo->exec('DROP TABLE IF EXISTS fav_projects;');
$pdo->exec('DROP TABLE IF EXISTS task_list;');
$pdo->exec('DROP TABLE IF EXISTS categorys_tasks;');
$pdo->exec('DROP TABLE IF EXISTS user_productivity;');
$pdo->exec('DROP TABLE IF EXISTS project_list;');
$pdo->exec('DROP TABLE IF EXISTS users;');

echo 'Tables deleted!' . PHP_EOL;

# CREATE TABLE
$pdo->exec(
    'CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL, 
        name varchar(50), 
        lastname varchar(50), 
        phoneNumber varchar(50) NULL, 
        email varchar(50) NOT NULL, 
        foto LONGTEXT NOT NULL, 
        administrator TINYINT(1) DEFAULT 0 NOT NULL, 
        password varchar(200)
    );'
);

$pdo->exec(
    'CREATE TABLE project_list (
        id int(30) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        title varchar(200) NOT NULL,
        description text NOT NULL,
		category tinyint(2) NOT NULL,
		priority tinyint(2) NOT NULL,
        status tinyint(2) NOT NULL,
        start_date date NOT NULL,
        end_date date NOT NULL,
        manager_id int(30) NOT NULL,
        user_ids text NOT NULL,
        date_created datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
);

$pdo->exec(
    'CREATE TABLE task_list (
        id int(30) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        project_id int(30) NOT NULL,
        task varchar(200) NOT NULL,
        description text NOT NULL,
        status tinyint(4) NOT NULL,
        date_created datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
);

$pdo->exec(
    'CREATE TABLE fav_projects (
        user_id INTEGER NOT NULL,
        project_id int(30) NOT NULL,
        PRIMARY KEY (user_id, project_id),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (project_id) REFERENCES project_list(id) ON DELETE CASCADE
    );'
);

$pdo->exec(
    'CREATE TABLE categorys_tasks (
        user_id INTEGER NOT NULL,
        task_id int(30) NOT NULL,
        category_description text NOT NULL
    );'
);

$pdo->exec(
    'CREATE TABLE user_productivity (
        id int(30) PRIMARY KEY AUTO_INCREMENT NOT NULL,
        project_id int(30) NOT NULL,
        task_id int(30) NOT NULL,
        comment text NOT NULL,
		attachment LONGTEXT NOT NULL,
        subject varchar(200) NOT NULL,
        date date NOT NULL,
        start_time time NOT NULL,
        end_time time NOT NULL,
        user_id int(30) NOT NULL,
        time_rendered float NOT NULL,
        date_created datetime NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
);

echo 'Tabels created!' . PHP_EOL;


# DEFAULT USERS TO ADD
$adminPassword = 'admin123';
$pdo->exec(
    "INSERT INTO `users` (`id`, `name`, `lastname`, `phoneNumber`, `email`, `foto`, `administrator`, `password`) VALUES
    (1, 'Admin', 'Administrator', NULL, 'admin@admin.com', 'defaultAvatar.png', 1, '" . password_hash($adminPassword, PASSWORD_DEFAULT) . "')"
);


echo 'Default users and data created!';

?>
