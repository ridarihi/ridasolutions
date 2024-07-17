<style>
    .box-inscription {
        background-color: #ecf0f3;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
    }


    .box-inscription .form-group {
        margin-bottom: 20px;
        margin-top: 10px;
    }

    .box-inscription .form-control {
        border-radius: 10px;
        padding: 10px;
    }

    .box-inscription .btn {
        border-radius: 20px;
        box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.2);
    }

    .box-inscription .btn:hover {
        opacity: 0.9;
    }

    .compte a {
        text-decoration: none;
        font-size: 0.8rem;
        color: #03A9F4;
    }


    .wrapper {
        max-width: 50px;
        min-height: 300px;
        margin: 80px auto;
        padding: 40px 30px 30px 30px;
        background-color: #ecf0f3;
        border-radius: 15px;
        box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;
    }

    .logo {
        width: 80px;
        margin: auto;
    }

    .logo img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0px 0px 3px #5f5f5f,
            0px 0px 0px 5px #ecf0f3,
            8px 8px 15px #a7aaa7,
            -8px -8px 15px #fff;
    }

    .name {
        font-weight: 600;
        font-size: 1.4rem;
        letter-spacing: 1.3px;
        padding-left: 10px;
        color: #555;
    }

    .wrapper .form-field input {
        width: 100%;
        display: block;
        border: none;
        outline: none;
        background: none;
        font-size: 1.2rem;
        color: #666;
        padding: 10px 15px 10px 10px;
        /* border: 1px solid red; */
    }

    .wrapper .form-field {
        padding-left: 10px;
        margin-bottom: 20px;
        border-radius: 20px;
        box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
    }

    .form-field .fas {
        color: #555;
    }

    .wrapper .btn {
        box-shadow: none;
        width: 100%;
        height: 40px;
        background-color: #03A9F4;
        color: #fff;
        border-radius: 25px;
        box-shadow: 3px 3px 3px #b1b1b1,
            -3px -3px 3px #fff;
        letter-spacing: 1.3px;
    }

    .wrapper .btn:hover {
        background-color: #039BE5;
    }

    .wrapper a,
    .compte a {
        text-decoration: none;
        font-size: 0.8rem;
        color: #03A9F4;
    }

    .wrapper a:hover {
        color: #039BE5;
    }

    .showPs,
    .showPsCn {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
    }

    @media(max-width: 380px) {
        .wrapper {
            margin: 30px 20px;
            padding: 40px 15px 15px 15px;
        }
    }
</style>
<?php
ob_start();
session_start();
include('inc/connect.php');
$title = (isset($_GET['action']) && $_GET['action'] === "seConnecter") ? 'Se connecter' : "S'inscrire";
include('inc/debut.php');
include('inc/header.php');
?>
<div class="container mb-3 pt-5 mt-4">
    <div class="row">
        <div class="col">

            <!--
 ***********************************************
