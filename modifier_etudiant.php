<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant</title>
</head>
    <body>
        <h1>Modification des données d'étudiant</h1>
        <?php
            //Connexion à la bd
            try{
                $bdd = new PDO("mysql:host=localhost;dbname=projet1_agence_marina;charset=utf8","root","", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e){
                die('Erreur : '.$e->getMessage());
            }

            if(!isset($_POST['rechercher']) || (isset($_POST['rechercher']) && empty($_POST['matricule']))){
                ?>
                <div><a href="index.php">Revenir à la page d'accueil</a></div><br>
                <form action="" method="POST">
                    <div>
                        <label for="matricule">Matricule de l'étudiant à modifier : </label>
                        <input type="number" name="matricule" id="matricule" required>
                    </div><br>
                    <div>
                        <input type="submit" name="rechercher" value="Rechercher l'étudiant à modifier">
                    </div>
                </form>
                <?php
                if(isset($_POST['rechercher']) && empty($_POST['matricule'])){
                    echo "<div style='color: red;'>Veuillez renseigner le champs !!!</div>";
                }
            }
            else{
                ?>
                <div><a href="modifier_etudiant.php">Revenir en arrière</a></div><br>
                <?php
                $matricule = htmlspecialchars($_POST['matricule']);
                $requete = $bdd->prepare("SELECT * FROM etudiants WHERE matricule = ?");
                $requete->execute(array($matricule));
                if($requete->rowCount() != 0){
                    $resultat = $requete->fetch();
                    ?>
                    <form action="" method="POST">
                        <div>
                            <label for="matricule">Matricule : </label>
                            <input type="number" name="matricule" value="<?php if(isset($resultat['matricule'])) echo $resultat['matricule']; ?>" id="matricule" required>
                        </div><br>
                        <div>
                            <label for="nom">Nouveau Nom : </label>
                            <input type="text" name="nom" id="nom" value="<?php if(isset($resultat['nom'])) echo $resultat['nom']; ?>" required>
                        </div><br>
                        <div>
                            <label for="prenom">Nouveau Prénom : </label>
                            <input type="text" name="prenom" id="prenom" value="<?php if(isset($resultat['prenom'])) echo $resultat['prenom']; ?>" required>
                        </div><br>
                        <div>
                            <label>Sexe : </label>
                            <input type="radio" name="sexe" id="masculin" value="M" <?php if($resultat['sexe']=="M") echo "checked"; ?> required>
                            <label for="masculin">Masculin</label>
                            <input type="radio" name="sexe" id="feminin"  value="F" <?php if($resultat['sexe']=="F") echo "checked"; ?> required>
                            <label for="feminin">Féminin</label>
                        </div><br>
                        <div>
                            <label for="date_naissance">Nouvelle Date de naissance : </label>
                            <input type="date" name="date_naissance" id="date_naissance" value="<?php if(isset($resultat['date_naissance'])) echo $resultat['date_naissance']; ?>" required>
                        </div><br>
                        <div>
                            <label for="sexe">Nouveau Télephone : </label>
                            <input type="tel" name="tel" id="tel" value="<?php if(isset($resultat['tel'])) echo $resultat['tel']; ?>" required>
                        </div><br>
                        <div><input type="submit" name="sauvegarder" Value="Sauvegarder les modifications"></div>
                    </form>
                <?php
                }
                else{
                    echo "<div style='color: red;'>Etudiant introuvable !!!</div>";
                }
            }
            //Sauvegarde des modifications
            if(isset($_POST['sauvegarder'])){
                if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['sexe']) && !empty($_POST['date_naissance']) && !empty($_POST['tel'])){
                    $matricule = htmlspecialchars($_POST['matricule']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $sexe = htmlspecialchars($_POST['sexe']);
                    $date_naissance = htmlspecialchars($_POST['date_naissance']);
                    $tel = htmlspecialchars($_POST['tel']);
                    //Préparation de la requête d'insertion
                    $requete = $bdd->prepare("UPDATE etudiants SET nom = ?, prenom = ?, sexe = ?, date_naissance = ?, tel = ? WHERE matricule = ?");
                    //Passages des paramètres à la requête
                    try{
                        $resultat = $requete->execute(array($nom,$prenom,$sexe,$date_naissance,$tel,$matricule));
                        if($resultat){
                            echo "<div style='color: green;'>L'étudiant ".$nom." ".$prenom." a été modifié.</div>";
                        }
                    }
                    catch(Exception $e){
                        echo "<div style='color: red;'>Modification impossible !!!</div>";
                    }
                }
                else{
                    echo "<div style='color: red;'>Modification échouée, vous n'avez pas rempli tous les champs !!!</div>";
                }
            }
        ?>
    </body>
</html>