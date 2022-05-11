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

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Recherche</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/resp_style1.css"> 

</head>
<body>
    
<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<!-- formulaire de recherche -->
<section class="search-form">

    <form action="" method="POST">
        <input type="text" class="box" name="search_box" placeholder="Recherche en fonction de l'état...">
        <input type="submit" name="search_btn" value="search" class="btn">
    </form>

</section>

<?php

if(isset($_POST['search_btn'])){

?>

<!-- Affichage des tâches recherchées -->
<section class="show-products" style="padding-top: 0;">

    <h1 class="title">Anciennes Tâches</h1>

    <div class="box-container">

        <?php
            $search_box = $_POST['search_box'];
            $search_box = filter_var($search_box, FILTER_SANITIZE_STRING);
            $select_products = $conn->prepare("SELECT * FROM `taches` WHERE etat LIKE '%{$search_box}%'");
            $select_products->execute();
            if ($select_products->rowCount() > 0){
                while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>
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
                echo '<p class="empty">Aucun résultat trouvé!</p>';
            }
        ?>

    </div>

</section>

<?php

};

?>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>