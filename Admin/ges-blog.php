<?php
$title = 'Blog';
// Inclure les fichiers nécessaires
session_start();
include('../inc/connect.php');// Inclure le fichier de connexion à la base de données
include 'inc-app/debut-app.php';
include 'inc-app/header-app.php';
include '../inc/fonctions.php';


if (!isset($_SESSION['user'])) {
    header('Location: login.php?action=seConnecter');
    exit();
}

$user = $_SESSION['user'];


$req = "SELECT * FROM articles";
$objArt = $db->prepare($req);
$objArt->execute();
$articles = $objArt->fetchAll(PDO::FETCH_ASSOC);










?>

<div class="container mt-5">
    <h1 class="mb-4">Administration du Blog</h1>

    <!-- Ajout d'article -->
    <div class="card mb-4">
        <h5 class="card-header">Ajouter un Article</h5>
        <div class="card-body">
            <form action="ajouter_article.php" method="POST">
                <div class="form-group">
                    <label for="titre">Titre de l'article</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="contenu">Contenu de l'article</label>
                    <textarea class="form-control" id="contenu" name="contenu" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Affichage des articles dans un tableau -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Auteur</th>
                    <th>Titre</th>
                    <th>Contenu</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article) : ?>
                    <tr>
                        <td><?= htmlspecialchars($article['auteur_art']) ?></td>
                        <td><?= htmlspecialchars($article['titre_art']) ?></td>
                        <td><?= htmlspecialchars($article['contenu_art']) ?></td>
                        <td><?= htmlspecialchars($article['date_art']) ?></td>
                        <td>
                            <a href="modifier_article.php?id=<?= $article['id_art'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                            <a href="supprimer_article.php?id=<?= $article['id_art'] ?>" class="btn btn-sm btn-outline-danger">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>









<?php
include('inc-app/footer-app.php');
include('inc-app/fin-app.php');
?>