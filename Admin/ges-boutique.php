<?php
$title = 'Boutique';
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


if (!isset($_GET['action'])) { ?>


    <div class="container mt-5">
        <h1 class="mb-4 text-center">Administration de la Boutique</h1>
        <div class="mb-3 text-center">
            <form method="GET" action="ges-boutique.php" class="input-group">
                <!-- Menu déroulant pour sélectionner la catégorie de recherche -->
                <select class="form-select" name="category">
                    <option value="nom_prod">Nom du produit</option>
                    <option value="catégorie_prod">Catégorie du produit</option>
                </select>

                <!-- Champ de texte pour entrer le terme de recherche -->
                <input type="text" class="form-control" id="searchInput" name="searchTerm" placeholder="Entrez le terme de recherche">

                <!-- Bouton "Rechercher" -->
                <button type="submit" class="btn btn-success ms-2">
                    <i class="bi bi-search"></i>
                </button>

                <!-- Bouton pour annuler la recherche -->
                <a href="ges-boutique.php" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-x"></i> 
                </a>
            </form>

        </div>

        <div class=" text-end">
            <button class="btn btn-primary m-2" id="addProductButton">
                <i class="bi bi-plus"></i> Ajouter
            </button>
        </div>


        <!-- Bouton "Ajouter Produit" à côté du formulaire de recherche -->


        <!-- Formulaire d'ajout de produit -->
        <div class="card mb-4" style="display: none;" id="addProductForm">
            <h5 class="card-header">Ajouter un Produit</h5>
            <div class="card-body">
                <form action="ges-boutique.php?action=ajouter" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="img_prod">Image du produit (URL)</label>
                        <input type="file" class="form-control" id="img_prod" name="img_prod" required>
                    </div>
                    <div class="form-group">
                        <label for="nom_prod">Nom du produit</label>
                        <input type="text" class="form-control" id="nom_prod" name="nom_prod" required>
                    </div>
                    <div class="form-group">
                        <label for="des_prod">Description du produit</label>
                        <textarea class="form-control" id="des_prod" name="des_prod" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="categorie_prod">Catégorie du produit</label>
                        <select id="categorie_prod" name="categorie_prod" class=" form-select" required>
                            <option value="tablettes">Tablettes</option>
                            <option value="ordinateurs_bureau">les ordinateurs des bureau</option>
                            <option value="ordinateurs_portables">les ordinateurs portables</option>
                            <option value="tablettes">Tablettes</option>
                            <option value="accessoires">Les accessoires</option>
                            <option value="smartphone">Smartphone</option>
                            <option value="logiciels">Les logiciels</option>
                            <option value="imprimantes">Imprimantes</option>

                        </select>

                    </div>
                    <div class="form-group">
                        <label for="promo_prod">Promotion (en %, laissez vide si aucun)</label>
                        <input type="number" class="form-control" id="promo_prod" name="promo_prod " required>
                    </div>
                    <div class="form-group">
                        <label for="prix_prod">Prix du produit</label>
                        <input type="number" class="form-control" id="prix_ori_prod" name="prix_ori_prod" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="stock_prod">Stock disponible</label>
                        <input type="number" class="form-control" id="stock_prod" name="stock_prod" required>
                    </div>
                    <button type="submit" class="btn btn-primary float-end m-2">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Affichage des produits existants -->


        <!-- Product listing in a card -->
        <div class="card">
            <h5 class="card-header">Liste des Produits</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="text-center align-text-top">
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Catégorie</th>
                                <th>Promotion</th>
                                <th>Prix d'origine</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $limit = 10; // Number of products per page
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;

                            // Get total products count
                            $stmt = $db->query("SELECT COUNT(*) FROM products");
                            $totalProducts = $stmt->fetchColumn();
                            $totalPages = ceil($totalProducts / $limit);

                            // Fetch products with pagination and search functionality
                            if (isset($_GET['searchTerm'])) {
                                $searchTerm = '%' . $_GET['searchTerm'] . '%';
                                $category = isset($_GET['category']) ? $_GET['category'] : 'Nom_prod';

                                if ($category == 'Nom_prod') {
                                    $sql = "SELECT * FROM products WHERE Nom_prod LIKE :searchTerm ORDER BY id_prod DESC LIMIT :limit OFFSET :offset";
                                } elseif ($category == 'catégorie_prod') {
                                    $sql = "SELECT * FROM products WHERE catégorie_prod LIKE :searchTerm ORDER BY id_prod DESC LIMIT :limit OFFSET :offset";
                                } else {
                                    $sql = "SELECT * FROM products WHERE Nom_prod LIKE :searchTerm ORDER BY id_prod DESC LIMIT :limit OFFSET :offset";
                                }

                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
                                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                                $stmt->execute();
                                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            } else {
                                $sql = "SELECT * FROM products ORDER BY id_prod DESC LIMIT :limit OFFSET :offset";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
                                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                                $stmt->execute();
                                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            }

                            // Display products in table rows
                            foreach ($products as $product) { ?>
                                <tr>
                                    <td><img src="../src/images/Images_Produits/<?php echo htmlspecialchars($product['img_prod']); ?>" class="img-thumbnail" style="max-width: 100px;"></td>
                                    <td><?php echo htmlspecialchars($product['Nom_prod']); ?></td>
                                    <td><?php echo htmlspecialchars($product['Des_prod']); ?></td>
                                    <td><?php echo htmlspecialchars($product['catégorie_prod']); ?></td>
                                    <td><?php echo ($product['promo_prod'] ? htmlspecialchars($product['promo_prod']) : 'Aucune'); ?></td>
                                    <td><?php echo htmlspecialchars($product['prix_ori_prod']); ?> DH</td>
                                    <td><?php echo htmlspecialchars($product['Prix_prod']); ?> DH</td>
                                    <td><?php echo htmlspecialchars($product['Stock_prod']); ?></td>
                                    <td>
                                        <!-- Bouton pour ouvrir le modal -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_<?php echo $product['id_prod']; ?>">
                                            Modifier
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal_<?php echo $product['id_prod']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel_<?php echo $product['id_prod']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <!-- En-tête du modal -->
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel_<?php echo $product['id_prod']; ?>">Modifier un produit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <!-- Corps du modal avec le formulaire -->
                                                    <form action="ges-boutique.php?action=modifier&id=<?php echo $product['id_prod']; ?>" method="POST" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="img_prod_existante" value="<?php echo htmlspecialchars($product['img_prod']); ?>">

                                                            <div class="mb-3">
                                                                <label for="img_prod" class="form-label">Image du produit</label>
                                                                <input type="file" class="form-control" id="img_prod" name="img_prod">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nom_prod" class="form-label">Nom du produit</label>
                                                                <input type="text" class="form-control" id="nom_prod" name="nom_prod" value="<?php echo htmlspecialchars($product['Nom_prod']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="des_prod" class="form-label">Description du produit</label>
                                                                <textarea class="form-control" id="des_prod" name="des_prod" rows="3" required><?php echo htmlspecialchars($product['Des_prod']); ?></textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="categorie_prod" class="form-label">Catégorie du produit</label>
                                                                <select id="categorie_prod" name="categorie_prod" class="form-select" required>
                                                                    <option value="tablettes" <?php if ($product['catégorie_prod'] == 'tablettes') echo 'selected'; ?>>Tablettes</option>
                                                                    <option value="ordinateurs_bureau" <?php if ($product['catégorie_prod'] == 'ordinateurs_bureau') echo 'selected'; ?>>Ordinateurs des bureau</option>
                                                                    <option value="ordinateurs_portables" <?php if ($product['catégorie_prod'] == 'ordinateurs_portables') echo 'selected'; ?>>Ordinateurs portables</option>
                                                                    <option value="accessoires" <?php if ($product['catégorie_prod'] == 'accessoires') echo 'selected'; ?>>Accessoires</option>
                                                                    <option value="smartphone" <?php if ($product['catégorie_prod'] == 'smartphone') echo 'selected'; ?>>Smartphone</option>
                                                                    <option value="logiciels" <?php if ($product['catégorie_prod'] == 'logiciels') echo 'selected'; ?>>Logiciels</option>
                                                                    <option value="imprimantes" <?php if ($product['catégorie_prod'] == 'imprimantes') echo 'selected'; ?>>Imprimantes</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="promo_prod" class="form-label">Promotion (en %, laissez vide si aucun)</label>
                                                                <input type="number" class="form-control" id="promo_prod" name="promo_prod" value="<?php echo htmlspecialchars($product['promo_prod']); ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="prix_ori_prod" class="form-label">Prix du produit</label>
                                                                <input type="number" class="form-control" id="prix_ori_prod" name="prix_ori_prod" step="0.01" value="<?php echo htmlspecialchars($product['prix_ori_prod']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stock_prod" class="form-label">Stock disponible</label>
                                                                <input type="number" class="form-control" id="stock_prod" name="stock_prod" value="<?php echo htmlspecialchars($product['Stock_prod']); ?>" required>
                                                            </div>
                                                        </div>

                                                        <!-- Pied du modal avec les boutons -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bouton pour supprimer -->
                                        <a href="ges-boutique.php?action=delete&id=<?php echo $product['id_prod']; ?>" class="btn btn-sm btn-outline-danger m-1">Supprimer</a>
                                    </td>
                                </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Step-by-step navigation (Pagination) -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>




    <?php } else if (isset($_GET['action']) && $_GET['action'] == "ajouter") {

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["img_prod"])) {
        $target_dir = "../src/images/Images_Produits/";
        $target_file = $target_dir . $_FILES["img_prod"]["name"];
        // Vérification de l'upload de l'image
        if (move_uploaded_file($_FILES["img_prod"]["tmp_name"], $target_file)) {
            // Enregistrement du chemin de l'image dans la base de données
            $imgProd = $_FILES["img_prod"]["name"];
            $nomProd = $_POST['nom_prod'];
            $desProd = $_POST['des_prod'];
            $categorieProd = $_POST['categorie_prod'];
            $promoProd = isset($_POST['promo_prod']) ? $_POST['promo_prod'] : 0; // Initialize promoProd to 0 if not set
            $prixOriProd = $_POST['prix_ori_prod'];
            $stockProd = $_POST['stock_prod'];

            // Apply promotional discount if promoProd is not empty and prixOriProd is numeric
            if (!empty($promoProd) && is_numeric($prixOriProd)) {
                $prixProd = $prixOriProd - ($prixOriProd * $promoProd / 100); // Calculate discounted price
            } else {
                $prixProd = $prixOriProd; // Set prixProd to prixOriProd if no promoProd or invalid input
            }

            $req = "INSERT INTO `products`( `img_prod`, `Nom_prod`, `Des_prod`, `catégorie_prod`, `promo_prod`, `prix_ori_prod`,
        `Prix_prod`, `Stock_prod`)  VALUES (:imgProd,  :nomProd , :desProd , :categorieProd , :promoProd,:prixOriProd, :prixProd,  :stockProd) ";
            $objProd = $db->prepare($req);
            $objProd->execute(array(
                ":imgProd" => $imgProd,
                ":nomProd" => $nomProd,
                ":desProd" => $desProd,
                ":categorieProd" => $categorieProd,
                ":promoProd" => $promoProd,
                ":prixOriProd" => $prixOriProd,
                ":prixProd" => $prixProd,
                ":stockProd" => $stockProd
            ));


            header('Location: ges-boutique.php');
            exit();
        }
    }
} else if (isset($_GET['action']) && $_GET['action'] === "delete" && isset($_GET['id'])) {
    $id_prod = $_GET['id'];
    $sql = "DELETE FROM products WHERE id_prod = :id_prod";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id_prod', $id_prod, PDO::PARAM_INT);
    $stmt->execute();
    header('Location: ges-boutique.php'); // Redirect to the same page after deletion
    exit();
} else if (isset($_GET['action']) && $_GET['action'] === "modifier" && isset($_GET['id'])) {
    // Vérifie si la méthode de requête est POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Répertoire cible où sera stockée l'image
        $target_dir = "../src/images/Images_Produits/";

        // Vérifie s'il y a une nouvelle image téléchargée
        if (!empty($_FILES["img_prod"]["tmp_name"])) {
            // Déplacement de la nouvelle image téléchargée vers le répertoire cible
            $target_file = $target_dir . basename($_FILES["img_prod"]["name"]);
            if (move_uploaded_file($_FILES["img_prod"]["tmp_name"], $target_file)) {
                // Utilisation de la nouvelle image téléchargée
                $imgProd = $_FILES["img_prod"]["name"];
            } else {
                // En cas d'échec du téléchargement de l'image, rediriger avec un message d'erreur
                header('Location: ges-boutique.php?error=file_upload_failed');
                exit();
            }
        } else {
            // Aucune nouvelle image téléchargée, utiliser l'image existante du produit
            $imgProd = $_POST['img_prod_existante']; // Assurez-vous que ce champ est défini dans votre formulaire
        }

        // Récupération des autres données du formulaire
        $nomProd = $_POST['nom_prod'];
        $desProd = $_POST['des_prod'];
        $categorieProd = $_POST['categorie_prod'];
        $promoProd = isset($_POST['promo_prod']) ? $_POST['promo_prod'] : 0;
        $prixOriProd = $_POST['prix_ori_prod'];
        $stockProd = $_POST['stock_prod'];

        // Calcul du prix après promotion si la promotion est définie
        if (!empty($promoProd) && is_numeric($promoProd) && is_numeric($prixOriProd)) {
            $prixProd = $prixOriProd - ($prixOriProd * $promoProd / 100);
        } else {
            $prixProd = $prixOriProd;
        }

        // Requête SQL pour mettre à jour le produit dans la base de données
        $req = "UPDATE `products` SET 
            `img_prod` = :imgProd,
            `Nom_prod` = :nomProd,
            `Des_prod` = :desProd,
            `catégorie_prod` = :categorieProd,
            `promo_prod` = :promoProd,
            `prix_ori_prod` = :prixOriProd,
            `Prix_prod` = :prixProd,
            `Stock_prod` = :stockProd
            WHERE id_prod = :id_prod";

        // Préparation et exécution de la requête
        $objProd = $db->prepare($req);
        $objProd->execute(array(
            ":imgProd" => $imgProd,
            ":nomProd" => $nomProd,
            ":desProd" => $desProd,
            ":categorieProd" => $categorieProd,
            ":promoProd" => $promoProd,
            ":prixOriProd" => $prixOriProd,
            ":prixProd" => $prixProd,
            ":stockProd" => $stockProd,
            ":id_prod" => $_GET['id'] // Assurez-vous de récupérer l'ID du produit à modifier via GET ou POST
        ));

        // Redirection vers la page de gestion après la modification
        header('Location: ges-boutique.php');
        exit();
    }
}
    ?>


    <?php
    include('inc-app/footer-app.php');
    include('inc-app/fin-app.php');
    ?>