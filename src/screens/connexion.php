<?php
session_start();
$bdd = new PDO('mysql: host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_POST['formconnect']))
{
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($mailconnect) AND !empty($mdpconnect)) 
    {
        $requser = $bdd->prepare("SELECT * FROM members WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) 
        {
            $userinfo = $requser->fetch();
            $SESSION['id'] = $userinfo['id'];
            $SESSION['pseudo'] = $userinfo['pseudo'];
            $SESSION['mail'] = $userinfo['mail'];
            header("Location: home.html?id=".$_SESSION['id']);
        }
        else 
        {
            $erreur = "Mauvais identifiant";
        }
    }
    else {
        $erreur = "Tous les champs doivent être complétés";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscriptionplayer</title>
</head>
<body>
    
    <div align="center"> 
        <h2>Connection</h2>
        <br /><br />
        <form method="POST" action="">
            <input type="email" name="mailconnect" placeholder="Mail" />
            <input type="password" name="mdpconnect" placeholder="Mot de passe" />
            <input type="submit" name="formconnect" placeholder="Ce connecter" />
        </form>
        <?php

         if(isset($erreur)) {
             echo $erreur;
         }

        ?>
</body>
</html>