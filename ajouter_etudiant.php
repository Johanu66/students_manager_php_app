<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant</title>
</head>
    <body>
        <h1>Ajout d'étudiant</h1>
        <div><a href="index.php">Revenir à la page d'accueil</a></div><br>
        <form action="" method="POST">
            <div>
                <label for="matricule">Matricule : </label>
                <input type="number" name="matricule" id="matricule" value="<?php if(isset($_POST['matricule'])) echo($_POST['matricule']); ?>" required>
            </div><br>
            <div>
                <label for="nom">Nom : </label>
                <input type="text" name="nom" id="nom" value="<?php if(isset($_POST['nom'])) echo($_POST['nom']); ?>" required>
            </div><br>
            <div>
                <label for="prenom">Prénom : </label>
                <input type="text" name="prenom" id="prenom" value="<?php if(isset($_POST['prenom'])) echo($_POST['prenom']); ?>" required>
            </div><br>
            <div>
                <label>Sexe : </label>
                <input type="radio" name="sexe" id="masculin" value="M" required>
                <label for="masculin">Masculin</label>
                <input type="radio" name="sexe" id="feminin"  value="F" required>
                <label for="feminin">Féminin</label>
            </div><br>
            <div>
                <label for="date_naissance">Date de naissance : </label>
                <input type="date" name="date_naissance" id="date_naissance" value="<?php if(isset($_POST['date_naissance'])) echo($_POST['date_naissance']); ?>" required>
            </div><br>
            <div>
                <label for="sexe">Télephone : </label>
                <input type="tel" name="tel" id="tel" value="<?php if(isset($_POST['tel'])) echo($_POST['tel']); ?>" required>
            </div><br>
            <div><input type="submit" name="ajouter" Value="Ajouter"></div>
        </form>
        <?php
            if(isset($_POST['ajouter'])){
                if(!empty($_POST['matricule']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['sexe']) && !empty($_POST['date_naissance']) && !empty($_POST['tel'])){
                    $matricule = htmlspecialchars($_POST['matricule']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $sexe = htmlspecialchars($_POST['sexe']);
                    $date_naissance = htmlspecialchars($_POST['date_naissance']);
                    $tel = htmlspecialchars($_POST['tel']);
                    //Connexion à la bd
                    try{
                        $bdd = new PDO("mysql:host=localhost;dbname=projet1_agence_marina;charset=utf8","root","", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    }
                    catch(Exception $e){
                        die('Erreur : '.$e->getMessage());
                    }
                    //Préparation de la requête d'insertion
                    $requete = $bdd->prepare("INSERT INTO etudiants VALUES (?,?,?,?,?,?)");
                    //Passages des paramètres à la requête
                    try{
                        $resultat = $requete->execute(array($matricule,$nom,$prenom,$sexe,$date_naissance,$tel));
                        if($resultat){
                            echo "<div style='color: green;'>L'étudiant ".$nom." ".$prenom." a été enregistré.</div>";
                        }
                    }
                    catch(Exception $e){
                        echo "<div style='color: red;'>Ajout impossible !!!</div>";
                    }
                }
                else{
                    echo "<div style='color: red;'>Veuillez renseigner tous les champs !!!</div>";
                }
            }
        ?>
    </body>
</html>