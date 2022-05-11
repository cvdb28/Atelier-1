<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrer la session employé */
session_start();

$employe_id = $_SESSION['employe_id'];

/* redirection */
if (!isset($employe_id)) {
    header('location:login.php');
};

/* modification de la tâche sélectionnée */
if(isset($_POST['update_product'])){

    /*on déclare les variables */
    $pid = $_POST['pid'];
    $etat = $_POST['etat'];
    $etat = filter_var($etat, FILTER_SANITIZE_STRING);

    /* on met à jour la tâche dans la bdd */
    $update_product = $conn->prepare("UPDATE `taches` SET etat = ? WHERE id = ?");
    $update_product->execute([$etat, $pid]);

    $message[] = 'Tâche mis à jour avec succès!';

}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour les produits</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/aspect2.css">   

</head>
<body>
    
<!-- lien header employé -->
<?php include 'emp_header.php'; ?>

<!-- page pour modifier les élements d'une tâche -->
<section class="update-products">

    <h1 class="title">Mettre à jour l'état</h1>

    <?php
        /* sélection de la tâche pour modification */
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `taches` WHERE id = ?");
        $select_products->execute([$update_id]);
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <!-- formulaire de modification contenant les éléments enregistrés de base dans la bdd -->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
        <select name="etat" class="box" required>
            <option value="<?= $fetch_products['etat']; ?>" select disabled>Choisir un état</option>
                <option value="Non assigné">Non assigné</option>
                <option value="En cours">En cours</option>
                <option value="En attente">En attente</option>
                <option value="Terminé">Terminé</option>
        </select>
        
        <!-- Boutons revenir en arrière - modifier -->
        <input type="submit" class="btn" value="Mettre à jour l'état" name="update_product">
        <a href="emp_taches.php" class="option-btn">Revenir en arrière</a>

    </form>
    <?php
            }
        }else{
            echo '<p class="empty">Aucun produit trouvé!</p>';
        }
    ?>

</section>

<!-- lien footer employé -->
<?php include 'emp_footer.php'; ?>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>