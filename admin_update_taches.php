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

/* modification de la tâche sélectionnée */
if(isset($_POST['update_product'])){

    /*on déclare les variables */
    $pid = $_POST['pid'];
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

    /* on met à jour la tâche dans la bdd */
    $update_product = $conn->prepare("UPDATE `taches` SET name = ?, date_debut = ?, date_fin = ?, etat = ?, priorite = ?, assigne = ?, details = ? WHERE id = ?");
    $update_product->execute([$name, $date_debut, $date_fin, $etat, $priorite, $assigne, $details, $pid]);

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
    <link rel="stylesheet" href="css/resp_style1.css">   

</head>
<body>
    
<!-- lien header admin -->
<?php include 'admin_header.php'; ?>

<!-- page pour modifier les élements d'une tâche -->
<section class="update-products">

    <h1 class="title">Mettre à jour la Tâche</h1>

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
        <input type="text" name="name" class="box" value="<?= $fetch_products['name']; ?>" required placeholder="Entrer le nom de la tâche">
        <input type="date" name="date_debut" class="box" value="<?= $fetch_products['date_debut']; ?>" min="2021-01-01" max="2050-01-01">
        <input type="date" name="date_fin" class="box" value="<?= $fetch_products['date_fin']; ?>" min="2021-01-01" max="2050-01-01">
        <select name="etat" class="box" required>
            <option value="<?= $fetch_products['etat']; ?>" select disabled>Choisir un état</option>
                <option value="Non assigné">Non assigné</option>
                <option value="En cours">En cours</option>
                <option value="En attente">En attente</option>
                <option value="Terminé">Terminé</option>
        </select>
        <select name="priorite" class="box" required>
            <option value="<?= $fetch_products['priorite']; ?>" select disabled>Choisir une priorité</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
        </select>
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
        <textarea name="details" required placeholder="Entrer les détails du produit" class="box" cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
        
        <!-- Boutons revenir en arrière - modifier -->
        <input type="submit" class="btn" value="Mettre à jour le produit" name="update_product">
        <a href="admin_taches.php" class="option-btn">Revenir en arrière</a>

    </form>
    <?php
            }
        }else{
            echo '<p class="empty">Aucun produit trouvé!</p>';
        }
    ?>

</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>