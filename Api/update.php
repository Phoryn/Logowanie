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


    $id_s = isset($_POST['id']) ? $_POST['id'] : 'nie ma';
    $user_s = isset($_POST['user']) ? $_POST['user'] : 'nie ma';
    $email_s = isset($_POST['email']) ? $_POST['email'] : 'nie ma';

    $result = $user->update($id_s ,$user_s, $email_s);
}
else
{
    echo "Nie jesteś zalogowany by korzystać z API";
}
?>