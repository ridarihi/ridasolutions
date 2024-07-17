<style>

</style>
<?php
ob_start();
session_start();

$title = 'Se connecter';
include('inc-app/debut-app.php');
include('../inc/connect.php');

?>
<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .espace-add {
        height: 35px;
        /* Par défaut pour les écrans de taille >= 768px */
    }

    /* Media queries pour rendre les éléments responsives */
    @media (max-width: 768px) {
        .espace-add {
            height: 20px;
        }
    }

    @media (max-width: 480px) {
        .espace-add {
            height: 20px;
        }
  

    }
</style>

<div class="container mb-3 pt-5 mt-4">
    <div class="row">
        <div class="col">

            <!--
 ***********************************************
***********la section Se connecter ***************
************************************************
-->
            <?php if ((!isset($_GET['action']))) {
                if (isset($_SESSION['err'])) {
                    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['err'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                    unset($_SESSION['err']);
                } ?>
                <div class="container vh-100 d-flex justify-content-center align-items-center">
                    <div class="row w-75 justify-content-center">
                        <div class="wrapper">
                            <div class="logo text-center">
                                <img src="../src/images/brand2.png" alt="" class="img-fluid">
                            </div>
                            <div class="text-center mt-4 name">
                                <!--                             <span class=" text-dark">Espace</span>           <span class=" text-primary">Administrateur</span>
 -->

                                <img src="../src/images/name.png" alt="" class="espace-add">
                            </div>
                            <form action="index.php?action=connecter" method="POST" class="p-3 mt-3">
                                <div class="form-field d-flex align-items-center mb-3">
                                    <span class="far fa-user"></span>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-field d-flex align-items-center mb-3">
                                    <span class="fas fa-key"></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                            </form>

                        </div>
                    </div>
                </div>

            <?php } else if ((isset($_GET['action']) && $_GET['action'] == "connecter")) {
                if (empty($_POST['email']) || empty($_POST['password'])) {
                    $_SESSION['err'] = 'Email et mot de passe sont obligatoires!';
                    header('Location: index.php?');
                    exit();
                } else {

                    $params = [$_POST['email']];
                    $req = "SELECT * FROM users WHERE email_user = ?";
                    $userObj = $db->prepare($req);
                    $userObj->execute($params);

                    $user = $userObj->fetch();

                    if ($_POST['password'] != $user['password_user']) {
                        $_SESSION['err'] = 'Mot de passe ou login incorrect!';
                        header('Location: index.php');
                        exit();
                    } else {
                        $_SESSION['user'] = [
                            'id_user' => $userId,
                            'email_user' => $userEmail,
                            'profil_user' => $userProfil,
                            'role_user' => $userRole
                        ];
                        // User is authenticated, redirect to profile
                        $_SESSION['user'] = $user; // Assuming you want to store user information in session
                        header('Location: home.php');
                        exit();
                    }
                }
            }
            ?>
            <!--
 ***********************************************
***********la section autres ***************
************************************************
-->
        </div>
    </div>

</div>
<?php

include('inc-app/fin-app.php');
ob_end_flush();
?>