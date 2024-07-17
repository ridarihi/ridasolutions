<?php
include('../inc/connect.php');
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}else {
    $user = $_SESSION['user'];

}

// Vérifier si l'utilisateur a cliqué sur le lien de déconnexion
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}
?>
<style>
    .navbar-brand {
        margin-right: 15px;
        /* Adjust as needed */
    }


    @media (max-width: 991.98px) {
        .dropdown-menu {
            right: auto !important;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container-fluid">
        <!-- Logo / Brand -->
        <a class="navbar-brand" href="#">
            <img src="../src/images/espaceadd.png" height="35" alt="Logo de RidaSolutions" loading="lazy" />
        </a>

        <!-- Navbar Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Items -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php"> <i class="bi bi-clipboard-data-fill text-primary"></i>  Tableau de bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ges-boutique.php"><i class="bi bi-cart-fill text-primary"></i>  Boutique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ges-user.php"><i class="bi bi-people-fill text-primary"></i> Users</a>
                </li>
               <!--  <li class="nav-item">
                    <a class="nav-link" href="ges-blog.php">blog</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="ges-commande.php"><i class="bi bi-bag-check-fill text-primary"></i> Commande</a>
                </li>
              <!--   <li class="nav-item">
                    <a class="nav-link" href="ges-chat.php">Équipe</a>
                </li> -->


            </ul>

            <!-- Right-aligned items -->
            <div class="d-flex align-items-center ms-auto">
                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../src/images/profils/<?= $user['profil_user']; ?>" class="rounded-circle" height="25" alt="Profile Picture" loading="lazy" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="home.php?action=logout">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>