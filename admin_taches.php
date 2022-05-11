<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrer la session admin */
session_start();

$admin_id = $_SESSION['admin_id'];

/* redirection */
if (!isset($admin_id)) {
    header('location:login.php');
};

/* ajout de tâche */
if (isset($_POST['add_product'])) {
    
    /*on déclare les variables */
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $date_fin = $_POST['date_fin'];
    $date_fin = filter_var($date_fin, FILTER_SANITIZE_STRING);
    $etat = $_POST['etat'];
    $etat = filter_var($etat, FILTER_SANITIZE_STRING);
    $priorite = $_POST['priorite'];
    $priorite = filter_var($priorite, FILTER_SANITIZE_STRING);
    $date_debut = $_POST['date_debut'];
    $date_debut = filter_var($date_debut, FILTER_SANITIZE_STRING);
    $assigne = $_POST['assigne'];
    $assigne = filter_var($assigne, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
   
    /* on sélectionne la tache */
    $select_product = $conn->prepare("SELECT * FROM `taches` WHERE name =?");
    $select_product->execute([$name]);

    if($select_product->rowCount() > 0){
        $message[] = 'Le nom de la tâche existe déjà!';
    }else{

        /* on insère la tâche dans la bdd */
        $insert_products = $conn->prepare("INSERT INTO `taches` (name, date_debut, date_fin, etat, priorite, assigne, details) VALUES(?,?,?,?,?,?,?)");
        $insert_products->execute([$name, $date_debut, $date_fin, $etat, $priorite, $assigne, $details]);
        
        $message[] = 'Nouvelle tâche ajoutée!';
        
    }

};

/* on supprime la tâche */
if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];
    $delete_products = $conn->prepare("DELETE FROM `taches` WHERE id = ?");
    $delete_products->execute([$delete_id]);
    header('location:admin_taches.php');

}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taches</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/resp_style1.css">   

</head>
<body>

<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<!-- section ajout de tâches -->
<section class="add-products">

    <h1 class="title">Ajouter de nouvelles Tâches</h1>

    <!-- formulaire de création de tâche -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
            <!-- première colonne -->
            <div class="inputBox">
                <input type="text" name="name" class="box" required placeholder="Entrer le nom de la tâche">
                <input type="date" name="date_debut" class="box" value="2022-05-01" min="2021-01-01" max="2050-01-01"> 
                <select name="etat" class="box" required>
                    <option value="" select disabled>Choisir un état</option>
                        <option value="Non assigné">Non assigné</option>
                        <option value="En cours">En cours</option>
                        <option value="En attente">En attente</option>
                        <option value="Terminé">Terminé</option>
                </select>
            </div>

            <!-- deuxième colonne -->
            <div class="inputBox">
                <select name="priorite" class="box" required>
                    <option value="" select disabled>Choisir une priorité</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                </select>
                <input type="date" name="date_fin" class="box" value="2022-05-01" min="2021-01-01" max="2050-01-01">  
                <select name="assigne" class="box" required>
                    <?php
                        $catch_id = $conn->prepare("SELECT * FROM `users` WHERE user_type = 'employe'");
                        $catch_id->execute();
                        if($catch_id->rowCount() > 0){
                            while($fetch_id = $catch_id->fetch(PDO::FETCH_ASSOC)){
                                echo '<option value="'.$fetch_id['id'].'">'.$fetch_id['name'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            
        </div>
        <textarea name="details" class="box" required placeholder="Entrer les détails de la tâche" cols="30" rows="10"></textarea>
        <!-- bouton d'ajout -->
        <input type="submit" class="btn" value="Ajouter une Tâche" name="add_product">
    </form>

</section>

<!-- section pour montrer les tâches créées -->
<section class="show-products">

    <h1 class="title">Tâches Ajoutées</h1>

    <div class="box-container">

    <?php
        /* on sélectionne toutes les tâches */ 
        $show_products = $conn->prepare("SELECT * FROM `taches`");
        $show_products->execute();
        if($show_products->rowCount() > 0){
            while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <!-- création de box regroupant tous les éléments constituants une tâche -->
    <div class="box">
        <div class="price"><?= $fetch_products['priorite']; ?></div>
        <div class="name"><?= $fetch_products['name']; ?></div>
        <div class="cat"><?= $fetch_products['date_debut']; ?> - <?= $fetch_products['date_fin']; ?></div>
        <div class="etat"><?= $fetch_products['etat']; ?></div>
        <div class="name"><?= $fetch_products['assigne']; ?></div>
        <div class="details"><?= $fetch_products['details']; ?></div>
        <!-- boutons modifier et supprimer -->
        <div class="flex-btn">
            <a href="admin_update_taches.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Mettre à jour</a>
            <a href="admin_taches.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Supprimer cette Tâche?');">Supprimer</a>
        </div>
    </div>
    <?php
            }
        }else{
            echo '<p class="empty">Maintenant, ajouter encore des tâches!</p>';
        }
    ?>

    </div>

</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>