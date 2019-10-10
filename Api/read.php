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

        $result = $user->read();

        $num = $result->rowCount();

        if($num > 0)
        {
            $user_arr = array();
            $user_arr['data'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);

                $user_item = array(
                    'id' => $id,
                    'user' => $user,
                    'pass' => $pass,
                    'email' => $email

                );

                array_push($user_arr['data'], $user_item);

            }
            echo json_encode($user_arr);
        }
        else
        {
            echo json_encode(
                array('message' => 'No Posts Found')
            );
        }
    }
    else
    {
        echo "Nie jesteś zalogowany by korzystać z API";
    }