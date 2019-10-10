<?php
    session_start();

    if(!isset($_SESSION['zalogowany']))
    {
        header('Location:index.php');
        exit();
    }
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Moje dane!</title>

	<style>
	body{
		text-align: center;
	}

	</style>

</head>
<body>

<?php
    echo "<p>Witaj ".$_SESSION['user'].
    '</p>[<a href="logout.php">Wyloguj się</a>]';

    echo "<p>E-mail ".$_SESSION['email']."</p>";
?>

</body>
</html>