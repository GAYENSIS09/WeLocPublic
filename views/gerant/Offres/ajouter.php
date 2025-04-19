<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offre = new Offre_Locaton();
    if (!Vehicule::is_id(intval($_POST['id_Vehicule']),  $_SESSION['agence_id'])) {
        echo 'id_Vehicule invalide';
        die();
    }
    $offre->add([
        'id_Vehicule' =>  intval($_POST['id_Vehicule']),
        'description' =>  $_POST['description'] ?? '',
        'tarif' =>  floatval($_POST['tarif']) ?? '',
        'date_debut' => date('Y-m-d', strtotime($_POST['date_debut'])),
        'date_fin' => date('Y-m-d', strtotime($_POST['date_fin'])),
        'conditions' =>  $_POST['condition'] ?? '',
    ]);
}
?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Agrandir la carte -->
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="card p-4 shadow-lg">
                        <form method="post" enctype="multipart/form-data" action="">
                            <h3 class="text-center mb-4">Informations de la voiture</h3>

                            <div class="row mb-3">
                                <div class="col-4"><label for="id-voiture"><strong>ID voiture :</strong></label></div>
                                <div class="col-8"><input type="number" id="id-voiture" min="0" class="form-control" value="BMW" name="id_Vehicule"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="date-debut"><strong>Date de début :</strong></label></div>
                                <div class="col-8"><input type="date" id="date-debut" class="form-control" value="2024-02-02" name="date_debut"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><label for="condition"><strong>Condition :</strong></label></div>
                                <div class="col-8"><input type="text" id="condition" class="form-control" value="" name="condition"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="date-fin"><strong>Date de fin :</strong></label></div>
                                <div class="col-8"><input type="date" id="date-fin" class="form-control" value="2024-02-02" name="date_fin"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="prix"><strong>Tarif :</strong></label></div>
                                <div class="col-8"><input type="number" id="prix" class="form-control" value="X" name="tarif"></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="etat"><strong>Détails :</strong></label></div>
                                <div class="col-8"><textarea id="etat" class="form-control" rows="3" name="description"></textarea></div>
                            </div>

                            <!-- Boutons -->
                            <div class="row text-center">
                                <div class="col-6">
                                    <button type="reset" class="btn btn-danger w-100"><i class="fas fa-times"></i> Annuler</button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
<!-- /code -->

<!-- footer -->
<?php include_once(".././pages_sections/footer.php"); ?>
<!-- /footer -->