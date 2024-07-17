<?php
if (isset($_GET["maintenance"])) {
    $title = 'Maintenance & Assistance';
} else if (isset($_GET["Développement"])) {
    $title = 'Développement Web';
} else if (isset($_GET["Consultation"])) {
    $title = 'Consultation';
}
?>

<?php include('inc/debut.php'); ?>
<?php include('inc/header.php'); ?>

<main class="container p-5 mb-3">

    <!--
 *************************************************************
***********la section Maintenance & Assistance ***************
*************************************************************
-->

    <?php if (isset($_GET["maintenance"])) { ?>
        <h2 class="pt-5 text-center">Maintenance & Assistance</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="src/images/services/Maintenance & Assistance informatique.jpg" alt="Maintenance & Assistance" width="300" style="border-radius: 20%; object-fit: cover;" class="p-2 m-4">
                    </div>
                    <div class="col-md-6">
                        <p class="m-4 fs-6">Le service de développement web de RidaSolutions offre des solutions sur mesure pour répondre aux besoins uniques de chaque client. Notre équipe de développeurs qualifiés travaille en étroite collaboration avec les clients pour comprendre leurs objectifs commerciaux et créer des sites web innovants, conviviaux et hautement fonctionnels. Que ce soit pour la conception d'un site vitrine, d'une plateforme e-commerce ou d'une application web complexe, nous mettons notre expertise technique au service de la réussite de votre projet. Avec une approche axée sur la qualité, la fiabilité et la satisfaction client, RidaSolutions est votre partenaire idéal pour mener à bien vos projets de développement web.</p>
                    </div>
                </div>
            </div>
        </div>


        <!--
 *************************************************************
***********la section Développement Web***************
*************************************************************
-->


    <?php } else if (isset($_GET["Développement"])) { ?>
        <h2 class="pt-5 text-center">Développement Web</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="src/images/services/devweb.jpg" alt="Développement Web" width="300" style="border-radius: 20%; object-fit: cover;" class="p-2 m-4">
                    </div>
                    <div class="col-md-6">
                        <p class="m-4 fs-6">Le service de développement web de RidaSolutions offre des solutions
                            sur mesure pour répondre aux besoins uniques de chaque client. Notre équipe de développeurs
                            qualifiés travaille en étroite collaboration avec les clients pour comprendre leurs objectifs
                            commerciaux et créer des sites web innovants, conviviaux et hautement fonctionnels. Que ce soit
                            pour la conception d'un site vitrine, d'une plateforme e-commerce ou d'une application web complexe,
                            nous mettons notre expertise technique au service de la réussite de votre projet. Avec une approche
                            axée sur la qualité, la fiabilité et la satisfaction client, RidaSolutions est votre
                            partenaire idéal pour mener à bien vos projets de développement web.</p>
                    </div>
                </div>
            </div>
        </div>



        <!--
 *************************************************************
***********la section Consultation***************
*************************************************************
-->
    <?php } else if (isset($_GET["Consultation"])) { ?>
        <h2 class="pt-5 text-center">Consultation</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="src/images/services/Consultation informatique.jpg" alt="Consultation informatique" width="300" style="border-radius: 20%; object-fit: cover;" class="p-2 m-4">
                    </div>
                    <div class="col-md-6">
                        <p class="m-4 fs-6">Spécialisée dans la consultation informatique, RidaSolutions propose des solutions innovantes pour répondre aux besoins technologiques de votre entreprise. Forte d'une expertise approfondie dans le domaine de l'informatique et des technologies de l'information, notre équipe de consultants qualifiés offre des services personnalisés allant de la gestion des systèmes informatiques à la cybersécurité en passant par le développement logiciel. Nous travaillons en étroite collaboration avec nos clients pour comprendre leurs défis uniques et développer des stratégies numériques efficaces qui favorisent la croissance et la réussite à long terme. Avec RidaSolutions, votre entreprise est entre de bonnes mains pour naviguer dans le paysage complexe de la technologie informatique.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="text-center">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary text-center" data-bs-toggle="modal" data-bs-target="#serviceModal">
            Demande de service
        </button>
        <!-- Modal -->
        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="serviceModalLabel">Demande de service</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mt-3">
                                <input type="text" class="nom-client form-control" placeholder="Nom et prénom">
                            </div>
                            <div class="mt-3">
                                <input type="text" class="nom-client form-control" placeholder="Téléphone">
                            </div>
                            <div class="mt-3">
                                <select name="" id="" class="form-select">
                                    <option selected>Choisir le service</option>
                                    <option value="Maintenance&Assistance">Maintenance & Assistance</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="DéveloppementWeb">Développement Web</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('inc/fin.php'); ?>
<?php include('inc/footer.php'); ?>