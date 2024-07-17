<?php
$title = 'Tableau de bord';
// Inclure les fichiers nécessaires
session_start();
include('../inc/connect.php'); // Inclure le fichier de connexion à la base de données
include 'inc-app/debut-app.php';
include 'inc-app/header-app.php';
include '../inc/fonctions.php';

if (!isset($_SESSION['user'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];

?>
<style>
    /* General styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
    }

    .dashboard {
        display: flex;
        flex-wrap: wrap;
        /* Allow cards to wrap to the next line */
        justify-content: space-around;
        margin-top: 20px;

    }

    .card {
        flex: 1 1 300px;
        /* Flexible sizing for cards */
        margin: 10px;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
        color: white;
    }

 

    .card-content {
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
    }

    h2 {
        font-size: 36px;
        margin: 10px 0;
    }

    .view-details {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .view-details:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }

    /* Media queries for responsiveness */
    @media (max-width: 768px) {
        .dashboard {
            flex-direction: column;
            /* Stack cards vertically on smaller screens */
        }

        .card {
            flex: 1 1 calc(50% - 20px);
            /* Two cards per row */
        }
    }

    @media (max-width: 480px) {
        .card {
            flex: 1 1 100%;
            /* Full width cards on smaller screens */
        }
    }
</style>

<?php
$req = "SELECT COUNT(*) AS user_count FROM users;";
$stmt = $db->prepare($req);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC); // Assuming PDO is used
$user_count = $result['user_count'];

$sql = "SELECT COUNT(*) AS prod_count FROM products;";
$pro = $db->prepare($sql);
$pro->execute();
$countprod = $pro->fetch(PDO::FETCH_ASSOC); // Fetching the result into $countprod
$prod_count = $countprod['prod_count']; // Assigning the count to $prod_count

$sql = "SELECT COUNT(*) AS art_count FROM articles";
$art = $db->prepare($sql);
$art->execute();
$countart = $art->fetch(PDO::FETCH_ASSOC);
$art_count = $countart['art_count'];


$sql = "SELECT COUNT(*) AS commandes_count FROM commmandes";
$commandes = $db->prepare($sql);
$commandes->execute();
$countCommandes = $commandes->fetch(PDO::FETCH_ASSOC);
$commandes_count = $countCommandes['commandes_count'];

$sql = "SELECT COUNT(*) AS commandes_countT FROM commmandes WHERE statut_commande = 'en Traitement'";
$commandesT = $db->prepare($sql);
$commandesT->execute();
$countCommandesT = $commandesT->fetch(PDO::FETCH_ASSOC);
$commandes_countT = $countCommandesT['commandes_countT'];

$sql = "SELECT COUNT(*) AS commandes_countPe FROM commmandes WHERE statut_commande = 'pas encore'";
$commandesPe = $db->prepare($sql);
$commandesPe->execute();
$countCommandesPe = $commandesPe->fetch(PDO::FETCH_ASSOC);
$commandes_countPe = $countCommandesPe['commandes_countPe'];

$sql = "SELECT COUNT(*) AS commandes_countTerm FROM commmandes WHERE statut_commande = 'Terminé'";
$commandesTerm = $db->prepare($sql);
$commandesTerm->execute();
$countCommandesTerm = $commandesTerm->fetch(PDO::FETCH_ASSOC);
$commandes_countTerm = $countCommandesTerm['commandes_countTerm'];



?>




<div class="dashboard">
    <div class="card bg-primary">
        <div class="card-content">
        
            <span class="card-title">Terminé</span>
            <h2><?= $commandes_countTerm ?></h2>
        </div>
        <a href="ges-commande.php" class="view-details">Plus Details</a>
    </div>
    <div class="card green bg-info">
        <div class="card-content">
        
            <span class="card-title">en traitement</span>
            <h2><?= $commandes_countT ?></h2>
        </div>
        <a href="ges-commande.php" class="view-details">Plus Details</a>
    </div>
    <div class="card bg-danger">
        <div class="card-content">
    
            <span class="card-title">Pas encore</span>
            <h2><?= $commandes_countPe ?></h2>
        </div>
        <a href="ges-commande.php" class="view-details">Plus Details</a>
    </div>
    <div class="card bg-success">
        <div class="card-content">
            <span class="card-title">Les commandes</span>
            <h2><?= $commandes_count ?></h2>

        </div>
        <a href="ges-commande.php" class="view-details">Plus Details</a>
    </div>
    <div class="card bg-secondary">
        <div class="card-content">
            <span class="card-title">Les utilisateurs</span>
            <h2><?= $user_count ?></h2>
        </div>
        <a href="ges-user.php" class="view-details">Plus Details</a>
    </div>
    <div class="card bg-warning">
        <div class="card-content">
            <span class="card-title">Les produits</span>
            <h2><?= $prod_count ?></h2>
        </div>
        <a href="ges-boutique.php" class="view-details">Plus Details</a>
    </div>

</div>
<?php
include('inc-app/footer-app.php');
include('inc-app/fin-app.php');
?>