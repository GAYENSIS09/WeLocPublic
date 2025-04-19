<!-- header -->
<?php include_once(".././pages_sections/header.php"); ?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entretien = new Entretien();
    if (!Vehicule::is_id(intval($_POST['id_vehicule']), $_SESSION['agence_id'])) {
        echo 'id_vehicule invalide';
        die();
    }
    $entretien->add([
        'id_Vehicule' => intval($_POST['id_vehicule']),
        'description' => $_POST['description'] ?? '',
        'cout' => floatval($_POST['cout']) ?? '',
        'date' => date('Y-m-d', strtotime($_POST['date'])) ?? '',
        'type_entretien' => $_POST['type_entretien'] ?? '',
        'responsable' => $_POST['responsable']  ?? '',
    ]);
    header("Location:./liste.php");
    exit();
}
?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php"); ?>
<!-- /body -->

<!-- code -->
<div id="layoutSidenav_content">
    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container more-voiture offset-6">
            <div class="row mb-4 align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-12 sub-container card">
                    <form method="post" enctype="multipart/form-data" action="./ajouter.php">
                        <div class="row mb-3">
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="id_vehicule"><strong>ID Véhicule :</strong></label></div>
                            <div class="col-8"><input type="number" id="id_vehicule" class="form-control" name="id_vehicule"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="description"><strong>Description :</strong></label></div>
                            <div class="col-8"><textarea id="description" class="form-control" name="description"></textarea></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-4"><label for="date"><strong>Date :</strong></label></div>
                            <div class="col-8"><input type="date" id="date" class="form-control" name="date"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="type_entretien"><strong>Type d'entretien :</strong></label></div>
                            <div class="col-8">
                                <select id="type_entretien" class="form-control" name="type_entretien">
                                    <option value="vidange">Vidange</option>
                                    <option value="revision">Révision</option>
                                    <option value="reparation">Réparation</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="cout"><strong>Coût :</strong></label></div>
                            <div class="col-8"><input type="number" step="0.01" id="cout" class="form-control" name="cout"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4"><label for="responsable"><strong>Responsable :</strong></label></div>
                            <div class="col-8"><input type="text" id="responsable" name="responsable" class="form-control"></div>
                        </div>

                        <div class="row mb-3 text-center">
                            <div class="col-6"><button type="reset" class="btn btn-danger w-100"><i class="fas fa-times"></i>&nbsp;<strong>Annuler</strong></button></div>
                            <div class="col-6"><button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i>&nbsp;<strong>Enregistrer</strong></button></div>
                        </div>
                    </form>
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