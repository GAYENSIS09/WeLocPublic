<!-- header -->
<?php include_once(".././pages_sections/header.php");?>
<!-- /header -->

<!-- code -->
<?php
if (!isset($_SESSION['user_id'])) {
    die();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $litige = new Litige();
    if (isset($_POST['modifier'])) {
        $litige::update($_POST['id'], [
            'description' =>  $_POST['description'] ?? '',
            'statut' =>  $_POST['statut'] ?? '',
            'date_ouverture' => date('Y-m-d', strtotime($_POST['date_ouverture'])) ?? '',
            'date_cloture' => date('Y-m-d', strtotime($_POST['date_cloture'])) ?? '',
            'solution' =>  $_POST['solution'] ?? '',
        ]);
        header("Location:./DetailPlainte.php?id={$_POST['id']}");
        exit();
    } else if (isset($_POST['supprimer'])) {
        $litige::delete($_POST['id']);
        header("Location:./liste.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $litige = new Litige();
    $data = $litige->get($_GET['id']);

?>

<!-- /code -->

<!-- body -->
<?php include_once(".././pages_sections/body.php");?>
<!-- /body -->

  <!-- code -->
  <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">

                        <div class="col-lg-6 col-md-8 col-sm-12 sub-container card p-4 card-custom mt-4">

                            <div class="card-body">
                                <form action="./DetailPlainte.php" method="post">
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="id_client"><strong>ID Client :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="id_client" name="id_client" disabled class="form-control" min="0" value="<?= $data[0]['id_client'] ?? ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="id_reservation"><strong>ID Réservation :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" id="id_reservation" disabled name="id_reservation" class="form-control" min="0" value="<?= $data[0]['id_reservation'] ?? ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="date_ouverture"><strong>Date Ouverture :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" id="date_ouverture" name="date_ouverture" class="form-control" value="<?= $data[0]['date_ouverture'] ?? ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="date_cloture"><strong>Date Clôture :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <input type="date" id="date_cloture" name="date_cloture" class="form-control" value="<?= $data[0]['date_cloture'] ?? ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="statut"><strong>Statut :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <select id="statut" name="statut" class="form-control">
                                                <?php
                                                $statuts = ['ouvert', 'en_cours', 'resolu', 'ferme'];
                                                foreach ($statuts as $statut) {
                                                    $selected = ($data[0]['statut'] ?? '') == $statut ? 'selected' : '';
                                                    echo "<option value=\"$statut\" $selected>$statut</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="description"><strong>Description :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <textarea id="description" name="description" class="form-control" rows="3"><?= $data[0]['description'] ?? ''; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="solution"><strong>Solution :</strong></label>
                                        </div>
                                        <div class="col-8">
                                            <textarea id="solution" name="solution" class="form-control" rows="3"><?= $data[0]['solution'] ?? ''; ?></textarea>
                                        </div>
                                    </div>



                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?? '';
                                                                        } ?>">

                                    <div class="row mb-3 text-center">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-danger w-100" onclick="if(!confirm('Voulez-vous annuler ?')){event.preventDefault();}" name="supprimer">
                                                <i class="fas fa-times"></i>&nbsp;<strong>Supprimer</strong>
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary w-100" onclick="if(!confirm('Voulez-vous enregistrer cette plainte ?')){event.preventDefault();}" name="modifier">
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
<?php include_once(".././pages_sections/footer.php");?>
<!-- /footer -->