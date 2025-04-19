<!-- header -->
<?php include_once(".././pages_sections/header.php");?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $promo = new Promotion();
    if (isset($_POST['modifier'])) {
        $promo::update($_POST['id'], [
            'code_promo' => $_POST['code_promo'] ?? '',
            'description' => $_POST['description'] ?? '',
            'reduction' => intval($_POST['reduction']) ?? '',
            'max_utilisations' => intval($_POST['max_utilisations']) ?? '',
            'utilisations' => intval($_POST['utilisations']) ?? '',
            'date_debut' => date('Y-m-d', strtotime($_POST['date_debut'])) ?? '',
            'date_fin' => date('Y-m-d', strtotime($_POST['date_fin'])) ?? '',
        ]);
        header("Location:./DetailPromo.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['supprimer'])) {
        $promo::delete($_POST['id']);
        header("Location:./en-cours.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $promo = new Promotion();
    $data = $promo->get($_GET['id']);


?>
<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php");?>
<!-- /body -->

  <!-- code -->
  <div id="layoutSidenav_content">
                <main class="d-flex justify-content-center align-items-center min-vh-100">
                    <div class="container more-voiture offset-6">
                        <div class="row mb-4 align-items-center">
                            <div class="col-lg-6 col-md-8 col-sm-12 sub-container card">
                                <form method="post" action="./DetailPromo.php">
                                    <div class="row mb-3 mt-1"></div>

                                    <div class="row mb-3">
                                        <div class="col-4"><label for="code_promo"><strong>Code Promo :</strong></label></div>
                                        <div class="col-8"><input type="text" id="code_promo" value="<?= $data[0]['code_promo'] ?>" name="code_promo" class="form-control" maxlength="20" required></div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4"><label for="description"><strong>Description :</strong></label></div>
                                        <div class="col-8"><textarea id="description" name="description" class="form-control"><?= $data[0]['description'] ?? '' ?></textarea></div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4"><label for="reduction"><strong>Réduction (%) :</strong></label></div>
                                        <div class="col-8"><input type="number" id="reduction" name="reduction" class="form-control" step="0.01" min="0" max="100" value="<?= $data[0]['reduction'] ?? '' ?>" required></div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4"><label for="date_debut"><strong>Date de Début :</strong></label></div>
                                        <div class="col-8"><input type="date" id="date_debut" name="date_debut" class="form-control" value="<?= $data[0]['date_debut'] ?? '' ?>" required></div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4"><label for="date_fin"><strong>Date de Fin :</strong></label></div>
                                        <div class="col-8"><input type="date" id="date_fin" name="date_fin" class="form-control" value="<?= $data[0]['date_fin'] ?? '' ?>" required></div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4"><label for="max_utilisations"><strong>Utilisations Maximales :</strong></label></div>
                                        <div class="col-8"><input type="number" id="max_utilisations" name="max_utilisations" class="form-control" min="1" value="<?= $data[0]['max_utilisations'] ?? '1' ?>"></div>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                    <div class="row mb-3">
                                        <div class="col-4"><label for="utilisations"><strong>Utilisations Actuelles :</strong></label></div>
                                        <div class="col-8"><input type="number" id="utilisations" name="utilisations" class="form-control" min="0" value="<?= $data[0]['utilisations'] ?? '0';
                                                                                                                                                        } ?>"></div>
                                    </div>

                                    <div class="row mb-3 text-center">
                                        <div class="col-6"><button type="submit" class="btn btn-danger w-100" name="supprimer"><i class="fas fa-times"></i>&nbsp;<strong>Supprimer</strong></button></div>
                                        <div class="col-6"><button type="submit" name="modifier" class="btn btn-primary w-100"><i class="fas fa-save"></i>&nbsp;<strong>modifier</strong></button></div>
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
<?php include_once(".././pages_sections/footer.php");?>
<!-- /footer -->