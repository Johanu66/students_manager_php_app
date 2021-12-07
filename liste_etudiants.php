<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, tr, th, td{
            border: 1px solid black;
        }
    </style>
</head>
    <body>
        <h1>Liste de tous les étudiants</h1>
        <div><a href="index.php">Revenir à la page d'accueil</a></div><br>
        <?php
            //Connexion à la bd
            try{
                $bdd = new PDO("mysql:host=localhost;dbname=projet1_agence_marina;charset=utf8","root","", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e){
                die('Erreur : '.$e->getMessage());
            }
            //Requête de selection de tous les étudiants
            $requete = $bdd->query("SELECT * FROM etudiants");
        ?>
        <table>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénoms</th>
                <th>Sexe</th>
                <th>Date de naissance</th>
                <th>Télephone</th>
            </tr>
            <?php
                while($resultat = $requete->fetch()){
                    ?>
                    <tr>
                        <td><?php echo $resultat['matricule']; ?></td>
                        <td><?php echo $resultat['nom']; ?></td>
                        <td><?php echo $resultat['prenom']; ?></td>
                        <td><?php echo $resultat['sexe']; ?></td>
                        <td><?php echo $resultat['date_naissance']; ?></td>
                        <td><?php echo $resultat['tel']; ?></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
            
    </body>
</html>