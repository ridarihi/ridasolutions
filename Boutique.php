<?php
session_start();
ob_start();
$title = 'Boutique';

?>
<?php include('inc/debut.php');
if (isset($_SESSION['user'])) {
    include('User/inc-user/header-user.php'); // Inclure le header pour utilisateur connecté


} else {
    include('inc/header.php'); // Inclure le header par défaut pour les utilisateurs non connectés

}

include('inc/fonctions.php');

?>


<style>
    /* Styles de navigation */
    .nav-cat {
        margin-bottom: 20px;

    }

    .nav-link-cat {
        padding: 10px 15px;
        margin-bottom: 5px;
        border-radius: 5px;
        color: #007bff;
        background-color: #f8f9fa;
        text-align: center;
        transition: background-color 0.3s ease, color 0.3s ease;
        margin: 10px;
    }

    .nav-link-cat.active {
        background-color: #007bff;
        color: white;
    }

    .nav-link-cat.disabled {
        color: #6c757d;
    }

    .nav-link-cat:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

<?php
include 'inc/connect.php'; // Assuming this file contains your database connection code

$limit = 9; // Number of products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$cat_filter = '';
$params = [];
if (isset($_GET['cat'])) {
    if (!empty($_GET['cat']) && $_GET['cat'] !== "promo") {
        $cat_filter = ' WHERE catégorie_prod = :cat';
        $params[':cat'] = $_GET['cat'];
    } else if ($_GET['cat'] == "promo") {
        $cat_filter = ' WHERE Prix_prod < prix_ori_prod';
    }
}


// Query to get total number of products
$stmt = $db->prepare("SELECT COUNT(*) FROM products" . $cat_filter);
$stmt->execute($params);
$totalProducts = $stmt->fetchColumn();
$totalPages = ceil($totalProducts / $limit);

