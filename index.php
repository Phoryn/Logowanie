<?php
	session_start();

	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true))
    {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Logowanie</title>

	<style>
	body{
		text-align: center;
	}

	</style>
</head>
<body>
	Witaj na mojej stronie! <br/> <br/>
	<a href="rejestracja.php">Rejestracja!</a>
	<br />

	<form action="logowanie.php" method="POST">

	Login: <br/> <input type="text" name="login"> <br/>
	Hasło: <br/> <input type="password" name="haslo"> <br/><br/>
	<input type="submit" value="Zaloguj sie">
	</form>
<?php
	if(isset($_SESSION['blad'])) 
	{
		echo $_SESSION['blad'];
		unset($_SESSION['blad']);
	}
?>



</body>
</html>

