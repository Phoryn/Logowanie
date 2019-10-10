<?php
    session_start();
    
    if(isset($_POST['email']))
    {

        $wszystko_ok = true;

        ////nick
        $nick = $_POST['nick'];

        if(strlen($nick) < 3 || (strlen($nick) > 20))
        {

            $wszystko_ok = false;
            $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków";

        }
        if(ctype_alnum($nick) == false)
        {
            $wszystko_ok = false;
            $_SESSION['e_nick'] ="Nick może składać się tylko z liter i cyfr, bez polskich znaków";
        }
        ////email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
        {
            $wszystko_ok = false;
            $_SESSION['e_email'] = "Podaj poprawny adres e-mail";
        }
        ////hasło
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] ="Hasło musi mieć od 8 do 20 znaków";
        }

        if($haslo1 != $haslo2)
        {
            $wszystko_ok = false;
            $_SESSION['e_haslo'] ="Hasła nie są identyczne!";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        ////regulamin
        if(!isset($_POST['regulamin']))
        {
            $wszystko_ok = false;
            $_SESSION['e_regulamin'] ="Zaakceptuj regulamin!";
        }

        ////recaptcha
        $sekret_key = "6LeCf7wUAAAAAHIJ7HziqylqAFTrBxjqR-cSn3VI";

        $sprawdz = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".
        $sekret_key.'&response='.$_POST['g-recaptcha-response']);

        $odpowiedz = json_decode($sprawdz);

        if($odpowiedz->success == false)
        {
            $wszystko_ok = false;
            $_SESSION['e_recaptcha'] ="Potwierdź, że jesteś człowiekiem";
        }
        ////Zapamiętywanie danych

        $_SESSION["rem_nick"] = $nick;
        $_SESSION["rem_email"] = $email;
        $_SESSION["rem_haslo1"] = $haslo1;
        $_SESSION["rem_haslo2"] = $haslo2;

        if(isset($_POST['regulamin']))
        {
            $_SESSION["rem_regulamin"] = true;
        }

        ////Dodanie do bazy
        require_once "connect.php";

        try
        {




            $database = new Database();
            $polaczenie = $database->connect();


            //$polaczenie = new mysqli($host, $db_user, $db_password , $db_name);


            //email czy jest
            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

            if(!$rezultat) throw new Exception($polaczenie->errorInfo());

            $ile_maili = $rezultat->fetchColumn();
            if($ile_maili >0)
            {
                $wszystko_ok = false;
                $_SESSION['e_email'] ="Istnieje już konto przypisane do tego adresu email";
            }

            //czy nick już jest
            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

            if(!$rezultat) throw new Exception($polaczenie->errorInfo());

            $ile_nickow = $rezultat->fetchColumn();
            if($ile_nickow >0)
            {
                $wszystko_ok = false;
                $_SESSION['e_nick'] ="Istnieje już gracz o takim nicku";
            }

            ////dodajemy do bazy
            if($wszystko_ok == true)
            {
                if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL,'$nick','$haslo_hash','$email')"))
                {
                    echo (string)$nick;
                    echo (string)$haslo_hash;
                    echo (string)$email;
                    $_SESSION['udanarejestracja'] = true;
                    header('Location:confirm.php');
                }
                else
                {
                    echo "Coś poszło nie tak!";
                }
            }

        }
        catch(Exception $e)
        {
            echo '<span style="color:red">Błąd serwera! Prosimy o rejestrację w innym terminie bądź kontakt z administracją!</span>';
            //echo '<br /> Informacja dev'.$e;
        }

    }


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title>Załóż konto!</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
    .error
    {
        color: red;
        margin: 10 0;
    }

	body{
		text-align: center;
	}


    </style>

</head>
<body>

    <form method="post">
    
    Nick: <br /> <input type="text" value="<?php
    if(isset($_SESSION["rem_nick"]))
    {
        echo $_SESSION["rem_nick"];
        unset($_SESSION["rem_nick"]);
    }
    ?>" name="nick" /><br />
    <?php
        if(isset($_SESSION['e_nick']))
        {
            echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
        }
    ?>

    Email: <br /> <input type="text" value="<?php
    if(isset($_SESSION["rem_email"]))
    {
        echo $_SESSION["rem_email"];
        unset($_SESSION["rem_email"]);
    }
    ?>"  name="email" /><br />
    <?php
        if(isset($_SESSION['e_email']))
        {
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
    ?>

    Hasło: <br /> <input type="password" value="<?php
    if(isset($_SESSION["rem_haslo1"]))
    {
        echo $_SESSION["rem_haslo1"];
        unset($_SESSION["rem_haslo1"]);
    }
    ?>" name="haslo1" /><br />
    <?php
        if(isset($_SESSION['e_haslo']))
        {
            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }
    ?>
    Potwierdź hasło: <br /> <input type="password" value="<?php
    if(isset($_SESSION["rem_haslo2"]))
    {
        echo $_SESSION["rem_haslo2"];
        unset($_SESSION["rem_haslo2"]);
    }
    ?>"  name="haslo2" /><br />

    <label>
    <input type="checkbox" name="regulamin" <?php
    if(isset($_SESSION["rem_regulamin"]))
    {
        echo "checked";
        unset($_SESSION["rem_regulamin"]);
    }
    ?>  /> Akcpetuję regulamin
    </label>
    <?php
        if(isset($_SESSION['e_regulamin']))
        {
            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }
    ?>

    <div class="g-recaptcha" data-sitekey="6LeCf7wUAAAAAElyFfu45o7hILQpKRalXhh38Enj"></div>
    <?php
        if(isset($_SESSION['e_recaptcha']))
        {
            echo '<div class="error">'.$_SESSION['e_recaptcha'].'</div>';
            unset($_SESSION['e_recaptcha']);
        }
    ?>
    
    <br />
    <input type="submit" value="Zarejestruj" />
    </form>

</body>
</html>