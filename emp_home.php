<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrage session employé */
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
    <title>Page d'Accueil</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/aspect2.css"> 

</head>
<body>

<!-- lien header employé -->
<?php include 'emp_header.php'; ?>

<div class="home-bg">

    <section class="home">

        <div class="content">
            <span>Pas de panique, créez votre tâche !</span>
            <h3>Atteindre de vrais objectifs rapidement avec la Maison des Ligues de Lorraine</h3>
            <p>Réalisation et mise en place de la gestion des travaux informatisés.</p>
            <a href="about.php" class="btn">À propos de nous</a>
        </div>

    </section>

</div>

<!-- section montrant les différentes tâches -->
<section class="show-products">

    <h1 class="title">Dernières Tâches Ajoutées</h1>

    <div class="box-container">

        <?php
            /* on sélectionne les tâches et on en fait apparaître que 6 sur la page */
            $select_products = $conn->prepare("SELECT * FROM `taches` WHERE assigne = $employe_id LIMIT 6");
            $select_products->execute();
            if ($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
        <!-- box détaillant les éléments dans les tâches -->
        <div class="box">
            <div class="price"><?= $fetch_products['priorite']; ?></div>
            <a href="emp_view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class="cat"><?= $fetch_products['date_debut']; ?> - <?= $fetch_products['date_fin']; ?></div>
            <div class="etat"><?= $fetch_products['etat']; ?></div>
            <div class="name"><?= $fetch_products['assigne']; ?></div>
            <div class="details"><?= $fetch_products['details']; ?></div>
            <div class="flex-btn">
                <a href="emp_update_taches.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Modifier l'état</a>
            </div>
        </div>
        <?php
                }
            }else{
                echo '<p class="empty">aucune tâche ajoutée pour le moment!</p>';
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