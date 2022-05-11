<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrage de la session employé */
session_start();

$user_id = $_SESSION['user_id'];

/* redirection */
if (!isset($user_id)) {
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
    <title>Aperçu Rapide</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/aspect2.css"> 

</head>
<body>

<!-- lien header user -->
<?php include 'header.php'; ?>

<!-- page pour un aperçu rapide -->
<section class="quick-view">

    <h1 class="title">Aperçu rapide</h1>

    <?php
        /* on sélectionne la tâche */
        $pid = $_GET['pid'];
        $select_products = $conn->prepare("SELECT * FROM `taches` WHERE id = ?");
        $select_products->execute([$pid]);
        if ($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <!-- box pour voir les éléments constituant la tâche qu'on a décidé d'observer -->
    <div class="box">
            <div class="price"><?= $fetch_products['priorite']; ?></div>
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class="cat"><?= $fetch_products['date_debut']; ?> - <?= $fetch_products['date_fin']; ?></div>
            <div class="etat"><?= $fetch_products['etat']; ?></div>
            <div class="name"><?= $fetch_products['assigne']; ?></div>
            <div class="details"><?= $fetch_products['details']; ?></div>
        </div>
    <?php
            }
        }else{
            echo '<p class="empty">aucun produit ajouté pour le moment!</p>';
        }
    ?>

</section>

<!-- lien footer employé -->
<?php include 'footer.php'; ?>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>