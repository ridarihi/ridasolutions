<?php
$title = 'Chat';
session_start();
include('../inc/connect.php');// Inclure le fichier de connexion à la base de données
include 'inc-app/debut-app.php';
include 'inc-app/header-app.php';
include '../inc/fonctions.php';


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: login.php?action=seConnecter');
    exit();
}

// Récupérer les informations de l'utilisateur connecté
$user = $_SESSION['user'];


// Récupérer tous les administrateurs
$query = "SELECT * FROM users WHERE role_user = 3 || role_user = 4";
$stmt = $db->prepare($query);
$stmt->execute();
$administrateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1>Interface Administrative - Chat entre Admins</h1>
    <div class="row">
        <!-- Colonne gauche pour la liste des administrateurs -->
        <div class="col-md-3">
            <h2>Liste des Administrateurs</h2>
            <ul class="list-group">
                <?php
                // Afficher la liste des administrateurs
                foreach ($administrateurs as $admin_user) {
                    echo '<li class="list-group-item">' . htmlspecialchars($admin_user['nom_user']) . '</li>';
                }
                ?>
            </ul>
        </div>
        <!-- Colonne droite pour les messages et la communication -->
        <div class="col-md-9">
            <h2>Messages entre Administrateurs</h2>
            <div class="card">
                <div class="card-body">
                    <!-- Formulaire pour envoyer un nouveau message -->
                    <form action="envoyer_message.php" method="POST">
                        <div class="form-group">
                            <label for="destinataire">Destinataire :</label>
                            <select class="form-control" id="destinataire" name="destinataire">
                                <?php
                                // Afficher une liste déroulante des administrateurs pour choisir le destinataire
                                foreach ($administrateurs as $admin_user) {
                                    echo '<option value="' . htmlspecialchars($admin_user['id_user']) . '">' . htmlspecialchars($admin_user['nom_user']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contenu">Message :</label>
                            <textarea class="form-control" id="contenu" name="contenu" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
            <!-- Afficher les messages échangés entre administrateurs -->
            <div class="card mt-3">
                <div class="card-body">
                    <?php
                    // Requête pour récupérer les derniers messages échangés
                    $query_messages = "
                        SELECT m.contenu_msg, m.date_msg, u.nom_user AS expediteur
                        FROM messages m
                        INNER JOIN users u ON m.expediteur_id = u.id_user
                        ORDER BY m.date_msg DESC
                        LIMIT 10";
                    $stmt_messages = $db->prepare($query_messages);
                    $stmt_messages->execute();
                    $messages = $stmt_messages->fetchAll(PDO::FETCH_ASSOC);

                    // Afficher les messages récupérés
                    foreach ($messages as $message) {
                        echo '<div class="alert alert-info">';
                        echo '<strong>' . htmlspecialchars($message['expediteur']) . '</strong> (' . htmlspecialchars($message['date_msg']) . ') : ';
                        echo htmlspecialchars($message['contenu_msg']);
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('inc-app/footer-app.php');
include('inc-app/fin-app.php');
?>