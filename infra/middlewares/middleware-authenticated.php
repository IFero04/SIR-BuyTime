<?php
require_once __DIR__ . '/../../helpers/session.php';

if (!isAuthenticated()) {
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/BuyTime/';
    header('Location: ' . $home_url);
}
