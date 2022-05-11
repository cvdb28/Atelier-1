<?php 

/* connexion à la bdd */
@include 'config.php';

/* démarrage de la session employe */
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
    <title>À Propos</title>

    <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- lien css -->
    <link rel="stylesheet" href="css/aspect2.css"> 

</head>
<body>

<!-- lien header employé -->
<?php include 'header.php'; ?>

<!-- à propos de la M2L -->
<section class="about">

    <div class="row">

        <!-- premier box (droite) -->
        <div class="box">
            <img src="img/img1.png" alt="">
            <h3>Pourquoi nous choisir?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Adipisci, quam. Tenetur atque, commodi necessitatibus accusamus quis 
            obcaecati asperiores, nisi vel reiciendis nulla iure harum iste vero,
            aut molestiae. Odio, cum?</p>
            <a href="contact.php" class="btn">Nous contacter</a>
        </div>

        <!-- deuxième box (gauche) -->
        <div class="box">
            <img src="img/img2.jpg" alt="">
            <h3>Qu'est ce que l'on fait?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Adipisci, quam. Tenetur atque, commodi necessitatibus accusamus quis 
            obcaecati asperiores, nisi vel reiciendis nulla iure harum iste vero,
            aut molestiae. Odio, cum?</p>
            <a href="shop.php" class="btn">Notre magasin</a>
        </div>

    </div>

</section>

<!-- Témoignage -->
<section class="reviews">

    <h1 class="title">Avis des clients</h1>

    <div class="box-container">

        <div class="box">
            <img src="img/pic-1.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Consequatur placeat debitis consequuntur provident commodi 
            velit esse incidunt blanditiis ex corporis!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>John Deo</h3>
        </div>

        <div class="box">
            <img src="img/pic-2.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Consequatur placeat debitis consequuntur provident commodi 
            velit esse incidunt blanditiis ex corporis!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>John Deo</h3>
        </div>

        <div class="box">
            <img src="img/pic-3.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Consequatur placeat debitis consequuntur provident commodi 
            velit esse incidunt blanditiis ex corporis!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>John Deo</h3>
        </div>

        <div class="box">
            <img src="img/pic-4.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Consequatur placeat debitis consequuntur provident commodi 
            velit esse incidunt blanditiis ex corporis!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>John Deo</h3>
        </div>

        <div class="box">
            <img src="img/pic-5.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Consequatur placeat debitis consequuntur provident commodi 
            velit esse incidunt blanditiis ex corporis!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>John Deo</h3>
        </div>

        <div class="box">
            <img src="img/pic-6.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Consequatur placeat debitis consequuntur provident commodi 
            velit esse incidunt blanditiis ex corporis!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>John Deo</h3>
        </div>

    </div>

</section>

<!-- lien footer employé -->
<?php include 'emp_footer.php'; ?>

<!-- lien js -->
<script src="js/script.js"></script>

</body>
</html>