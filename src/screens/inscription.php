<?php

//il faut cree depuis mysql la base de donner et rajouter du coup un espace_membre (pas de mdp a mettre tout laisser par default) [] j'expliquerais a celui qui le fait le mien bug ;/
$bdd = new PDO('mysql: host=127.0.0.1;dbname=espace_membre', 'root', '');

if(isset($_POST['forminscription'])) 
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);//sha1 le mdp pour que personne ne le decrypte sha1
    $mdp2 = sha1($_POST['mdp2']);

    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) //pour la securiter de la database
    AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])){
        
        $pseudolength = strlen($pseudo); // verification des chose possible / impossible en donnent les infos.
        if($pseudolength <= 10) {
            if($mail == $mail2) {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");//verif si le mail existe deja
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0) 
                    {
                        if($mdp == $mdp2) 
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)"); 
                            //insertion dans la base de donner des donne renseigner 
                            $insertmbr->execute(array($pseudo, $mail, $mdp));
                            $erreur ="Votre compte a bien été créé !";

                            /*$_SESSION['comptecree'] = "Votre compte a bien été créé !"; 
                            header('Location: home.html'); 

                            // redirige vers le menu si terminer*/
                            
                        }
                        else 
                        {
                            $erreur ="Vos mdp ne correspondent pas !";
                        }
                    }
                    else {
                        $erreur = "Adresse mail dejas utilisée";
                    }
                }
                else 
                {
                    $erreur = "Vos adresse mail ne correspondent pas !";
                }
            }
            else {
                $erreur ="Votre addresse mail n'est pas valide !";
            }
            }
            else 
            {
                $erreur = "Votre pseudo ne doit pas dépasser 10 charactere";
            }
        }
        else 
        { //je stock l'erreur dans un variable (suite d operation et de condition)
            $erreur = "Tous les champs doivent être complet !";
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
        <h2>Inscription</h2>
        <br /><br />
        <form method="POST" action="">
            <table>
                <tr>
                    <td>
                        <label for="pseudo">Pseudo :</label>
                    </td>
                    <td>
                        <input type="text" placeholder="Votre pseudo" id="pseudo"  name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo;} ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mail">Mail :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail;} ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mail2">Conformation du mail :</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Confirmer votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2;} ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mdp">Mot de passe :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="mdp2">Confirmation du mdp :</label>
                    </td>
                    <td>
                        <input type="password" placeholder="conformer votre mdp" id="mdp2" name="mdp2"></input>
                    </td>
                </tr>
            </table>
            <br />
            <input type="submit" name="forminscription" value="Je m'inscrit !"></input>
        </form>
        <?php

         if(isset($erreur)) {
             echo $erreur;
         }

        ?>
</body>
</html>