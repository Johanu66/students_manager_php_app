<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un étudiant</title>
</head>
    <body>
        <h1>Suppression d'étudiant</h1>
        <div><a href="index.php">Revenir à la page d'accueil</a></div><br>
        <form action="" method="POST">
            <div>
                <label for="matricule">Matricule de l'étudiant à supprimer : </label>
                <input type="number" name="matricule" id="matricule" value="<?php if(isset($_POST['matricule'])) echo($_POST['matricule']); ?>" required>
            </div>
            <input type="submit" name="supprimer" value="Supprimer">
        </form>
        <?php
            if(isset($_POST['supprimer'])){
                if(!empty($_POST['matricule'])){
                    $matricule = htmlspecialchars($_POST['matricule']);
                    //Connexion à la bd
                    try{
                        $bdd = new PDO("mysql:host=localhost;dbname=projet1_agence_marina;charset=utf8","root","", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    }
                    catch(Exception $e){
                        die('Erreur : '.$e->getMessage());
                    }
                    //Requête pour supprimer l'étudiant
                    $requete = $bdd->prepare("DELETE FROM etudiants WHERE matricule = ?");
                    $requete->execute(array($matricule));
                    if($requete->rowCount() == 0){
                        echo "<div style='color: red;'>Cet étudiant n'existe pas dans la base de données.</div>";
                    }
                    else{
                        echo "<div style='color: green;'>L'étudiant a été supprimé.</div>";
                    }
                }
                else{
                    echo "<div style='color: red;'>Veuillez renseigner le champs !!!</div>";
                }
            }
        ?>
    </body>
</html>