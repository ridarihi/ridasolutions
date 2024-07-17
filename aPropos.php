<?php
$title = "A Propos";
include('inc/debut.php');
include('inc/header.php');
?>
<style>
    .equipeP {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        margin-bottom: 2rem;
    }

    .equipeP .imgEquipe {
        height: 15rem;
        border-radius: 50%;
    }

    .equipeP .card-body {
        text-align: center;
        padding-top: 1rem;
    }

    legend {
        letter-spacing: 0.2rem;
    }

    .patenaires {
        height: 9rem;
        margin: 2rem;
    }
</style>
<div class="container my-5">
    <div class="row">
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <img src="src/images/brand2.psd" alt="RidaSolutions Logo" class="w-75" />
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div>
                <h1 class="text-secondary text-center">RidaSolutions</h1>
                <p class="fs-5 text-center">
                    RidaSolutions est une société spécialisée dans les domaines du
                    Développement Web, de la Maintenance et Assistance, du Matériel
                    Informatique et de la Consultation. Notre engagement est d'offrir
                    des solutions complètes et personnalisées pour répondre aux
                    besoins technologiques de nos clients, en fournissant des services
                    de haute qualité et une expertise technique inégalée.
                </p>
            </div>
        </div>
    </div>
</div>
<!--   
*****************************************
******************les equipes***********
******************************************
 -->
<div class="container mt-5">
    <div class="row m-1">
        <fieldset class="p-3 sections">
            <legend class="text-center p-3 fw-bold">NOTRE ÉQUIPE</legend>
            <div class="d-flex flex-wrap justify-content-center align-items-center p-1">
                <div class="equipeP m-1" style="max-width: 18rem;">
                    <img src="src/images/NOTRE ÉQUIPE/profil.jpeg" class="imgEquipe img-fluid" alt="Rihi Rida" />
                    <div class="card-body text-center">
                        <h2 class="fs-3">Rihi Rida</h2>
                        <p class="card-text">GENERAL MANAGER</p>
                    </div>
                </div>

                <div class="equipeP m-1" style="max-width: 18rem;">
                    <img src="src/images/NOTRE ÉQUIPE/Driss khaddadi.jpg" class="imgEquipe img-fluid" alt="Khaddadi Driss" />
                    <div class="card-body text-center">
                        <h2 class="fs-3">Khaddadi Driss</h2>
                        <p class="card-text">RESPONSABLE IT</p>
                    </div>
                </div>

                <div class="equipeP m-1" style="max-width: 18rem;">
                    <img src="src/images/NOTRE ÉQUIPE/ilham.jpg" class="imgEquipe img-fluid" alt="Kh. Ilham" />
                    <div class="card-body text-center">
                        <h2 class="fs-3">Kh. Ilham</h2>
                        <p class="card-text">RESPONSABLE COMMERCIAL</p>
                    </div>
                </div>

                <div class="equipeP m-1" style="max-width: 18rem;">
                    <img src="src/images/NOTRE ÉQUIPE/mohamed.jpg" class="imgEquipe img-fluid" alt="Hamraoui M'hammed" />
                    <div class="card-body text-center">
                        <h2 class="fs-3">Hamraoui M'hammed</h2>
                        <p class="card-text">Ingénieur Etudes et Développement</p>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>
<!--   
*****************************************
******************les patner***********
******************************************
 -->
 <div class="container">
        <div class="row">
          <div class="col">
            <fieldset class="p-3 sections">
              <legend class="text-center p-3 fw-bold">PARTNERS</legend>
              <div class="d-flex flex-wrap justify-content-center align-items-center">
                <img src="src/images/PARTENAIRES/pngwing.com.png" alt="" class="patenaires">
                <img src="src/images/PARTENAIRES/pngwing.com (1).png" alt="" class="patenaires">
                <img src="src/images/PARTENAIRES/pngwing.com (2).png" alt="" class="patenaires">

              </div>
            </fieldset>
          </div>
        </div>
      </div>


<?php
include('inc/footer.php');
include('inc/fin.php');
?>