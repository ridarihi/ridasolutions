<?php
$title = 'Ges-users';
// Inclure les fichiers nécessaires
session_start();
include('../inc/connect.php'); // Inclure le fichier de connexion à la base de données
include 'inc-app/debut-app.php';
include 'inc-app/header-app.php';
include '../inc/fonctions.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$user = $_SESSION['user'];
// Pagination variables

// Pagination variables
$usersPerPage = 10; // Number of users to display per page
$totalUsersQuery = $db->query("SELECT COUNT(*) FROM users");
$totalUsers = $totalUsersQuery->fetchColumn();
$totalPages = ceil($totalUsers / $usersPerPage);

// Get the current page or set a default
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
} else {
    $currentPage = 1;
}

// If current page is greater than total pages, set current page to last page
if ($currentPage > $totalPages) {
    $currentPage = $totalPages;
}

// If current page is less than first page, set current page to first page
if ($currentPage < 1) {
    $currentPage = 1;
}

// The offset of the list, based on current page
$offset = ($currentPage - 1) * $usersPerPage;

if (isset($_GET["action"]) && $_GET["action"] == "edit" && isset($_GET["id_user"])) {

    $id = $_GET["id_user"];

    // Fetch existing user details
    $sql = "SELECT * FROM users WHERE id_user = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':id' => $id));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Handle the case where the user is not found
        echo "User not found.";
        exit();
    }

    // Check if new profile image is uploaded
    $profil_up = isset($_FILES['profil_up']['name']) && !empty($_FILES['profil_up']['name']) ? $_FILES['profil_up']['name'] : $user['profil_user'];
    $nom_up = isset($_POST['nom_up']) ? $_POST['nom_up'] : $user['nom_user'];
    $prenom_up = isset($_POST['prenom_up']) ? $_POST['prenom_up'] : $user['prenom_user'];
    $genre_up = isset($_POST['genre_up']) ? $_POST['genre_up'] : $user['genre_user'];
    $email_up = isset($_POST['email_up']) ? $_POST['email_up'] : $user['email_user'];
    $password_up = isset($_POST['password_up']) && !empty($_POST['password_up']) ? password_hash($_POST['password_up'], PASSWORD_BCRYPT) : $user['password_user'];
    $date_up = isset($_POST['date_up']) ? $_POST['date_up'] : $user['daten_user'];
    $role_up = isset($_POST['role_up']) ? $_POST['role_up'] : $user['role_user'];

    // Move uploaded file if exists
    if (!empty($_FILES['profil_up']['name'])) {
        $target_dir = "../src/images/profils/";
        $target_file = $target_dir . basename($_FILES["profil_up"]["name"]);
        move_uploaded_file($_FILES["profil_up"]["tmp_name"], $target_file);
    }

    // Update user details
    $sql = "UPDATE users SET profil_user = :profil, nom_user = :nom, prenom_user = :prenom, genre_user = :genre, email_user = :email, password_user = :password, daten_user = :date, role_user = :role WHERE id_user = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        ':profil' => $profil_up,
        ':nom' => $nom_up,
        ':prenom' => $prenom_up,
        ':genre' => $genre_up,
        ':email' => $email_up,
        ':password' => $password_up,
        ':date' => $date_up,
        ':role' => $role_up,
        ':id' => $id
    ));

    header('Location:ges-user.php');
    exit();
} else if (isset($_GET["action"]) && $_GET["action"] == "deleted" && isset($_GET["id_user"])) {
    $id = $_GET["id_user"];
    $sql = "DELETE FROM users WHERE id_user=?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location:ges-user.php');
} else if (isset($_GET["action"]) && $_GET["action"] == "add") {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profilNew"])) {
        $target_dir = "../src/images/profils/";
        $target_file = $target_dir . $_FILES["profilNew"]["name"];
        $nom_image = $_FILES["profilNew"]["name"];
        $nom = $_POST['nomNew'];
        $prenom = $_POST['prenomNew'];
        $date = $_POST['dateNew'];
        $genre = $_POST['genreNew'];
        $email = $_POST['emailNew'];
        $password = $_POST['passwordNew'];
        $role = $_POST['roleNew'];

        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email_user = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':email' => $email));
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            // Display error modal if email exists
            $errorMessage = "L'email existe déjà dans la base de données. Veuillez utiliser un autre email.";
            ErrorModal($errorMessage);
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var myModal = new bootstrap.Modal(document.getElementById('errorModal'), {});
                        myModal.show();
                    });
                  </script>";
        } else {
            // Upload image and insert user if email does not exist
            if (move_uploaded_file($_FILES["profilNew"]["tmp_name"], $target_file)) {
                // Prepare and execute SQL statement
                $sql = "INSERT INTO users (profil_user, nom_user, prenom_user, genre_user, email_user, password_user, daten_user, role_user) 
                        VALUES (:profil, :nom, :prenom, :genre, :email, :password, :date, :role)";
                $stmt = $db->prepare($sql);
                $stmt->execute(array(
                    ':profil' => $nom_image,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':genre' => $genre,
                    ':email' => $email,
                    ':password' => $password,
                    ':date' => $date,
                    ':role' => $role
                ));
                // Display success modal
                SuccessModal();
            }
        }
    }
    // Redirection après traitement complet du formulaire
    header('Location: ges-user.php');
    exit();
} else if (isset($_POST['valSearch'])) {
    $valSearch = $_POST['valSearch'];
    $catSearch = isset($_POST['catSerach']) ? $_POST['catSerach'] : 'nom_user';

    $sql = "SELECT * FROM users WHERE $catSearch LIKE :valSearch ORDER BY id_user DESC LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':valSearch', '%' . $valSearch . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', $usersPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If no search is performed, retrieve all users with pagination
    $sql = "SELECT * FROM users ORDER BY id_user DESC LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':limit', $usersPerPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="mb-3 text-center">
                <form method="POST" action="ges-user.php" class="input-group">
                    <!-- Dropdown menu to select the search category -->
                    <select name="catSerach" class="form-select">
                        <option value="id_user">ID</option>
                        <option value="email_user">Email</option>
                        <option value="nom_user">Nom</option>
                        <option value="prenom_user">Prénom</option>
                        <option value="role_user">Rôle</option>
                    </select>

                    <!-- Text field to enter the search term -->
                    <input type="text" class="form-control" id="searchInput" name="valSearch" placeholder="Entrez le terme de recherche">

                    <!-- "Search" button -->
                    <button type="submit" class="btn btn-success ms-2">
                        <i class="bi bi-search"></i> 
                    </button>

                    <!-- Button to cancel the search -->
                    <a href="ges-user.php" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-x"></i> 
                    </a>
                </form>
            </div>


            <!--   <div class="col-lg-6 col-md-8 col-sm-10 col-12 m-2">
                <form class="d-flex" action="user.php?action=search" method="post">
                    <div class="mt-3">
                        <input class="form-control me-2" type="search" name="valSearch" placeholder="Search" aria-label="Search" value="<?= (!isset($valSearch)) ? "" : $valSearch; ?>">
                    </div>
                    <div class="mt-3">
                        <select name="catSerach" class="form-select">
                            <option value="id_user">id</option>
                            <option value="email_user">Email</option>
                            <option value="nom_user">Nom</option>
                            <option value="prenom_user">Prénom</option>
                            <option value="role_user">Rôle</option>
                        </select>
                    </div>
                  
                </form>

            </div> -->

            <div class=" text-end">
                <button class="btn btn-primary m-2" id="addProductButton">
                    <i class="bi bi-plus"></i> Ajouter
                </button>
            </div>


        </div>
    </div>

    <div class="row">
        <div class="col " style="display: none;" id="addProductForm">




            <form action="ges-user.php?action=add" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="file" name="profilNew" id="profilNew" class="form-control" placeholder="Profil">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="text" name="nomNew" id="nomNew" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="text" name="prenomNew" id="prenomNew" class="form-control" placeholder="Prénom" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="date" name="dateNew" id="dateNew" class="form-control" placeholder="Date de naissance" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <select name="genreNew" id="genreNew" class="form-control" required>
                                <option selected disabled value="">Sélectionnez votre genre</option>
                                <option value="homme">Homme</option>
                                <option value="femme">Femme</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <select name="roleNew" id="roleNew" class="form-control" required>
                                <option selected disabled value="">Sélectionnez le role de cette utilisateur</option>
                                <option value="0">Désactivé</option>
                                <option value="1">Client</option>
                                <option value="2">Editor</option>
                                <option value="3">Administrateur</option>

                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="email" name="emailNew" id="emailNew" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="password" name="passwordNew" id="passwordNew" class="form-control" placeholder="Mot de passe" minlength="7" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="password" name="pwdConfNew" id="pwdConfNew" class="form-control" placeholder="Confirmation mot de passe" minlength="7" required>
                        </div>

                    </div>
                    <button class="btn btn-primary float-end">
                        Ajouter </button>





            </form>



        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                        <tr class="text-center">
                            <th>Id</th>
                            <th>Photo</th>
                            <th>Nom et Prénom</th>
                            <th>Email</th>
                            <th>Date de Naissance</th>
                            <th>Rôle</th>
                            <th>Genre</th>

                            <th colspan="2">Actions </th>



                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($result as $row) { ?>
                            <tr>
                                <td><?= $row['id_user'] ?></td>
                                <td><img src="../src/images/profils/<?= $row['profil_user'] ?>" alt="Photo de profil" class="rounded-circle" width="50" height="50" style="object-fit: cover ; object-position:center"></td>
                                <td><?= $row['nom_user'] . " " . $row['prenom_user'] ?></td>
                                <td><?= $row['email_user'] ?></td>
                                <td><?= $row['daten_user'] ?></td>
                                <td><?= $row['role_user'] ?></td>
                                <td><?= $row['genre_user'] ?></td>
                                <?php if ($row['role_user'] !== "4") { ?>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_user'] ?>">
                                            Modifier
                                        </button>
                                    </td>
                                    <?php if ($row['role_user'] !==  "4") { ?>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id_user'] ?>">
                                                Supprimer
                                            </button>
                                        </td> <?php } ?>
                            </tr>


                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $row['id_user'] ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_user'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?= $row['id_user'] ?>">Modifier Utilisateur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="ges-user.php?action=edit&id_user=<?= $row['id_user'] ?>" method="POST" enctype="multipart/form-data">
                                                <div class="col mb-2 text-center">
                                                    <img src="../src/images/profils/<?= $row['profil_user'] ?>" alt="Photo de profil actuelle" class="rounded-circle" width="50" height="50" style="object-fit: cover; object-position: center;">
                                                </div>
                                                <div class="col mb-2">
                                                    <input type="file" name="profil_up" id="profil_up" class="form-control">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" name="nom_up" id="nom_up" class="form-control" placeholder="Nom" value="<?= $row['nom_user'] ?>">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" name="prenom_up" id="prenom_up" class="form-control" placeholder="Prénom" value="<?= $row['prenom_user'] ?>">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="date" name="date_up" id="date_up" class="form-control" placeholder="Date de naissance" value="<?= $row['daten_user'] ?>">
                                                </div>
                                                <div class="mb-2">
                                                    <select name="genre_up" id="genre_up" class="form-control">
                                                        <option selected disabled value="">Sélectionnez votre genre</option>
                                                        <option value="homme" <?= ($row['genre_user'] == 'homme') ? 'selected' : '' ?>>Homme</option>
                                                        <option value="femme" <?= ($row['genre_user'] == 'femme') ? 'selected' : '' ?>>Femme</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="email" name="email_up" id="email_up" class="form-control" placeholder="Email" value="<?= $row['email_user'] ?>">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="password" name="password_up" id="password_up" class="form-control" placeholder="Nouveau mot de passe" minlength="7">
                                                </div>
                                                <div class="mb-2">
                                                    <input type="password" name="passwordCnf_up" id="passwordCnf_up" class="form-control" placeholder="Confirmation mot de passe" minlength="7">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal<?= $row['id_user'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $row['id_user'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $row['id_user'] ?>">Confirmer la suppression</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer l'utilisateur : <?= $row['nom_user'] . " " . $row['prenom_user'] ?> ?
                                            <div class="text-center">
                                                <img src="src/images/closed-trash-bin_17152.png" alt="" height="200rem">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <span class="m-2"><i class="bi bi-x-lg"></i></span>Annuler
                                            </button>
                                            <a href="ges-user.php?action=deleted&id_user=<?= $row['id_user'] ?>" class="btn btn-danger">
                                                <span class="m-2"><i class="bi bi-trash"></i></span>Supprimer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?> </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>






</div>
</div>




<!-- Inclure le pied de page -->
<?php
include('inc-app/footer-app.php');
include('inc-app/fin-app.php');
?>