<?php
	session_start();

	if((!isset($_SESSION['udanarejestracja'])))
    {
        header('Location: index.php');
        exit();
    }
    else
    {
        unset($_SESSION['udanarejestracja']);
    }

    //Usuwanie zmiennych z sesji
    if(isset($_SESSION['rem_nick'])) unset($_SESSION["rem_nick"]);
    if(isset($_SESSION['rem_email'])) unset($_SESSION["rem_email"]);
    if(isset($_SESSION['rem_haslo1'])) unset($_SESSION["rem_haslo1"]);
    if(isset($_SESSION['rem_haslo2'])) unset($_SESSION["rem_haslo2"]);
    if(isset($_SESSION['rem_regulamin'])) unset($_SESSION["rem_regulamin"]);
    if(isset($_SESSION['e_nick'])) unset($_SESSION["e_nick"]);
    if(isset($_SESSION['e_email'])) unset($_SESSION["e_email"]);
    if(isset($_SESSION['e_haslo'])) unset($_SESSION["e_haslo"]);
    if(isset($_SESSION['e_regulamin'])) unset($_SESSION["e_regulamin"]);
    if(isset($_SESSION['e_recaptcha'])) unset($_SESSION["e_recaptcha"]);
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Potwierdzenie rejestracji</title>

	<style>
	body{
		text-align: center;
	}

	</style>

</head>
<body>
	Dziękujemy za rejestrację!
    Wszystko przebiegło pomyślnie 
    <br/> <br/>
    <a href="index.php">Przejdź do okna logowania</a>

</body>
</html>