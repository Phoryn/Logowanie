<?php

session_start();

if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true))
{

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../connect.php';
    include_once '../Models/User.php';

    $database = new Database();
    $db = $database->connect();

    $user = new User($db);

    var_dump($_POST);
    $user_s = isset($_POST['user']) ? $_POST['user'] : '';
    $pass_s = isset($_POST['pass']) ? $_POST['pass'] : '';
    $email_s = isset($_POST['email']) ? $_POST['email'] : '';

    $result = $user->create($user_s, $pass_s, $email_s);

}
else
{
    echo "Nie jesteś zalogowany by korzystać z API";
}