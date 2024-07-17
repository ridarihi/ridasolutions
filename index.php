<?php
include('inc/connect.php');
$title = "Accueil";
include('inc/debut.php');
include('inc/header.php');
?>
<!--
 **********************************************
***********la section carousel ***************
********************************************** 
-->

<section>
    <div id="carouselExampleIndicators" class="carousel slide pt-5">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="src/images/carousel/promo2.jpg" class="d-block w-100 specialImg" alt="..." />
            </div>
            <div class="carousel-item">
                <img src="src/images/carousel/promo1.jpg" class="d-block w-100 specialImg" alt="..." />
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<hr>
<!--
 **********************************************
***********la section boutique ***************
********************************************** 
-->
<section class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h2 class="nameSections text-info pb-3 fw-bolder mb-3"><a href="" class="nav-link">PROMO</a></h2>
        </div>
    </div>
    <div class="row">
        <?php
        $req = "SELECT * FROM products WHERE Prix_prod < prix_ori_prod ORDER BY id_prod DESC LIMIT 4";
        $result = $db->query($req);
        ?>
        <?php while ($promo = $result->fetch()) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card" style="position: relative;">
                    <?php if ($promo['Prix_prod'] < $promo['prix_ori_prod']) { ?>
                        <img src="src/images/16284.jpg" alt="Promo" class="promo" style="position: absolute; top: -35px; right: 0; height: 60px; width: 69px;">
                    <?php } ?>
                    <img src="src/images/Images_Produits/<?= $promo['img_prod'] ?>" class="card-img-top" alt="..." style="height: 15rem; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $promo['Nom_prod'] ?></h5>
                        <div class="prix">
                            <p class="card-text">Prix : <?php echo htmlspecialchars($promo['Prix_prod']); ?> DH</p>
                            <?php if ($promo['Prix_prod'] < $promo['prix_ori_prod']) { ?>
                                <p class="card-text ">Prix original : <del><?php echo htmlspecialchars($promo['prix_ori_prod']); ?> DH</del></p>
                            <?php } ?>
                        </div>
                        <a href="Boutique.php?produit=<?= $promo['id_prod'] ?>" class="btn btn-primary">Voir plus</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</section>
<hr>
<!--
 **********************************************
***********la section Service ***************
********************************************** 
-->
<section class="services">
    <h2 class="nameSections text-info text-center p-4 fw-bolder">SERVICES</h2>
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <img src="src/images/services/Maintenance & Assistance informatique.jpg" class="card-img-top" alt="Maintenance & Assistance">
                    <div class="card-body">
                        <h5 class="card-title">Maintenance & Assistance</h5>
                        <p class="card-text">Chez RidaSolutions, nous comprenons l'importance cruciale de maintenir une présence en ligne parfaitement fonctionnelle dans le paysage numérique actuel...</p>
                        <a href="service.php?maintenance" class="btn btn-primary">Plus</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <img src="src/images/services/Consultation informatique.jpg" class="card-img-top" alt="Consultation informatique">
                    <div class="card-body">
                        <h5 class="card-title">Consultation</h5>
                        <p class="card-text">Chez RidaSolutions, Notre équipe se tient à votre disposition pour toutes questions liées à vos projets informatiques et système de sécurité...</p>
                        <a href="service.php?Consultation" class="btn btn-primary">Plus</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card">
                    <img src="src/images/services/devweb.jpg" class="card-img-top" alt="Développement Web">
                    <div class="card-body">
                        <h5 class="card-title">Développement Web</h5>
                        <p class="card-text">
                            Chez RidaSolutions, nous sommes passionnés par la création de
                            sites web uniques et fonctionnels qui répondent aux besoins
                            spécifiques de nos clients..
                        </p>
                        <a href="service.php?Développement" class="btn btn-primary">Plus</a>
                    </div>
                </div>
            </div>
</section>








<?php
include('inc/footer.php');
include('inc/fin.php');
?>