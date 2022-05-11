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

/* modifier le profil employé */
if(isset($_POST['update_profile'])){

    /* déclarer les variables */
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    /* mis à jour du profil */
    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $employe_id]);

    /* image */
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
    $old_image = $_POST['old_image'];

    /* conditions image */
    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'La taille de cette image est trop grande!';
        }else{
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $employe_id]);
            if($update_image){
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('uploaded_img/'.$old_image);
                $message[] = 'Image mise à jour avec succès!';
            };
        };
    };

    /* mettre à jour le mot de passe */
    $old_pass = $_POST['old_pass'];
    $update_pass = md5($_POST['update_pass']);
    $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
    $new_pass = md5($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = md5($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    /* conditions mot de passe */
    if(!empty($update_pass) OR !empty($new_pass) OR !empty($confirm_pass)){
        if($update_pass != $old_pass){
            $message[] = 'Cet ancien mot de passe ne correspond pas!';
        }elseif($new_pass != $confirm_pass){
            $message[] = 'Confirmer que le mot de passe ne correspond pas!';
        }else{
            $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_pass_query->execute([$confirm_pass, $user_id]);
            $message[] = 'Mot de passe mise à jour avec succès!';
        }
    }

}

?>

<!-- PAGE HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à Jour le Profil Utilisateur</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/aspect2.css">   

</head>
<body>
    
<!-- lien header employé -->
<?php include 'emp_header.php'; ?>

<!-- page pour modifier le profile de l'employé connecté -->
<section class="update-profile">

    <h1 class="title">Mettre à jour le Profil</h1>

    <!-- formulaire de modification -->
    <form action="" method="POST" enctype="multipart/form-data">
        <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
        <div class="flex">

            <!-- première colonne -->
            <div class="inputBox">
                <span>Nom d'utilisateur : </span>
                <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="Mettre à jour le nom d'utilisateur" required class="box">
                <span>Adresse mail : </span>
                <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="Mettre à jour l'adresse mail" required class="box">
                <span>Mettre à jour la photo : </span>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
                <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
            </div>

            <!-- deuxième colonne -->
            <div class="inputBox">
                <input type="hidden" name="old_pass" value="<?= $fetch_profile['password']; ?>">
                <span>Ancien mot de passe : </span>
                <input type="password" name="update_pass" placeholder="Entrer le précédent mot de passe" class="box">
                <span>Nouveau mot de passe : </span>
                <input type="password" name="new_pass" placeholder="Entrer le nouveau mot de passe" class="box">
                <span>Confirmer le mot de passe : </span>
                <input type="password" name="confirm_pass" placeholder="Confirmer le nouveau mot de passe précédent" class="box">
            </div>
        </div>
        <!-- boutons maj et revenir en arrière -->
        <div class="flex-btn">
            <input type="submit" class="btn" value="Mettre à jour le profil" name="update_profile">
            <a href="emp_home.php" class="option-btn">Revenir en Arrière</a>
        </div>
    </form>

</section>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>