// Fetch products for the current page, optionally filtered by category
$sql = "SELECT * FROM products" . $cat_filter . " ORDER BY id_prod DESC LIMIT :limit OFFSET :offset";
$stmt = $db->prepare($sql);
if (!empty($params)) {
    $stmt->bindParam(':cat', $params[':cat'], PDO::PARAM_STR);
}
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
if (isset($_GET["produit"])) { ?>
    <?php

    $product_id = $_GET["produit"];
    $stmt = $db->prepare('SELECT * FROM products WHERE id_prod = :id');
    $stmt->bindParam(':id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    ?>
    <style>
        /* Ajoutez vos styles personnalisés ici si nécessaire */
        .product-img {
            max-width: 80%;
            height: auto;
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <h2 class="mb-4 mt-5 text-center">Détails du Produit</h2>
                <a href="Boutique.php" class="btn btn-danger float-end m-2"><i class="bi bi-x-circle"></i></a>
            </div>
        </div>

        <div class="row d-flex justify-content-center align-items-center">
            <!-- Colonne pour l'image du produit -->
            <div class="col-lg-6 ">
                <img src="src/images/Images_Produits/<?php echo htmlspecialchars($product['img_prod']); ?>" alt="<?php echo htmlspecialchars($product['Nom_prod']); ?>" class="img-fluid product-img">
            </div>

            <!-- Colonne pour les informations du produit -->
            <div class="col-lg-6">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Nom</th>
                            <td><?php echo htmlspecialchars($product['Nom_prod']); ?></td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td><?php echo htmlspecialchars($product['Des_prod']); ?></td>
                        </tr>
                        <tr>
                            <th>Catégorie</th>
                            <td><?php echo htmlspecialchars($product['catégorie_prod']); ?></td>
                        </tr>
                        <tr>
                            <th>Prix</th>
                            <td><?php echo htmlspecialchars($product['Prix_prod']); ?> DH</td>
                        </tr>
                        <tr>
                            <th>Stock</th>
                            <td><?php echo htmlspecialchars($product['Stock_prod']); ?></td>
                        </tr>
                    </table>
                </div>


                <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Commander
                </button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Commander le produit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="orderForm" action="Boutique.php?Commander=<?= $product['id_prod'] ?>" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="NomClient" class="form-label">Votre Nom</label>
                                    <input type="text" class="form-control" id="NomClient" name="NomClient" <?= (isset($user['nom_user'])) ? "value='" . $user['nom_user'] . "'" . " " . "disabled" : ""; ?>>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prenomClient" class="form-label">Votre Prénom</label>
                                    <input type="text" class="form-control" id="prenomClient" name="prenomClient" <?= (isset($user['prenom_user'])) ? "value='" . $user['prenom_user'] . "'" . " " . "disabled" : ""; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="emailClient" class="form-label">Votre Email</label>
                                    <input type="email" class="form-control" id="emailClient" name="emailClient" <?= (isset($user['email_user'])) ? "value='" . $user['email_user'] . "'" . " " . "disabled" : ""; ?>>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="numClient" class="form-label">Votre Numéro</label>
                                    <input type="text" class="form-control" id="numClient" name="numClient" <?= (isset($user['num_user']) && $user['num_user'] !== "") ? "value='" . $user['num_user'] . "'" . " " . "disabled" : ""; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Nom du produit</label>
                                    <input type="text" class="form-control" id="productName" value="<?= htmlspecialchars($product['Nom_prod']); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productPrice" class="form-label">Prix</label>
                                    <input type="text" class="form-control" id="productPrice" value="<?= htmlspecialchars($product['Prix_prod']); ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="Catégorie" class="form-label">Catégorie</label>
                                    <input type="text" class="form-control" id="Catégorie" value="<?= htmlspecialchars($product['catégorie_prod']); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantité</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                                </div>
                            </div>
                        </div>

                        <!-- Additional fields can be added as needed -->

                        <input type="hidden" name="productId" value="<?= $product['id_prod']; ?>">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Confirmer la commande</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
<?php } else if (isset($_GET['Commander'])) {
    $st_Commander = $_GET['Commander'];

    if (isset($_SESSION['user'])) {
        $idCclient = $_SESSION['user']['id_user'];
    } else {
        $email = $_POST['emailClient'];
        $check_email = "SELECT COUNT(*) FROM users WHERE email_user = :email";
        $objEmail = $db->prepare($check_email);
        $objEmail->execute(array(':email' => $email));
        $email_exists = $objEmail->fetchColumn();

        if (!isset($_SESSION['user']) && $email_exists == 0) {
            $nom_image = "lofi.jpg"; // Image par défaut
            $nom = $_POST['NomClient'];
            $prenom = $_POST['prenomClient'];
            $num = $_POST['numClient'];
            $dateNaissance = "ancun"; // À ajuster si possible
            $genre = "ancun"; // À ajuster si possible
            $role = '2'; // Rôle par défaut pour un nouveau client
            $password = "Mery2001"; // Hash du mot de passe

            // Insérer le nouvel utilisateur dans la base de données
            $req = "INSERT INTO users (profil_user, nom_user, prenom_user, genre_user, email_user, num_user, password_user, daten_user, role_user)
                VALUES (:profil, :nom, :prenom, :genre, :email, :num, :password, :date, :role)";
            $stmt = $db->prepare($req);
            $result = $stmt->execute(array(
                ':profil' => $nom_image,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':genre' => $genre,
                ':email' => $email,
                ':num' => $num,
                ':password' => $password,
                ':date' => $dateNaissance,
                ':role' => $role
            ));

            if ($result) {
                // Récupérer l'ID de l'utilisateur nouvellement inséré
                $get_id = "SELECT id_user FROM users WHERE email_user = :email";
                $objID = $db->prepare($get_id);
                $objID->execute(array(':email' => $email));
                $get_user = $objID->fetch(PDO::FETCH_ASSOC);

                // Stocker les informations de l'utilisateur en session
                $_SESSION['user'] = array(
                    'id_user' => $get_user['id_user'],
                    'prenom_user' => $prenom,
                    'nom_user' => $nom,
                    'genre_user' => $genre,
                    'daten_user' => $dateNaissance,
                    'email_user' => $email,
                    'password_user' => $password, // Mot de passe hashé
                    'profil_user' => $nom_image,
                    'role_user' => $role
                );
            }
            $_SESSION['succ'] = 'Pour bien commander sur RIDASOLUTIONS, veuillez remplir les informations suivantes.';

            header("Location: User/index.php?u=otp");
            exit; // Terminer le script après la redirection
        } else {
            $_SESSION['err'] = 'Pour commender connecter voter compte';
            header("Location: home.php?action=seConnecter");
            exit; // Terminer le script après la redirection
        }
    }

    // Insérer la commande dans la table des commandes
    $req_commander = "INSERT INTO commmandes (client_commande, st_commande, statut_commande, service_commande)
       VALUES (:client, :st_command, :status, :service)";
    $stmt_commander = $db->prepare($req_commander);
    $stmt_commander->execute(array(
        ':client' => $idCclient,
        ':st_command' => $st_Commander,
        ':status' => 'pas encore',
        ':service' => 'produit'
    ));
    $_SESSION['succ'] = 'La commande a été effectuée.';

    header("Location: User/user-commande.php");
}
else { ?>

    <main class="container pt-5 mt-4">

        <div class="row">


            <div class="col-12 col-lg-3">
                <div class="col">
                    <h3>Toutes les catégories</h3>
                </div>
                <nav class="nav flex-row nav-cat flex-lg-column ">
                    <a class=" d-block nav-link nav-link-cat <?php echo !isset($_GET['cat']) ? 'active' : ''; ?>" aria-current="page" href="?">Toutes les catégories</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'promo' ? 'active' : ''; ?>" href="?cat=promo">PROMO</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'accessoires' ? 'active' : ''; ?>" href="?cat=accessoires">Accessoires</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'imprimantes' ? 'active' : ''; ?>" href="?cat=imprimantes">Imprimantes</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'logiciels' ? 'active' : ''; ?>" href="?cat=logiciels">Logiciels</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'tablettes' ? 'active' : ''; ?>" href="?cat=tablettes">Tablettes</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'smartphone' ? 'active' : ''; ?>" href="?cat=smartphone">Smartphone</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'ordinateurs_bureau' ? 'active' : ''; ?>" href="?cat=ordinateurs_bureau">Ordinateurs du bureau</a>
                    <a class="nav-link nav-link-cat <?php echo isset($_GET['cat']) && $_GET['cat'] == 'ordinateurs_portables' ? 'active' : ''; ?>" href="?cat=ordinateurs_portables">Ordinateurs portables</a>

                </nav>



            </div>
            <div class="col">
                <h3 class="text-center">Les produits</h3>
                <div class="row">
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100" style="position: relative;">
                                <?php if ($row['Prix_prod'] < $row['prix_ori_prod']) { ?>
                                    <img src="src/images/16284.jpg" alt="Promo" class="promo" style="position: absolute; top: -35px; right: 0; height: 60px; width: 69px;">
                                <?php } ?>
                                <img src="src/images/Images_Produits/<?php echo htmlspecialchars($row['img_prod']); ?>" class="card-img-top img-fluid" style="object-fit: cover; height: 150px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['Nom_prod']); ?></h5>
                                    <div class="prix">
                                        <p class="card-text">Prix : <?php echo htmlspecialchars($row['Prix_prod']); ?> DH</p>
                                        <?php if ($row['Prix_prod'] < $row['prix_ori_prod']) { ?>
                                            <p class="card-text ">Prix original : <del><?php echo htmlspecialchars($row['prix_ori_prod']); ?> DH</del></p>
                                        <?php } ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <a href="Boutique.php?produit=<?= $row['id_prod'] ?>" class="btn btn-primary">Voir plus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i;
                                                                    echo isset($_GET['cat']) ? '&cat=' . $_GET['cat'] : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>

    <?php } ?>









    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="confirmationModalLabel">Confirmation de la commande</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Votre commande a été confirmée avec succès.</p>
                    <p>Merci pour votre achat!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Inclure le pied de page -->
    <?php

    include 'inc/fin.php'; ?>
    <?php include 'inc/footer.php';
    ob_end_flush(); ?>