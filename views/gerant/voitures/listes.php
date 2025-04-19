<!-- header -->
<?php include_once(".././pages_sections/header.php");?>
<!-- /header -->

<!-- code -->
<?php
if (isset($_SESSION['user_id'])) {
    $gerant = new Gerant();
    ?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php");?>
<!-- /body -->

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Liste de voitures</h1>
                <ol class="breadcrumb mb-4">
                    <!-- <li class="breadcrumb-item active">user name</li> -->
                </ol>

                <div class="row">

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            voitures
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Année</th>
                                        <th>Type</th>
                                        <th>Disponibilité</th>
                                        <th>plus</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Année</th>
                                        <th>Type</th>
                                        <th>Disponibilité</th>
                                        <th>plus</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                <?php
                                Vehicule::ShowAll($_SESSION['agence_id']);
                            }
                                ?>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div> 

        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy;WeLoc 2025</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
<!-- footer -->
<?php include_once(".././pages_sections/footer.php");?>
<!-- /footer -->