***********la section S'inscrire ***************
************************************************
-->
            <?php
            if (isset($_GET['action']) && $_GET['action'] == "SInscrire") { ?>
            <?php if (isset($_SESSION['err'])) {
                    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['err'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                    unset($_SESSION['err']);
                } ?>
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="box-inscription">
                                <div class="logo text-center">
                                    <img src="src/images/brand2.psd" alt="" class="img-fluid">
                                </div>
                                <div class="text-center mt-4 name">
                                    Rida Solutions
                                </div>
                                <form action="home.php?action=inscription" method="POST" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col">
                                            <input type="file" name="profil" id="profil" class="form-control" placeholder="Profil">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prénom" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <input type="date" name="date" id="date" class="form-control" placeholder="Date de naissance" required>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="genre" id="genre" class="form-control" required>
                                                <option selected disabled value="">Sélectionnez votre genre</option>
                                                <option value="homme">Homme</option>
                                                <option value="femme">Femme</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" minlength="7" required>
                                    </div>
                                    <div class="showPs" id="togglePassword"><i class="bi bi-eye-fill p-2 iconPass"></i> Affiche le mode passe</div>
                                    <div class="form-group">
                                        <input type="password" name="pwdConf" id="pwdConf" class="form-control" placeholder="Confirmation mot de passe" minlength="7" required>
                                    </div>
                                    <div class="showPsCn" id="togglePasswordCn">
                                        <i class="bi bi-eye-fill p-2 iconPassCn"></i> Affiche le mot de passe de Confirmation
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success m-2 p-2 w-25" name="submit">Créer</button>
                                    </div>
                                </form>
                                <div class="text-center fs-6 mt-3 compte">
                                    <a href="home.php?action=seConnecter">j'ai déjà compte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
 ***********************************************
***********la section Se connecter ***************
************************************************
-->
            <?php } else if ((isset($_GET['action']) && $_GET['action'] == "seConnecter")) {
                if (isset($_SESSION['err'])) {
                    echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['err'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                    unset($_SESSION['err']);
                } ?>
                <?php if (isset($_SESSION['succ'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fa-solid fa-triangle-exclamation text-danger" ></i></strong> ' . $_SESSION['succ'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
                    unset($_SESSION['succ']);
                } ?>
                <div class="container vh-100 d-flex justify-content-center align-items-center">
                    <div class="row w-75 justify-content-center">
                        <div class="wrapper">
                            <div class="logo text-center">
                                <img src="src/images/brand2.psd" alt="" class="img-fluid">
                            </div>
                            <div class="text-center mt-4 name">
                                Rida Solutions
                            </div>
                            <form action="home.php?action=connecter" method="POST" class="p-3 mt-3">
                                <div class="form-field d-flex align-items-center mb-3">
                                    <span class="far fa-user"></span>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-field d-flex align-items-center mb-3">
                                    <span class="fas fa-key"></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                                </div>
                                <div class="showPs" id="togglePassword"><i class="bi bi-eye-fill p-2 iconPass"></i> affiche le mode passe</div> <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
                            </form>
                            <div class="text-center fs-6 mt-3">
                                <a href="#">Mot de passe oublié?</a> Ou <a href="home.php?action=SInscrire">Créer un compte</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
 ***********************************************
***********la section inscrption ***************
************************************************
-->
            <?php  } else if ((isset($_GET['action']) && $_GET['action'] == "inscription")) {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profil"])) {
                    $target_dir = "src/images/profils/";
                    $target_file = $target_dir . $_FILES["profil"]["name"];
                    // Vérification de l'upload de l'image
                    if (move_uploaded_file($_FILES["profil"]["tmp_name"], $target_file)) {
                        // Enregistrement du chemin de l'image dans la base de données
                        $nom_image = $_FILES["profil"]["name"];
                        $nom = $_POST['nom'];
                        $prenom = $_POST['prenom'];
                        $date = $_POST['date'];
                        $genre = $_POST['genre'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $passwordCn = $_POST['pwdConf'];
                        $role = 1; // Par défaut, le rôle est défini à 1 (utilisateur)
                        // Préparation de la requête SQL avec des paramètres nommés
                        if ($password === $passwordCn) {
                            $sql = "INSERT INTO users (profil_user, nom_user, prenom_user, genre_user, email_user, password_user, passwordCn_user,daten_user, role_user) VALUES (:profil, :nom, :prenom, :genre, :email, :password,  :passwordCn ,:date, :role)";
                            $stmt = $db->prepare($sql);
                            // Exécution de la requête avec les valeurs des paramètres
                            $stmt->execute(array(
                                ':profil' => $nom_image,
                                ':nom' => $nom,
                                ':prenom' => $prenom,
                                ':genre' => $genre,
                                ':email' => $email,
                                ':password' => $password,
                                ':passwordCn' => $passwordCn,
                                ':date' => $date,
                                ':role' => $role
                            ));

                            header('Location:home.php?action=seConnecter');
                            exit();
                        }  else {
                            $_SESSION['err'] = "Le mot de passe et la confirmation du mot de passe ne correspondent pas.";
                            header('Location:home.php?action=SInscrire');
                        }



                        // Assurez-vous de terminer le script après la redirection
                        /* Les rôles peuvent être définis comme suit :
                 0 - Désactivé
                 1 - Utilisateur normal
                 2 - Administrateur
                 3 - Super Administrateur */
                    }
                }
            } else if ((isset($_GET['action']) && $_GET['action'] == "connecter")) {
                if (empty($_POST['email']) || empty($_POST['password'])) {
                    $_SESSION['err'] = 'Email et mot de passe sont obligatoires!';
                    header('Location: home.php?action=seConnecter');
                    exit();
                } else {
                    $params = [$_POST['email']];
                    $req = "SELECT * FROM users WHERE email_user = ?";
                    $userObj = $db->prepare($req);
                    $userObj->execute($params);

                    $user = $userObj->fetch();

                    if ($_POST['password'] != $user['password_user']) {
                        $_SESSION['err'] = 'Mot de passe ou login incorrect!';
                        header('Location: home.php?action=seConnecter');
                        exit();
                    } else {
                        // User is authenticated, redirect to profile
                        $_SESSION['user'] = $user;; // Assuming you want to store user information in session
                        header('Location: User/index.php');
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
include('inc/footer.php');
include('inc/fin.php');
ob_end_flush();
?>