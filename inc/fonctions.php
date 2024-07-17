<?php
function logoutUser($user_id, $page)
{
    session_destroy(); // Destroy all session data
    setcookie($user_id, '', time() - 3600, '/'); // Expire the cookie
    direction($page); // Redirect to login page
    exit();
}
function direction($page,$action = "")
{
    header(`Location:$page.php?$action`);
}
function alertError($message, $color)
{
    if (isset($_SESSION['err'])) {
        $message = $_SESSION['err'];
        echo '<div class="alert alert-' . $color . 'alert-dismissible fade show" role="alert">
                    <strong><i class="fa-solid fa-triangle-exclamation"></i></strong> ' . $message . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        unset($_SESSION['err']);
    }
}
function ErrorModal($errorMessage)
{
    echo '
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Erreur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="../src/images/—Pngtree—error button game switch button_5318869.png" alt="Error Image">
                    </div>
                    ' . htmlspecialchars($errorMessage) . '
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>';
}

function SuccessModal($message = "L'utilisateur a été créé avec succès.")
{
    echo '
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Succès</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="../src/images/—Pngtree—check mark icon design template_4085369.png" alt="Success Image">
                    </div>
                    ' . htmlspecialchars($message) . '
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>';
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        myModal.show();
    });
    </script>";
         // Fonction pour générer un mot de passe aléatoire
         function generatePassword($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomPassword = '';
            for ($i = 0; $i < $length; $i++) {
                $randomPassword .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomPassword;
        }
    }
    function affiche($var){
        echo '<pre>';
print_r($var);
echo '</pre>';
    }