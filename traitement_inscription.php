<?php

try 
{
    $connexion = new PDO('mysql:host=127.0.0.1;dbname=users_db', 'root', '');
    echo 'Connection a la base de donnée Users reussi!!';
} catch (PDOException $e) {
    echo 'Échec de la connexion : ' . $e->getMessage();
}

if(isset($_POST['valider']))
{
    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $email = htmlspecialchars($_POST['email']);
        $telephone = htmlspecialchars($_POST['telephone']);
        // $telephone = isset($_POST['telephone']) ? htmlspecialchars($_POST['telephone']) : null;
        $mdp = sha1($_POST['password']);

        if(strlen($_POST['password']) < 7){
            $message = "votre mot de passe est trop court. ";
        } elseif(strlen($nom)>30 || strlen($prenom)>30){
            $message = "nom ou prenom tres long";
        }else{
            $testmail = $connexion->prepare("SELECT * FROM users WHERE email = ?");
            $testmail->execute(array($email));
            
            $controlemailsdupli = $testmail->rowCount();
            if ($controlemailsdupli==0){

            $insertion = $connexion->prepare("INSERT INTO users(nom, prenom, email, telephone, password) VALUES(?,?,?,?,?)");
            $insertion->execute((array($nom, $prenom, $email, $telephone, $mdp)));
            // $insertion->execute([$nom, $prenom, $email, $telephone, $mdp]);
            $message = "votre compte a bien ete créé";
            }else{
                $message = "Cette adresse a deja un compte";
            }
        }


    }else{
        $message = "tout les chapms doivent etre remplir";
    }
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Connexion et inscription </title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/bootstrap.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/all.min.css'>
   
</head>
<body class="bg-light">
    <div class="container ">
        <div class="row mt-5">
            <div class="col-lg-4 bg-white m-auto rounded-top">
                <h2 class="text-center"> Inscription</h2>
                <p class="text-center text-muted lead"> Simple et Rapide </p>

                <form method="POST" action="">
                    <div class="input-group  mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-user">
                            </i> 
                        </span>
                        <input type="text" name="nom" class="form-control" placeholder="Nom ">
                    </div>
                    <div class="input-group  mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-user">
                            </i> 
                        </span>
                        <input type="text" name="prenom" class="form-control" placeholder="Prénom ">
                    </div>
                    <div class="input-group  mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-envelope">
                            </i> 
                        </span>
                        <input type="email" name="email" class="form-control" placeholder="Email ">
                    </div>
                    <div class="input-group  mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-phone">
                            </i> 
                        </span>
                        <input type="text" name="telephone" class="form-control" placeholder="telephone ">
                    </div>
                    <div class="input-group  mb-3">
                        <span class="input-group-text">
                            <i class="fa fa-lock">
                            </i> 
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe ">
                    </div>
                    <div class="d-grid">
                        <button type="buton" name="valider" class="btn btn-success theo2">S’inscrire</button>
                        <p class="text-center text-muted mt-3">
                            <i style="color:red">
                            <?php
                                if(isset($message)){
                                    echo $message."<br/>";
                                }
                            ?>
                            </i>
                            En cliquant sur S’inscrire, vous acceptez nos <a href="#">  Conditions générales</a>, notre <a href=""> Politique de confidentialité </a> et notre <a href="#">  Politique d’utilisation</a> des cookies. 
                        </p>
                        <p class="text-center">
                             Avez vous déjà un compte ?<a href="connexion.html"> Connexion </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>
    </div>
    
</body>
</html> 
<script src='js/bootstrap.js'></script>