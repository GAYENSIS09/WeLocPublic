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
    if (isset($_POST['modifier'])) {
        if (!Vehicule::is_id(intval($_POST['id_vehicule']), $_SESSION['agence_id'])) {
            echo 'id_vehicule invalide';
            die();
        }
        $entretien::update($_POST['id'], [
            'id_Vehicule' => intval($_POST['id_vehicule']),
            'description' => $_POST['description'] ?? '',
            'cout' => floatval($_POST['cout']),
            'date' => date('Y-m-d', strtotime($_POST['date'])) ?? '',
            'type_entretien' => $_POST['type_entretien'] ?? '',
            'responsable' => $_POST['responsable']  ?? '',
        ]);
        header("Location:./DetailEntretien.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['supprimer'])) {
        $entretien::delete($_POST['id']);
        header("Location:./liste.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $entretien = new Entretien();
    $data = $entretien->get($_GET['id']);

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
                        <form method="post" action="./DetailEntretien.php">
                            <div class="row mb-3">

                            </div>
                            <div class="row mb-3">
                                <div class="col-4"><label for="id_vehicule"><strong>ID Véhicule :</strong></label></div>
                                <div class="col-8">
                                    <input type="number" id="id_vehicule" name="id_vehicule" class="form-control" value="<?= $data[0]['id_vehicule'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="description"><strong>Description :</strong></label></div>
                                <div class="col-8">
                                    <textarea id="description" name="description" class="form-control"><?= $data[0]['description'] ?? '' ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="date"><strong>Date :</strong></label></div>
                                <div class="col-8">
                                    <input type="date" id="date" name="date" class="form-control" value="<?= $data[0]['date'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="type_entretien"><strong>Type d'entretien :</strong></label></div>
                                <div class="col-8">
                                    <select id="type_entretien" name="type_entretien" class="form-control">
                                        <?php $enum = ["vidange", "revision", "reparation"];
                                        foreach ($enum as $value) {
                                            $select = ($value == $data[0]['type_entretien']) ? 'selected' : '';
                                            echo "<option value='$value' $select>$value</option>";
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-4"><label for="cout"><strong>Coût :</strong></label></div>
                                <div class="col-8">
                                    <input type="number" step="0.01" id="cout" name="cout" class="form-control" value="<?= $data[0]['cout'] ?? '' ?>">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <div class="row mb-3">
                                <div class="col-4"><label for="responsable"><strong>Responsable :</strong></label></div>
                                <div class="col-8">
                                    <input type="text" id="responsable" name="responsable" class="form-control" value="<?= $data[0]['responsable'] ?? '';
                                                                                                                    } ?>">
                                </div>
                            </div>

                            <div class="row mb-3 text-center">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-danger w-100" name="supprimer">
                                        <i class="fas fa-times"></i>&nbsp;<strong>Supprimer</strong>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100" name="modifier">
                                        <i class="fas fa-edit"></i>&nbsp;<strong>Modifier</strong>
                                    </button>
                                </div>
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