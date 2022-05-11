<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrage de la sesion employé */
session_start();

$employe_id = $_SESSION['employe_id'];

/* redirection */
if (!isset($employe_id)) {
    header('location:login.php');
};

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
    <link rel="stylesheet" href="css/aspect2.css">   

</head>
<body>

<!-- lien header employé -->
<?php include 'emp_header.php'; ?>

<!-- section pour montrer les tâches -->
<section class="show-products">

    <h1 class="title">Tâches Ajoutées</h1>

    <div class="box-container">

    <?php 
        /* on sélectionne toutes les tâches */ 
        $show_products = $conn->prepare("SELECT * FROM `taches` WHERE assigne = $employe_id");
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
        <!-- boutons modifier -->
        <div class="flex-btn">
            <a href="emp_update_taches.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Modifier l'état</a>
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

<!-- lien footer employé -->
<?php include 'emp_footer.php'; ?>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>